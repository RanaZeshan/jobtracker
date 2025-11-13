@extends('layouts.app')

@section('title', 'Team Dashboard')

@section('content')
    <style>
        .modern-dashboard {
            max-width: 1600px;
            margin: 0 auto;
        }
        
        /* Header Styles */
        .dashboard-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 25px;
            padding: 2.5rem;
            margin-bottom: 2rem;
            color: white;
            position: relative;
            overflow: hidden;
        }
        .dashboard-header::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -10%;
            width: 400px;
            height: 400px;
            background: rgba(255,255,255,0.1);
            border-radius: 50%;
        }
        .dashboard-header h1 {
            font-size: 2.5rem;
            font-weight: 800;
            margin-bottom: 0.5rem;
            position: relative;
            z-index: 1;
        }
        .dashboard-header p {
            font-size: 1.1rem;
            opacity: 0.95;
            position: relative;
            z-index: 1;
        }
        .date-badge {
            background: rgba(255,255,255,0.25);
            backdrop-filter: blur(10px);
            padding: 0.75rem 1.5rem;
            border-radius: 50px;
            font-weight: 600;
            display: inline-block;
        }
        
        /* KPI Cards */
        .kpi-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }
        .kpi-card {
            background: white;
            border-radius: 20px;
            padding: 1.75rem;
            box-shadow: 0 10px 40px rgba(0,0,0,0.08);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        .kpi-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 50px rgba(0,0,0,0.12);
        }
        .kpi-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
        }
        .kpi-card.blue::before { background: linear-gradient(90deg, #4facfe, #00f2fe); }
        .kpi-card.green::before { background: linear-gradient(90deg, #43e97b, #38f9d7); }
        .kpi-card.orange::before { background: linear-gradient(90deg, #fa709a, #fee140); }
        .kpi-card.purple::before { background: linear-gradient(90deg, #a18cd1, #fbc2eb); }
        
        .kpi-icon {
            width: 60px;
            height: 60px;
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            margin-bottom: 1rem;
        }
        .kpi-card.blue .kpi-icon { background: linear-gradient(135deg, #4facfe, #00f2fe); }
        .kpi-card.green .kpi-icon { background: linear-gradient(135deg, #43e97b, #38f9d7); }
        .kpi-card.orange .kpi-icon { background: linear-gradient(135deg, #fa709a, #fee140); }
        .kpi-card.purple .kpi-icon { background: linear-gradient(135deg, #a18cd1, #fbc2eb); }
        
        .kpi-label {
            font-size: 0.85rem;
            color: #8b92a7;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 0.5rem;
        }
        .kpi-value {
            font-size: 2.5rem;
            font-weight: 800;
            color: #2d3748;
            line-height: 1;
            margin-bottom: 0.25rem;
        }
        .kpi-description {
            font-size: 0.9rem;
            color: #a0aec0;
        }
        
        /* Daily Digest */
        .digest-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }
        .digest-card {
            background: white;
            border-radius: 15px;
            padding: 1.5rem;
            border-left: 4px solid;
            box-shadow: 0 2px 8px rgba(0,0,0,0.06);
            display: flex;
            align-items: center;
            gap: 1rem;
            transition: all 0.3s ease;
        }
        .digest-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.1);
        }
        .digest-card.summary { border-left-color: #4facfe; }
        .digest-card.week { border-left-color: #f093fb; }
        .digest-card.clients { border-left-color: #43e97b; }
        .digest-icon {
            font-size: 2.5rem;
            flex-shrink: 0;
        }
        .digest-content {
            flex: 1;
        }
        .digest-label {
            font-size: 0.85rem;
            color: #8b92a7;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 0.5rem;
        }
        .digest-value {
            font-size: 2rem;
            font-weight: 800;
            color: #2d3748;
            line-height: 1;
            margin-bottom: 0.5rem;
        }
        .digest-meta {
            font-size: 0.85rem;
            color: #a0aec0;
        }
        .client-activity-list {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }
        .activity-client-card {
            background: white;
            border-radius: 15px;
            padding: 1.25rem;
            border: 1px solid #f0f0f0;
            transition: all 0.3s ease;
        }
        .activity-client-card:hover {
            border-color: #667eea;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.1);
        }
        .client-avatar {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            font-size: 1.1rem;
        }
        .client-name {
            font-weight: 700;
            color: #2d3748;
            font-size: 1rem;
            margin-bottom: 0.3rem;
        }
        .client-email {
            font-size: 0.85rem;
            color: #8b92a7;
        }
        .client-stats {
            display: flex;
            gap: 0.75rem;
        }
        .stat-badge {
            display: flex;
            align-items: center;
            gap: 0.4rem;
            padding: 0.5rem 0.9rem;
            border-radius: 50px;
            font-weight: 700;
            font-size: 0.85rem;
        }
        .stat-badge.apps {
            background: linear-gradient(135deg, #a8edea, #74ebd5);
            color: #0277bd;
        }
        .stat-badge.earning {
            background: linear-gradient(135deg, #d4fc79, #96e6a1);
            color: #2d7a3e;
        }
        
        /* Main Content Cards */
        .content-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.08);
            overflow: hidden;
            margin-bottom: 2rem;
        }
        .content-card-header {
            padding: 1.75rem 2rem;
            border-bottom: 1px solid #f0f0f0;
        }
        .content-card-header h3 {
            font-size: 1.4rem;
            font-weight: 700;
            color: #2d3748;
            margin-bottom: 0.25rem;
        }
        .content-card-header p {
            color: #8b92a7;
            margin: 0;
            font-size: 0.9rem;
        }
        .content-card-body {
            padding: 0;
        }
        
        /* Modern Table */
        .modern-table {
            width: 100%;
        }
        .modern-table thead {
            background: #f8f9ff;
        }
        .modern-table thead th {
            padding: 1.25rem 1.5rem;
            font-size: 0.8rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #667eea;
            border: none;
        }
        .modern-table tbody td {
            padding: 1.25rem 1.5rem;
            border-bottom: 1px solid #f0f0f0;
            vertical-align: middle;
        }
        .modern-table tbody tr {
            transition: all 0.2s ease;
        }
        .modern-table tbody tr:hover {
            background: #f8f9ff;
        }
        .modern-table tbody tr:last-child td {
            border-bottom: none;
        }
        
        /* Client Badge */
        .client-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }
        .client-avatar {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            font-size: 0.9rem;
        }
        .client-info strong {
            display: block;
            color: #2d3748;
            font-weight: 600;
        }
        .client-info small {
            color: #8b92a7;
            font-size: 0.8rem;
        }
        
        /* Status Pills */
        .status-pill {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            padding: 0.4rem 0.9rem;
            border-radius: 50px;
            font-size: 0.8rem;
            font-weight: 600;
        }
        .status-pill-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
        }
        .status-pill.todo { background: #f0f0f0; color: #6c757d; }
        .status-pill.todo .status-pill-dot { background: #6c757d; }
        .status-pill.doing { background: #e3f2fd; color: #1976d2; }
        .status-pill.doing .status-pill-dot { background: #1976d2; }
        .status-pill.done { background: #e8f5e9; color: #388e3c; }
        .status-pill.done .status-pill-dot { background: #388e3c; }
        .status-pill.paused { background: #fff3e0; color: #f57c00; }
        .status-pill.paused .status-pill-dot { background: #f57c00; }
        
        /* Metric Badges */
        .metric-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 45px;
            height: 32px;
            padding: 0 0.75rem;
            border-radius: 10px;
            font-weight: 700;
            font-size: 0.9rem;
        }
        .metric-badge.light { background: #f0f0f0; color: #2d3748; }
        .metric-badge.primary { background: #e3f2fd; color: #1976d2; }
        .metric-badge.warning { background: #fff3e0; color: #f57c00; }
        .metric-badge.danger { background: #ffebee; color: #d32f2f; }
        
        /* Action Buttons */
        .action-btn {
            padding: 0.5rem 1.25rem;
            border-radius: 50px;
            font-weight: 600;
            font-size: 0.85rem;
            transition: all 0.2s ease;
            border: 2px solid;
        }
        .action-btn.primary {
            background: linear-gradient(135deg, #667eea, #764ba2);
            border-color: transparent;
            color: white;
        }
        .action-btn.primary:hover:not(:disabled) {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
            color: white;
        }
        .action-btn.secondary {
            background: white;
            border-color: #e0e7ff;
            color: #667eea;
        }
        .action-btn.secondary:hover {
            background: #f8f9ff;
            border-color: #667eea;
            color: #667eea;
        }
        .action-btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }
        
        /* Applications List */
        .app-item {
            padding: 1.25rem 1.5rem;
            border-bottom: 1px solid #f0f0f0;
            transition: all 0.2s ease;
        }
        .app-item:hover {
            background: #f8f9ff;
        }
        .app-item:last-child {
            border-bottom: none;
        }
        .app-date {
            font-size: 0.75rem;
            color: #8b92a7;
            font-weight: 600;
        }
        .app-title {
            font-weight: 600;
            color: #2d3748;
            margin-bottom: 0.25rem;
        }
        .app-company {
            font-size: 0.85rem;
            color: #8b92a7;
        }
        .app-earning {
            font-size: 1.1rem;
            font-weight: 700;
            color: #10b981;
        }
        
        /* Client Cards */
        .client-card {
            background: white;
            border-radius: 20px;
            padding: 1.75rem;
            margin-bottom: 1.25rem;
            box-shadow: 0 4px 15px rgba(0,0,0,0.06);
            transition: all 0.3s ease;
            border-left: 5px solid;
            position: relative;
            overflow: hidden;
        }
        .client-card:hover {
            transform: translateX(5px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
        }
        .client-card.status-todo { border-left-color: #6c757d; }
        .client-card.status-doing { border-left-color: #1976d2; }
        .client-card.status-done { border-left-color: #388e3c; }
        .client-card.status-paused { border-left-color: #f57c00; }
        
        .client-card-header {
            display: flex;
            align-items: center;
            margin-bottom: 1.25rem;
            gap: 1rem;
        }
        .client-card-avatar {
            width: 60px;
            height: 60px;
            border-radius: 15px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 800;
            font-size: 1.4rem;
            flex-shrink: 0;
        }
        .client-card-info {
            flex-grow: 1;
        }
        .client-card-name {
            font-size: 1.3rem;
            font-weight: 700;
            color: #2d3748;
            margin-bottom: 0.25rem;
        }
        .client-card-email {
            font-size: 0.85rem;
            color: #8b92a7;
        }
        
        .client-card-metrics {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(100px, 1fr));
            gap: 1rem;
            margin-bottom: 1.25rem;
        }
        .metric-item {
            text-align: center;
            padding: 0.75rem;
            background: #f8f9ff;
            border-radius: 12px;
        }
        .metric-label {
            font-size: 0.7rem;
            color: #8b92a7;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 0.4rem;
            font-weight: 600;
        }
        .metric-value {
            font-size: 1.5rem;
            font-weight: 800;
            color: #2d3748;
        }
        .metric-value.success { color: #10b981; }
        .metric-value.warning { color: #f59e0b; }
        .metric-value.danger { color: #ef4444; }
        
        .no-apps-warning {
            background: linear-gradient(135deg, #fff3cd, #ffe69c);
            border-left: 4px solid #ffc107;
            padding: 1rem 1.25rem;
            border-radius: 12px;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            color: #856404;
            font-weight: 600;
            font-size: 0.9rem;
            animation: pulseWarning 2s ease-in-out infinite;
        }
        .no-apps-warning i {
            font-size: 1.2rem;
        }
        @keyframes pulseWarning {
            0%, 100% {
                box-shadow: 0 0 0 0 rgba(255, 193, 7, 0.4);
            }
            50% {
                box-shadow: 0 0 0 8px rgba(255, 193, 7, 0);
            }
        }
        
        .client-card-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 1rem;
            border-top: 1px solid #f0f0f0;
        }
        
        .card-action-btn {
            padding: 0.6rem 1.5rem;
            border-radius: 50px;
            font-weight: 600;
            font-size: 0.9rem;
            transition: all 0.2s ease;
            border: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }
        .card-action-btn.view {
            background: #e3f2fd;
            color: #1976d2;
        }
        .card-action-btn.view:hover {
            background: #1976d2;
            color: white;
            transform: translateY(-2px);
        }
        .card-action-btn.add {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
        }
        .card-action-btn.add:hover:not(:disabled) {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }
        .card-action-btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }
        
        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
        }
        .empty-state-icon {
            font-size: 4rem;
            color: #e0e7ff;
            margin-bottom: 1rem;
        }
        .empty-state-text {
            color: #8b92a7;
            font-size: 1.1rem;
        }
        
        /* Scrollbar */
        .apps-scroll {
            max-height: 600px;
            overflow-y: auto;
        }
        .apps-scroll::-webkit-scrollbar {
            width: 6px;
        }
        .apps-scroll::-webkit-scrollbar-track {
            background: #f0f0f0;
        }
        .apps-scroll::-webkit-scrollbar-thumb {
            background: #cbd5e0;
            border-radius: 10px;
        }
        .apps-scroll::-webkit-scrollbar-thumb:hover {
            background: #a0aec0;
        }
    </style>

    <div class="modern-dashboard">
        {{-- Header --}}
        <div class="dashboard-header">
            <div class="row align-items-center">
                <div class="col-md-7">
                    <h1>👋 Welcome back, {{ auth()->user()->name }}!</h1>
                    <p>Here's what's happening with your applications today</p>
                </div>
                <div class="col-md-5 text-md-end mt-3 mt-md-0">
                    <div class="d-flex flex-column flex-md-row gap-2 justify-content-md-end align-items-md-center">
                        <a href="{{ route('team.earnings.index') }}" class="btn btn-light btn-lg rounded-pill">
                            <i class="bi bi-cash-coin me-2"></i>My Earnings
                        </a>
                        <div class="date-badge">
                            <i class="bi bi-calendar-event me-2"></i>
                            {{ now()->format('M d, Y') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- KPI Cards --}}
        <div class="kpi-grid">
            <div class="kpi-card blue">
                <div class="kpi-icon">📋</div>
                <div class="kpi-label">Total Tasks</div>
                <div class="kpi-value">{{ $totalTasks }}</div>
                <div class="kpi-description">All assigned tasks</div>
            </div>
            
            <div class="kpi-card green">
                <div class="kpi-icon">🚀</div>
                <div class="kpi-label">Active Tasks</div>
                <div class="kpi-value">{{ $activeTasks }}</div>
                <div class="kpi-description">Currently in progress</div>
            </div>
            
            <div class="kpi-card orange">
                <div class="kpi-icon">✅</div>
                <div class="kpi-label">Completed</div>
                <div class="kpi-value">{{ $completedTasks }}</div>
                <div class="kpi-description">Successfully finished</div>
            </div>
            
            <div class="kpi-card purple">
                <div class="kpi-icon">💼</div>
                <div class="kpi-label">Applications</div>
                <div class="kpi-value">{{ $totalApplications }}</div>
                <div class="kpi-description">Total submitted</div>
            </div>
        </div>

        {{-- Daily Digest Section --}}
        <div class="content-card mb-4">
            <div class="content-card-header">
                <div>
                    <h3><i class="bi bi-calendar-check me-2" style="color: #667eea;"></i>My Daily Summary</h3>
                    <p>Your activity and progress for today</p>
                </div>
                <div class="date-badge">
                    <i class="bi bi-calendar-day me-2"></i>
                    {{ now()->format('M d, Y') }}
                </div>
            </div>
            <div class="content-card-body p-4">
                @php
                    $today = now()->startOfDay();
                    $userId = auth()->id();
                    $todayApplications = \App\Models\Application::where('team_id', $userId)
                        ->whereDate('created_at', $today)
                        ->get();
                    $todayCount = $todayApplications->count();
                    $todayEarnings = $todayApplications->sum('earning');
                    $todayTailored = $todayApplications->where('tailored_resume', true)->count();
                    
                    // Group by client
                    $clientActivity = $todayApplications->groupBy('client_id')->map(function($apps) {
                        return [
                            'client' => $apps->first()->client,
                            'count' => $apps->count(),
                            'earning' => $apps->sum('earning'),
                        ];
                    })->sortByDesc('count');
                    
                    // Week comparison
                    $weekStart = now()->startOfWeek();
                    $weekApplications = \App\Models\Application::where('team_id', $userId)
                        ->whereBetween('created_at', [$weekStart, now()])
                        ->count();
                    $weekEarnings = \App\Models\Application::where('team_id', $userId)
                        ->whereBetween('created_at', [$weekStart, now()])
                        ->sum('earning');
                @endphp
                
                <div class="digest-grid">
                    {{-- Today's Summary --}}
                    <div class="digest-card summary">
                        <div class="digest-icon">📊</div>
                        <div class="digest-content">
                            <div class="digest-label">Today's Applications</div>
                            <div class="digest-value">{{ $todayCount }}</div>
                            <div class="digest-meta">
                                Rs. {{ number_format($todayEarnings, 2) }} earned
                                @if($todayTailored > 0)
                                    • {{ $todayTailored }} tailored
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    {{-- This Week --}}
                    <div class="digest-card week">
                        <div class="digest-icon">📅</div>
                        <div class="digest-content">
                            <div class="digest-label">This Week</div>
                            <div class="digest-value">{{ $weekApplications }}</div>
                            <div class="digest-meta">
                                Rs. {{ number_format($weekEarnings, 2) }} earned
                            </div>
                        </div>
                    </div>
                    
                    {{-- Clients Worked On --}}
                    <div class="digest-card clients">
                        <div class="digest-icon">👥</div>
                        <div class="digest-content">
                            <div class="digest-label">Clients Today</div>
                            <div class="digest-value">{{ $clientActivity->count() }}</div>
                            <div class="digest-meta">
                                {{ $tasks->count() }} total assigned
                            </div>
                        </div>
                    </div>
                </div>
                
                {{-- Client Activity Breakdown --}}
                @if($clientActivity->isNotEmpty())
                <div class="mt-4">
                    <h5 class="mb-3" style="font-weight: 700; color: #2d3748;">
                        <i class="bi bi-briefcase-fill me-2"></i>Today's Client Breakdown
                    </h5>
                    <div class="client-activity-list">
                        @foreach($clientActivity as $activity)
                        <div class="activity-client-card">
                            <div class="d-flex align-items-center gap-3">
                                <div class="client-avatar">
                                    {{ strtoupper(substr($activity['client']->name ?? 'N', 0, 2)) }}
                                </div>
                                <div class="flex-grow-1">
                                    <div class="client-name">{{ $activity['client']->name ?? 'Unknown' }}</div>
                                    <div class="client-email">
                                        <i class="bi bi-envelope me-1"></i>
                                        {{ $activity['client']->email ?? 'No email' }}
                                    </div>
                                </div>
                                <div class="client-stats">
                                    <div class="stat-badge apps">
                                        <i class="bi bi-file-earmark-text"></i>
                                        {{ $activity['count'] }} apps
                                    </div>
                                    <div class="stat-badge earning">
                                        <i class="bi bi-currency-dollar"></i>
                                        Rs. {{ number_format($activity['earning'], 0) }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @else
                <div class="empty-state">
                    <div class="empty-state-icon">📅</div>
                    <div class="empty-state-text">No applications submitted today</div>
                    <p class="text-muted mt-2">Start adding applications to see your daily progress</p>
                </div>
                @endif
            </div>
        </div>

        {{-- Main Content --}}
        <div class="row g-4">
            {{-- Clients & Tasks --}}
            <div class="col-lg-8">
                <div class="content-card">
                    <div class="content-card-header">
                        <h3><i class="bi bi-briefcase-fill me-2" style="color: #667eea;"></i>My Assigned Clients</h3>
                        <p>Track your targets and manage applications for each client</p>
                    </div>
                    <div class="content-card-body p-0">
                        @if($tasks->isEmpty())
                            <div class="empty-state">
                                <div class="empty-state-icon">📭</div>
                                <div class="empty-state-text">No tasks assigned yet</div>
                            </div>
                        @else
                            <div class="p-3">
                                @foreach($tasks as $task)
                                    @php
                                        $s = strtolower($task->status);
                                        $statusKey = match($s) {
                                            'done' => 'done',
                                            'doing', 'in_progress' => 'doing',
                                            'on_hold', 'hold' => 'paused',
                                            default => 'todo',
                                        };
                                        $currentCount = $task->client ? \App\Models\Application::where('client_id', $task->client_id)
                                            ->where('team_id', auth()->id())
                                            ->count() : 0;
                                        $limitReached = $task->application_limit && $currentCount >= $task->application_limit;
                                        $isClientPaused = $task->client && $task->client->application_status === 'paused';
                                        $isTaskPaused = $task->is_paused;
                                        $isPaused = $isClientPaused || $isTaskPaused;
                                        
                                        // Determine card status class
                                        if ($isPaused) {
                                            $cardStatusClass = 'status-paused';
                                        } else {
                                            $cardStatusClass = 'status-' . $statusKey;
                                        }
                                    @endphp
                                    
                                    <div class="client-card {{ $cardStatusClass }}">
                                        {{-- Header --}}
                                        <div class="client-card-header">
                                            <div class="client-card-avatar">
                                                {{ strtoupper(substr($task->client->name ?? 'N', 0, 2)) }}
                                            </div>
                                            <div class="client-card-info">
                                                <div class="client-card-name">{{ $task->client->name ?? 'N/A' }}</div>
                                                <div class="client-card-email">
                                                    <i class="bi bi-envelope me-1"></i>{{ $task->client->email ?? 'No email' }}
                                                </div>
                                            </div>
                                            <div>
                                                @if($isTaskPaused)
                                                    <span class="status-pill paused">
                                                        <span class="status-pill-dot"></span>
                                                        You're Paused
                                                    </span>
                                                @elseif($isClientPaused)
                                                    <span class="status-pill paused">
                                                        <span class="status-pill-dot"></span>
                                                        Client Paused
                                                    </span>
                                                @else
                                                    <span class="status-pill {{ $statusKey }}">
                                                        <span class="status-pill-dot"></span>
                                                        {{ ucfirst($task->status) }}
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                        
                                        {{-- Metrics --}}
                                        <div class="client-card-metrics">
                                            <div class="metric-item">
                                                <div class="metric-label">Target</div>
                                                <div class="metric-value">{{ $task->target_applications }}</div>
                                            </div>
                                            <div class="metric-item">
                                                <div class="metric-label">Completed</div>
                                                <div class="metric-value success">{{ $task->completed_applications }}</div>
                                            </div>
                                            @if($task->application_limit)
                                                <div class="metric-item">
                                                    <div class="metric-label">Limit</div>
                                                    <div class="metric-value {{ $limitReached ? 'danger' : 'warning' }}">
                                                        {{ $currentCount }}/{{ $task->application_limit }}
                                                    </div>
                                                </div>
                                            @endif
                                            <div class="metric-item">
                                                <div class="metric-label">Progress</div>
                                                <div class="metric-value">
                                                    {{ $task->target_applications > 0 ? round(($task->completed_applications / $task->target_applications) * 100) : 0 }}%
                                                </div>
                                            </div>
                                        </div>
                                        
                                        {{-- No Applications Warning --}}
                                        @if($currentCount === 0 && !$isPaused)
                                            <div class="no-apps-warning">
                                                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                                                <span>You haven't submitted any applications for this client yet!</span>
                                            </div>
                                        @endif
                                        
                                        {{-- Footer Actions --}}
                                        <div class="client-card-footer">
                                            <div>
                                                @if($limitReached)
                                                    <small class="text-danger">
                                                        <i class="bi bi-exclamation-circle me-1"></i>Limit reached
                                                    </small>
                                                @elseif($isPaused)
                                                    <small class="text-warning">
                                                        <i class="bi bi-pause-circle me-1"></i>Applications paused
                                                    </small>
                                                @elseif($currentCount === 0)
                                                    <small class="text-warning">
                                                        <i class="bi bi-info-circle me-1"></i>No applications yet
                                                    </small>
                                                @else
                                                    <small class="text-muted">
                                                        <i class="bi bi-check-circle me-1"></i>Ready to apply
                                                    </small>
                                                @endif
                                            </div>
                                            <div class="d-flex gap-2">
                                                <a href="{{ route('team.clients.applications', $task->client->id) }}" 
                                                   class="card-action-btn view">
                                                    <i class="bi bi-eye"></i>
                                                    View
                                                </a>
                                                <a href="{{ route('team.clients.applications.create', $task->client->id) }}" 
                                                   class="card-action-btn add {{ ($limitReached || $isPaused) ? 'disabled' : '' }}"
                                                   @if($limitReached) 
                                                        title="Application limit reached"
                                                   @elseif($isTaskPaused)
                                                        title="You have been paused by admin"
                                                   @elseif($isClientPaused)
                                                        title="Client applications paused by admin"
                                                   @endif>
                                                    <i class="bi bi-plus-lg"></i>
                                                    Add Application
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Recent Applications --}}
            <div class="col-lg-4">
                <div class="content-card">
                    <div class="content-card-header">
                        <h3><i class="bi bi-clock-history me-2" style="color: #667eea;"></i>Recent Activity</h3>
                        <p>Your latest application submissions</p>
                    </div>
                    <div class="content-card-body">
                        @if($applications->isEmpty())
                            <div class="empty-state">
                                <div class="empty-state-icon">📝</div>
                                <div class="empty-state-text">No applications yet</div>
                            </div>
                        @else
                            <div class="apps-scroll">
                                @foreach($applications as $app)
                                    @php
                                        $date = $app->applied_on ?? $app->created_at;
                                        $status = strtolower($app->status);
                                    @endphp
                                    <div class="app-item">
                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                            <div class="app-date">
                                                <i class="bi bi-calendar3 me-1"></i>
                                                {{ $date ? $date->format('M d, Y • H:i') : '-' }}
                                            </div>
                                            <span class="badge rounded-pill 
                                                @if($status === 'offer') bg-success
                                                @elseif($status === 'interview') bg-info
                                                @elseif($status === 'rejected') bg-danger
                                                @else bg-secondary
                                                @endif">
                                                {{ ucfirst($app->status) }}
                                            </span>
                                        </div>
                                        <div class="app-title">{{ \Illuminate\Support\Str::limit($app->job_title, 35) }}</div>
                                        <div class="app-company mb-2">
                                            <i class="bi bi-building me-1"></i>
                                            {{ \Illuminate\Support\Str::limit($app->company_applied_to, 30) }}
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                @if($app->tailored_resume)
                                                    <span class="badge bg-warning text-dark">
                                                        <i class="bi bi-star-fill me-1"></i>Tailored
                                                    </span>
                                                @endif
                                            </div>
                                            <div class="app-earning">
                                                Rs. {{ number_format($app->earning, 2) }}
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
