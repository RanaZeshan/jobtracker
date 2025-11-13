<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TeamEarningsController extends Controller
{
    /**
     * Show earnings overview for all team members
     */
    public function index(Request $request)
    {
        // Default to current month if no dates provided
        $fromDate = $request->input('from_date', now()->startOfMonth()->format('Y-m-d'));
        $toDate = $request->input('to_date', now()->endOfMonth()->format('Y-m-d'));
        
        // Get all team members
        $teamMembers = User::where('role', 'team')->get();
        
        // Calculate earnings for each team member for the selected date range
        $earningsData = [];
        
        foreach ($teamMembers as $member) {
            $applications = Application::where('team_id', $member->id)
                ->whereDate('applied_on', '>=', $fromDate)
                ->whereDate('applied_on', '<=', $toDate)
                ->get();
            
            $earningsData[] = [
                'member' => $member,
                'total_applications' => $applications->count(),
                'total_earnings' => $applications->sum('earning'),
                'tailored_count' => $applications->where('tailored_resume', true)->count(),
                'applications' => $applications,
            ];
        }
        
        // Sort by earnings (highest first)
        usort($earningsData, function($a, $b) {
            return $b['total_earnings'] <=> $a['total_earnings'];
        });
        
        return view('admin.earnings.index', compact('earningsData', 'fromDate', 'toDate'));
    }
    
    /**
     * Show detailed earnings for a specific team member
     */
    public function show(User $user, Request $request)
    {
        // Ensure the user is a team member
        if ($user->role !== 'team') {
            abort(404);
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
        
        // Get all-time stats for comparison
        $allTimeApplications = Application::where('team_id', $user->id)->count();
        $allTimeEarnings = Application::where('team_id', $user->id)->sum('earning');
        
        // Get last 6 months data for chart
        $monthlyData = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $monthKey = $date->format('Y-m');
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
        
        return view('admin.earnings.show', compact(
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
