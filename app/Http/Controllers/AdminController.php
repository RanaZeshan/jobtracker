<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\TeamMember;
use App\Models\Application;
use Illuminate\Support\Facades\Auth;
use App\Models\Task;

class AdminController extends Controller
{
public function index()
{
    $user = Auth::user();

    if (!$user || $user->role !== 'admin') {
        abort(403);
    }

    // 🔹 Load clients with application count AND their tasks
    $clients = Client::withCount('applications')
        ->with(['tasks.assignee'])   // eager-load tasks + their assignee (User)
        ->latest()
        ->get();

    $teamMembers = TeamMember::withCount('applications')->latest()->get();

    $totalClients      = $clients->count();
    $totalTeamMembers  = $teamMembers->count();
    $totalApplications = Application::count();

    // (we don't actually need $tasks separately anymore, but you can keep it if used elsewhere)
     $tasks = Task::with(['client', 'assignee'])->orderBy('created_at', 'desc')->get();

    return view('admin.dashboard', compact(
        'clients',
        'teamMembers',
        'totalClients',
        'totalTeamMembers',
        'totalApplications',
        'tasks' 
    ));
}


}
