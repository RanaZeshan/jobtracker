<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clients = Client::latest()->get();

        return view('admin.clients.index', compact('clients'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.clients.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $validated = $request->validate([
        'name'         => 'required|string|max:255',
        'email'        => 'nullable|email|unique:Clients,email|max:255',
        'phone'        => 'nullable|string|max:50',
        'linkedin_url' => 'nullable|url|max:255',
        'notes'        => 'nullable|string',
        '_form'        => 'nullable|string',
        'sheet_url'    => 'nullable|string|max:500',
    ]);
    $googleSheetId = $this->extractSheetId($validated['sheet_url'] ?? null);
    unset($validated['sheet_url']);
        $validated['google_sheet_id'] = $googleSheetId;

   
     // Create the client first
       $client = Client::create($validated);
       $sheetMessage = $googleSheetId
            ? ' Sheet linked.'
            : ' No sheet linked yet.';

    try {
        // Try to create a Google Sheet for this client
        $sheetTitle    = $client->name;
        $spreadsheetId = $sheetsService->createClientSpreadsheet($sheetTitle);

        // Save the spreadsheet ID on the client
        $client->google_sheet_id = $spreadsheetId;
        $client->save();

        $sheetMessage = 'Spreadsheet linked.';
    } catch (\Throwable $e) {
        // Just log the error, don’t crash the page
        \Log::error('Failed to create Google Sheet for client ID '.$client->id.': '.$e->getMessage());
        $sheetMessage = 'Spreadsheet could not be created (Google permission error).';
    }

    return redirect()
        ->route('admin.dashboard')
        ->with('success', 'Client created successfully. '.$sheetMessage);
}
        

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Client $client)
    {
        return view('admin.clients.edit', compact('client'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Client $client)
    {
        $data = $request->validate([
            'name'         => 'required|string|max:255',
            'email'        => 'nullable|email|max:255',
            'phone'        => 'nullable|string|max:50',
            'linkedin_url' => 'nullable|url|max:255',
            'notes'        => 'nullable|string',
            'sheet_url'    => 'nullable|string|max:500',
        ]);

        $client->update($data);

        return redirect()->route('admin.dashboard')
    ->with('success', 'Client Updated successfully.');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Client $client)
    {
        $client->delete();

        return redirect()->route('admin.dashboard')
    ->with('success', 'Client Deleted successfully.');

    }

    /**
     * Pause applications for a client
     */
    public function pause(Client $client)
    {
        $client->update(['application_status' => 'paused']);

        return redirect()->route('admin.dashboard')
            ->with('success', "Applications paused for {$client->name}. Team members cannot add new applications.");
    }

    /**
     * Resume applications for a client
     */
    public function resume(Client $client)
    {
        $client->update(['application_status' => 'active']);

        return redirect()->route('admin.dashboard')
            ->with('success', "Applications resumed for {$client->name}. Team members can now add applications.");
    }

private function extractSheetId(?string $value): ?string
    {
        if (!$value) {
            return null;
        }

        $value = trim($value);

        // URL like: https://docs.google.com/spreadsheets/d/ID/edit#gid=0
        if (preg_match('#/d/([a-zA-Z0-9-_]+)#', $value, $m)) {
            return $m[1];
        }

        // If it looks like an ID already (only allowed chars)
        if (preg_match('#^[a-zA-Z0-9-_]+$#', $value)) {
            return $value;
        }

        // Could not parse
        return null;
    }




    
}
