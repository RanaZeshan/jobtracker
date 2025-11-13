<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Task;
use App\Models\Client;
use App\Services\GoogleSheetsService;   // 👈 add this
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;



class TeamApplicationController extends Controller
{

    public function create()
{
   abort(404);
}

public function indexByClient(Client $client)
{
    $user = Auth::user();

    if (!$user || $user->role !== 'team') {
        abort(403);
    }

    // Get the task for this client and team member
    $task = Task::where('assigned_to_id', $user->id)
        ->where('client_id', $client->id)
        ->where('is_active', true)
        ->first();

    if (!$task) {
        abort(403); // not allowed to view apps for unassigned client
    }

    // Only this team member's applications for this client
    $applications = Application::where('client_id', $client->id)
        ->where('team_id', $user->id)
        ->orderByDesc('applied_on')
        ->orderByDesc('created_at')
        ->get();

    return view('team.applications.index', compact('client', 'applications', 'task'));
}








public function createForClient(Client $client)
{
    $user = Auth::user();

    if (!$user || $user->role !== 'team') {
        abort(403);
    }

    // Get the task for this client and team member
    $task = Task::where('assigned_to_id', $user->id)
        ->where('client_id', $client->id)
        ->where('is_active', true)
        ->first();

    if (!$task) {
        abort(403); // not allowed to add apps for unassigned client
    }

    $applications = Application::where('client_id', $client->id)
        ->where('team_id', $user->id)
        ->orderByDesc('applied_on')
        ->orderByDesc('created_at')
        ->get();

    return view('team.applications.create', compact('client', 'applications', 'task'));
}


    /**
     * Store a new application created by a team member.
     */



