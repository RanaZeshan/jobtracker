<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Client;

class AdminClientApplicationController extends Controller
{
    /**
     * Show all applications for a given client (admin view).
     */
    public function index(Client $client)
    {
        // Load applications for this client, newest first
        $applications = Application::with('teamMember')
            ->where('client_id', $client->id)
            ->orderByDesc('applied_on')
            ->orderByDesc('created_at')
            ->get();

        return view('admin.clients.applications', compact('client', 'applications'));
    }
}
