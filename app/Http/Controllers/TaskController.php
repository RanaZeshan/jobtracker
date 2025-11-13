<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Client;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    /**
     * Store a new task (assignment of client to team member).
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        // Only admin can assign tasks
        if (!$user || $user->role !== 'admin') {
            abort(403);
        }

        $data = $request->validate([
            'client_id'           => 'required|exists:clients,id',
            'assigned_to_id'      => 'required|exists:users,id',
            'description'         => 'required|string|max:1000',
            'target_applications' => 'nullable|integer|min:0',
            'application_limit'   => 'nullable|integer|min:1',
        ]);

        // Ensure assignee is a team member, not another admin
        $assignee = User::findOrFail($data['assigned_to_id']);
        if ($assignee->role !== 'team') {
            return redirect()
                ->route('admin.dashboard')
                ->with('success', 'Only team members can be assigned tasks.');
        }

        // Create the task
        Task::create([
            'client_id'           => $data['client_id'],
            'assigned_to_id'      => $data['assigned_to_id'],
            'description'         => $data['description'],
            'target_applications' => $data['target_applications'] ?? 0,
            'application_limit'   => $data['application_limit'] ?? null,
            'completed_applications' => 0,
            'is_active'           => true,
            'status'              => 'todo',
            'date_created'        => now(),
        ]);

        return redirect()
            ->route('admin.dashboard')
            ->with('success', 'Task created and client assigned to team member.');
    }

    /**
     * Pause a task (prevent team member from adding applications)
     */
    public function pause(Task $task)
    {
        $user = Auth::user();

        if (!$user || $user->role !== 'admin') {
            abort(403);
        }

        $task->update(['is_paused' => true]);

        $teamMemberName = $task->assignee->name ?? 'Team member';
        $clientName = $task->client->name ?? 'this client';

        return redirect()
            ->back()
            ->with('success', "{$teamMemberName} has been paused from adding applications for {$clientName}.");
    }

    /**
     * Resume a task (allow team member to add applications again)
     */
    public function resume(Task $task)
    {
        $user = Auth::user();

        if (!$user || $user->role !== 'admin') {
            abort(403);
        }

        $task->update(['is_paused' => false]);

        $teamMemberName = $task->assignee->name ?? 'Team member';
        $clientName = $task->client->name ?? 'this client';

        return redirect()
            ->back()
            ->with('success', "{$teamMemberName} can now add applications for {$clientName}.");
    }
}