   public function store(Request $request, GoogleSheetsService $sheetsService)
{
    $user = Auth::user();

    if (!$user || $user->role !== 'team') {
        abort(403);
    }

    // Get all client_ids assigned to this team member via tasks
    $assignedClientIds = Task::where('assigned_to_id', $user->id)
        ->pluck('client_id')
        ->unique()
        ->toArray();

    $validated = $request->validate([
        'client_id'           => 'required|integer|in:' . implode(',', $assignedClientIds),
        'job_title'           => 'required|string|max:120',
        'company_applied_to'  => 'required|string|max:120',
        'job_link'            => 'nullable|url|max:255',
        'source_site'         => 'nullable|string|max:120',
        'location'            => 'nullable|string|max:120',
        'status'              => 'nullable|string|max:30',
        'tailored_resume'     => 'nullable|boolean',
        'resume_file'         => 'nullable|file|mimes:pdf,doc,docx|max:4096',
    ],
    [
        'client_id.in'  => 'You can only add applications for clients assigned to you.',
        'resume_file.mimes' => 'Resume must be a PDF or Word document.',
    ]);

    // Check if client applications are paused
    $client = Client::find($validated['client_id']);
    if ($client && $client->application_status === 'paused') {
        return back()
            ->withErrors(['client_id' => 'Applications for this client are currently paused by the admin.'])
            ->withInput();
    }

    // Check application limit for this client
    $task = Task::where('assigned_to_id', $user->id)
        ->where('client_id', $validated['client_id'])
        ->where('is_active', true)
        ->first();

    // Check if this specific task is paused
    if ($task && $task->is_paused) {
        return back()
            ->withErrors(['client_id' => 'You have been paused from adding applications for this client. Please contact the admin.'])
            ->withInput();
    }

    if ($task && $task->application_limit) {
        $currentCount = Application::where('client_id', $validated['client_id'])
            ->where('team_id', $user->id)
            ->count();

        if ($currentCount >= $task->application_limit) {
            return back()
                ->withErrors(['client_id' => "You have reached the application limit ({$task->application_limit}) for this client."])
                ->withInput();
        }
    }

    $tailoredResume = $request->has('tailored_resume');

    // If tailored resume is checked but no file uploaded, force an error
    if ($tailoredResume && !$request->hasFile('resume_file')) {
        return back()
            ->withErrors(['resume_file' => 'Please upload the tailored resume file.'])
            ->withInput();
    }

    // Calculate earning
    $baseEarning   = 20.0;
    $tailoredBonus = 20.0;
    $earning       = $baseEarning + ($tailoredResume ? $tailoredBonus : 0.0);

    // Handle resume file upload (if provided)
    $resumePath = null;
    if ($tailoredResume && $request->hasFile('resume_file')) {
        $file      = $request->file('resume_file');
        $timestamp = now()->format('Ymd_His');

        // Build base name from company + job title + timestamp
        $baseName = Str::slug(
            $validated['company_applied_to'] . '_' .
            $validated['job_title'] . '_' .
            $timestamp
        );

        $extension = $file->getClientOriginalExtension();
        $fileName  = $baseName . '.' . $extension;

        // Store in "public/resumes" (storage/app/public/resumes)
        $resumePath = $file->storeAs('resumes', $fileName, 'public');
    }
    // 🚫 Prevent duplicate applications for the same client (CHECK BEFORE CREATING)
    $duplicateQuery = Application::where('client_id', $validated['client_id']);

    // If a job link is provided, check duplicates by job_link
    if (!empty($validated['job_link'])) {
        $duplicateQuery->where(function ($q) use ($validated) {
            $q->where('job_link', $validated['job_link'])
              ->orWhere(function ($q2) use ($validated) {
                  $q2->where('company_applied_to', $validated['company_applied_to'])
                     ->where('job_title', $validated['job_title']);
              });
        });
    } else {
        // No job_link: compare by company + job title
        $duplicateQuery->where('company_applied_to', $validated['company_applied_to'])
                       ->where('job_title', $validated['job_title']);
    }

    $alreadyExists = $duplicateQuery->exists();

    if ($alreadyExists) {
        return back()
            ->withErrors([
                'job_link' => 'This application (company + job title or job link) is already added for this client.',
            ])
            ->withInput();
    }

    $sheetRowKey = (string) Str::uuid();

    // Create the application
    $application = Application::create([
        'client_id'          => $validated['client_id'],
        'team_id'            => $user->id,
        'job_title'          => $validated['job_title'],
        'company_applied_to' => $validated['company_applied_to'],
        'job_link'           => $validated['job_link'] ?? null,
        'source_site'        => $validated['source_site'] ?? null,
        'location'           => $validated['location'] ?? null,
        'status'             => $validated['status'] ?? 'submitted',
        'applied_on'         => now(),
        'earning'            => $earning,
        'tailored_resume'    => $tailoredResume,
        'resume_file'        => $resumePath, // store path relative to disk
        'sheet_row_key'      => $sheetRowKey,
    ]);


    // Update related task's completed_applications
    $task = Task::where('client_id', $application->client_id)
        ->where('assigned_to_id', $user->id)
        ->where('is_active', true)
        ->orderBy('id')
        ->first();

    if ($task) {
        $task->increment('completed_applications');

        if ($task->target_applications > 0 &&
            $task->completed_applications >= $task->target_applications) {
            $task->status = 'done';
            $task->save();
        }
    }

    // Append row to Google Sheet if client has linked sheet id (unchanged)
    $client = Client::find($application->client_id);

    if ($client && $client->google_sheet_id) {
        try {
            $row = [
                $sheetRowKey,                         // Unique id for deletions
                       // Date
                
                
                $application->job_title,              // Job title
                $application->company_applied_to,     // Company
                 $application->source_site,  
                $application->job_link,               // Job link
                         // Source site
                $application->location,               // Location
                $application->status,                 // Status
               // $application->tailored_resume ? 'Yes' : 'No', // Tailored resume
                 now()->format('Y-m-d'), 
                 $user->name,                          // Team member
                
            ];

            $sheetsService->appendApplicationRow(
                $client->google_sheet_id,
                $row
            );
        } catch (\Throwable $e) {
            \Log::error('Failed to append application row for client '.$client->id.': '.$e->getMessage());
        }
    }

    return redirect()
        ->route('team.clients.applications.create', $application->client_id)
        ->with('success', 'Application added successfully.');

}

