<?php

namespace App\Http\Controllers;

use App\Models\Application;
use Illuminate\Http\Request;

class RecentActivityController extends Controller
{
    public function index()
    {
        try {
            // Get the 10 most recent applications with relationships
            $recentActivities = Application::with(['client', 'teamMember'])
                ->orderBy('created_at', 'desc')
                ->limit(10)
                ->get()
                ->map(function ($application) {
                    return [
                        'id' => $application->id,
                        'user_name' => $application->teamMember->name ?? 'Unknown',
                        'client_name' => $application->client->name ?? 'Unknown',
                        'job_title' => $application->job_title ?? 'N/A',
                        'company' => $application->company_applied_to ?? 'N/A',
                        'created_at' => $application->created_at->diffForHumans(),
                        'created_at_timestamp' => $application->created_at->timestamp,
                    ];
                });

            return response()->json([
                'success' => true,
                'activities' => $recentActivities
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
                'activities' => []
            ], 500);
        }
    }
}
