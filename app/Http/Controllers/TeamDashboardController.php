<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Client;
use App\Models\Application;
use Illuminate\Support\Facades\Auth;

class TeamDashboardController extends Controller
{
   public function index()
{
    $user = Auth::user();

    if ($user->role !== 'team') {
        abort(403);
    }

    // Tasks assigned to this team member
    $tasks = Task::with('client')
        ->where('assigned_to_id', $user->id)
        ->orderBy('created_at', 'desc')
        ->get();

    $totalTasks        = $tasks->count();
    $activeTasks       = $tasks->where('is_active', true)->count();
    $completedTasks    = $tasks->where('status', 'done')->count();
    $totalApplications = $tasks->sum('completed_applications');

    // Clients assigned to this user (from tasks)
    $assignedClientIds = $tasks->pluck('client_id')->unique()->values();
    $assignedClients   = Client::whereIn('id', $assignedClientIds)->get();

    // Applications by this user, only for assigned clients
    $applications = Application::with('client')
        ->where('team_id', $user->id)
        ->when($assignedClientIds->isNotEmpty(), function ($query) use ($assignedClientIds) {
            $query->whereIn('client_id', $assignedClientIds);
        })
        ->orderByDesc('applied_on')
        ->orderByDesc('created_at')
        ->get();

    return view('team.dashboard', compact(
        'tasks',
        'totalTasks',
        'activeTasks',
        'completedTasks',
        'totalApplications',
        'applications',
        'assignedClients'
    ));
}

}