    public function destroy(Application $application, GoogleSheetsService $sheetsService)
{
    $user = Auth::user();

    if (!$user || $user->role !== 'team') {
        abort(403);
    }

    // Ensure this application belongs to this team member
    if ($application->team_id !== $user->id) {
        abort(403);
    }

    $client = Client::find($application->client_id);
    
    // Check if client is paused
    if ($client && $client->application_status === 'paused') {
        return back()->with('error', 'Cannot delete applications for a paused client.');
    }
    
    // Check if task is paused
    $task = Task::where('client_id', $application->client_id)
        ->where('assigned_to_id', $user->id)
        ->where('is_active', true)
        ->first();
        
    if ($task && $task->is_paused) {
        return back()->with('error', 'Cannot delete applications while your task is paused.');
    }

    // Delete from Google Sheet if possible
    if ($client && $client->google_sheet_id && $application->sheet_row_key) {
        try {
            $sheetsService->deleteRowsByKey($client->google_sheet_id, $application->sheet_row_key);
        } catch (\Throwable $e) {
            \Log::error('Failed to delete row from sheet for application '.$application->id.': '.$e->getMessage());
        }
    }

    // Decrement completed_applications on task (if > 0)
    $task = Task::where('client_id', $application->client_id)
        ->where('assigned_to_id', $user->id)
        ->where('is_active', true)
        ->orderBy('id')
        ->first();

    if ($task && $task->completed_applications > 0) {
        $task->decrement('completed_applications');
    }

    $clientId = $application->client_id;
    $application->delete();

    return redirect()
        ->route('team.clients.applications.create', $clientId)
        ->with('success', 'Application deleted successfully.');
}

/**
 * Bulk delete applications for a given client by this team member.
 */
public function bulkDestroy(Request $request, Client $client, GoogleSheetsService $sheetsService)
{
    $user = Auth::user();

    if (!$user || $user->role !== 'team') {
        abort(403);
    }

    // Ensure this client is assigned to this team member
    $task = Task::where('assigned_to_id', $user->id)
        ->where('client_id', $client->id)
        ->where('is_active', true)
        ->first();

    if (!$task) {
        abort(403);
    }
    
    // Check if client is paused
    if ($client->application_status === 'paused') {
        return back()->with('error', 'Cannot delete applications for a paused client.');
    }
    
    // Check if task is paused
    if ($task->is_paused) {
        return back()->with('error', 'Cannot delete applications while your task is paused.');
    }

    $ids = $request->input('application_ids', []);

    if (!is_array($ids) || empty($ids)) {
        return back()
            ->withErrors(['applications' => 'Please select at least one application to delete.']);
    }

    $applications = Application::whereIn('id', $ids)
        ->where('client_id', $client->id)
        ->where('team_id', $user->id)
        ->get();

    if ($applications->isEmpty()) {
        return back()
            ->withErrors(['applications' => 'No valid applications selected.']);
    }

    foreach ($applications as $application) {
        // Delete from Google Sheet
        if ($client->google_sheet_id && $application->sheet_row_key) {
            try {
                $sheetsService->deleteRowsByKey($client->google_sheet_id, $application->sheet_row_key);
            } catch (\Throwable $e) {
                \Log::error('Failed to delete row from sheet for application '.$application->id.': '.$e->getMessage());
            }
        }

        // Decrement completed_applications
        $task = Task::where('client_id', $client->id)
            ->where('assigned_to_id', $user->id)
            ->where('is_active', true)
            ->orderBy('id')
            ->first();

        if ($task && $task->completed_applications > 0) {
            $task->decrement('completed_applications');
        }

        $application->delete();
    }

    return back()->with('success', 'Selected applications deleted successfully.');
}














}
