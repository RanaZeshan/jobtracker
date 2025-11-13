<?php

namespace App\Http\Controllers;

use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeamMemberEarningsController extends Controller
{
    /**
     * Show earnings for the authenticated team member
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        
        // Ensure user is a team member
        if ($user->role !== 'team') {
            abort(403);
        }
        
        // Default to current month if no dates provided
        $fromDate = $request->input('from_date', now()->startOfMonth()->format('Y-m-d'));
        $toDate = $request->input('to_date', now()->endOfMonth()->format('Y-m-d'));
        
        // Get applications for the selected date range
        $applications = Application::with('client')
            ->where('team_id', $user->id)
            ->whereDate('applied_on', '>=', $fromDate)
            ->whereDate('applied_on', '<=', $toDate)
            ->orderByDesc('applied_on')
            ->get();
        
        // Calculate stats for date range
        $totalEarnings = $applications->sum('earning');
        $totalApplications = $applications->count();
        $tailoredCount = $applications->where('tailored_resume', true)->count();
        $averageEarning = $totalApplications > 0 ? $totalEarnings / $totalApplications : 0;
        
        // Get earnings by client
        $earningsByClient = $applications->groupBy('client_id')->map(function($clientApps) {
            return [
                'client' => $clientApps->first()->client,
                'count' => $clientApps->count(),
                'earnings' => $clientApps->sum('earning'),
            ];
        })->sortByDesc('earnings');
        
        // Get all-time stats
        $allTimeApplications = Application::where('team_id', $user->id)->count();
        $allTimeEarnings = Application::where('team_id', $user->id)->sum('earning');
        
        // Get last 6 months data for chart
        $monthlyData = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $monthLabel = $date->format('M Y');
            
            $monthApps = Application::where('team_id', $user->id)
                ->whereYear('applied_on', '=', $date->year)
                ->whereMonth('applied_on', '=', $date->month)
                ->get();
            
            $monthlyData[] = [
                'month' => $monthLabel,
                'applications' => $monthApps->count(),
                'earnings' => $monthApps->sum('earning'),
            ];
        }
        
        return view('team.earnings.index', compact(
            'user',
            'fromDate',
            'toDate',
            'applications',
            'totalEarnings',
            'totalApplications',
            'tailoredCount',
            'averageEarning',
            'earningsByClient',
            'allTimeApplications',
            'allTimeEarnings',
            'monthlyData'
        ));
    }
}
