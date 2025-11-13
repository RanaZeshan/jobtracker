@extends('layouts.app')

@section('title', 'Applications for ' . $client->name)

@section('content')
    <style>
        .applications-page {
            max-width: 1800px;
            margin: 0 auto;
        }
        
        /* Header */
        .page-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 25px;
            padding: 2rem 2.5rem;
            margin-bottom: 2rem;
            color: white;
            position: relative;
            overflow: hidden;
        }
        .page-header::before {
            content: '';
            position: absolute;
            top: -30%;
            right: -5%;
            width: 300px;
            height: 300px;
            background: rgba(255,255,255,0.1);
            border-radius: 50%;
        }
        .page-header h1 {
            font-size: 2rem;
            font-weight: 800;
            margin-bottom: 0.5rem;
            position: relative;
            z-index: 1;
        }
        .page-header p {
            opacity: 0.95;
            margin: 0;
            position: relative;
            z-index: 1;
        }
        .back-btn {
            background: rgba(255,255,255,0.2);
            border: 2px solid rgba(255,255,255,0.3);
            color: white;
            padding: 0.6rem 1.5rem;
            border-radius: 50px;
            font-weight: 600;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }
        .back-btn:hover {
            background: rgba(255,255,255,0.3);
            transform: translateY(-2px);
            color: white;
        }
        
        /* Stats Cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }
        .stat-card {
            background: white;
            border-radius: 20px;
            padding: 1.5rem;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
            border-left: 4px solid;
        }
        .stat-card.total { border-left-color: #667eea; }
        .stat-card.earning { border-left-color: #43e97b; }
        .stat-card.tailored { border-left-color: #f093fb; }
        .stat-label {
            font-size: 0.85rem;
            color: #8b92a7;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 0.5rem;
        }
        .stat-value {
            font-size: 2rem;
            font-weight: 800;
            color: #2d3748;
        }
        
        /* Content Card */
        .content-card {
            background: white;
            border-radius: 25px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.08);
            overflow: hidden;
        }
        .content-card-header {
            padding: 2rem 2.5rem;
            border-bottom: 2px solid rgba(102, 126, 234, 0.1);
            background: linear-gradient(to bottom, #ffffff, #f8f9ff);
        }
        .content-card-header h3 {
            font-size: 1.5rem;
            font-weight: 800;
            color: #2d3748;
            margin: 0;
        }
        
        /* Modern Table */
        .modern-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0 0.75rem;
        }
        .modern-table thead th {
            padding: 0.75rem 1.5rem;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #8b92a7;
            border: none;
            background: transparent;
        }
        .modern-table tbody tr {
            background: white;
            box-shadow: 0 2px 8px rgba(0,0,0,0.04);
            transition: all 0.3s ease;
            border-radius: 15px;
        }
        .modern-table tbody tr:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
        }
        .modern-table tbody td {
            padding: 1.5rem 1.5rem;
            border: none;
            vertical-align: middle;
            background: white;
        }
        .modern-table tbody td:first-child {
            border-top-left-radius: 15px;
            border-bottom-left-radius: 15px;
            padding-left: 2rem;
        }
        .modern-table tbody td:last-child {
            border-top-right-radius: 15px;
            border-bottom-right-radius: 15px;
            padding-right: 2rem;
        }
        
        /* Badges */
        .badge-custom {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            padding: 0.4rem 0.9rem;
            border-radius: 50px;
            font-size: 0.8rem;
            font-weight: 600;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        .badge-custom.success {
            background: linear-gradient(135deg, #d4fc79, #96e6a1);
            color: #2d7a3e;
        }
        .badge-custom.warning {
            background: linear-gradient(135deg, #ffeaa7, #fdcb6e);
            color: #f57c00;
        }
        .badge-custom.info {
            background: linear-gradient(135deg, #a8edea, #74ebd5);
            color: #0277bd;
        }
        .badge-custom.primary {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
        }
        
        /* Action Buttons */
        .action-btn-icon {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            font-size: 1rem;
        }
        .action-btn-icon.view {
            background: linear-gradient(135deg, #a8edea, #74ebd5);
            color: #0277bd;
            box-shadow: 0 4px 12px rgba(116, 235, 213, 0.4);
        }
        .action-btn-icon.link {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
        }
        .action-btn-icon.delete {
            background: linear-gradient(135deg, #ff9a9e, #fecfef);
            color: #c62828;
            box-shadow: 0 4px 12px rgba(255, 154, 158, 0.4);
        }
        .action-btn-icon:hover {
            transform: translateY(-3px) scale(1.05);
            box-shadow: 0 8px 20px rgba(0,0,0,0.2);
        }
        
        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
        }
        .empty-state-icon {
            font-size: 4rem;
            margin-bottom: 1rem;
            opacity: 0.3;
        }
        .empty-state-text {
            font-size: 1.1rem;
            font-weight: 600;
            color: #8b92a7;
        }
    </style>

    <div class="applications-page">
        {{-- Header --}}
        <div class="page-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1><i class="bi bi-briefcase-fill me-2"></i>{{ $client->name }}</h1>
                    <p>View and manage all applications for this client</p>
                </div>
                <a href="{{ route('admin.dashboard') }}" class="back-btn">
                    <i class="bi bi-arrow-left"></i>
                    Back to Dashboard
                </a>
            </div>
        </div>

        {{-- Stats Cards --}}
        @php
            $totalApplications = $applications->count();
            $totalEarnings = $applications->sum('earning');
            $tailoredCount = $applications->where('tailored_resume', true)->count();
        @endphp
        <div class="stats-grid">
            <div class="stat-card total">
                <div class="stat-label">Total Applications</div>
                <div class="stat-value">{{ $totalApplications }}</div>
            </div>
            <div class="stat-card earning">
                <div class="stat-label">Total Earnings</div>
                <div class="stat-value">Rs. {{ number_format($totalEarnings, 2) }}</div>
            </div>
            <div class="stat-card tailored">
                <div class="stat-label">Tailored Resumes</div>
                <div class="stat-value">{{ $tailoredCount }}</div>
            </div>
        </div>

        {{-- Applications Table --}}
        <div class="content-card">
            <div class="content-card-header">
                <h3><i class="bi bi-list-ul me-2" style="color: #667eea;"></i>Applications List</h3>
            </div>
            <div class="content-card-body p-4">
                @if($applications->isEmpty())
                    <div class="empty-state">
                        <div class="empty-state-icon">📋</div>
                        <div class="empty-state-text">No applications submitted yet</div>
                        <p class="text-muted mt-2">Applications will appear here when team members submit them</p>
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="modern-table">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Job Title</th>
                                    <th>Company</th>
                                    <th>Team Member</th>
                                    <th>Status</th>
                                    <th>Tailored</th>
                                    <th>Earning</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($applications as $app)
                                    @php
                                        $date = $app->applied_on ?? $app->created_at;
                                    @endphp
                                    <tr>
                                        <td>
                                            <div style="font-weight: 600; color: #2d3748;">
                                                {{ $date ? $date->format('M d, Y') : '-' }}
                                            </div>
                                            <div style="font-size: 0.85rem; color: #8b92a7;">
                                                {{ $date ? $date->format('h:i A') : '' }}
                                            </div>
                                        </td>
                                        <td>
                                            <div style="font-weight: 600; color: #2d3748;">
                                                {{ $app->job_title }}
                                            </div>
                                        </td>
                                        <td>
                                            <div style="color: #667eea; font-weight: 600;">
                                                {{ $app->company_applied_to }}
                                            </div>
                                        </td>
                                        <td>
                                            <div style="font-weight: 600; color: #2d3748;">
                                                {{ $app->teamMember->name ?? 'N/A' }}
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge-custom info">
                                                <i class="bi bi-info-circle-fill"></i>
                                                {{ ucfirst($app->status) }}
                                            </span>
                                        </td>
                                        <td>
                                            @if($app->tailored_resume)
                                                <span class="badge-custom success">
                                                    <i class="bi bi-check-circle-fill"></i>
                                                    Yes
                                                </span>
                                            @else
                                                <span class="badge-custom warning">
                                                    <i class="bi bi-x-circle-fill"></i>
                                                    No
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                            <div style="font-weight: 700; color: #43e97b; font-size: 1.1rem;">
                                                Rs. {{ number_format($app->earning, 2) }}
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <div class="d-flex justify-content-center gap-2">
                                                @if($app->resume_file)
                                                    <a href="{{ asset('storage/' . $app->resume_file) }}"
                                                       target="_blank"
                                                       class="action-btn-icon view"
                                                       title="View Resume">
                                                        <i class="bi bi-file-earmark-pdf-fill"></i>
                                                    </a>
                                                @endif
                                                @if($app->job_link)
                                                    <a href="{{ $app->job_link }}"
                                                       target="_blank"
                                                       class="action-btn-icon link"
                                                       title="Open Job Link">
                                                        <i class="bi bi-link-45deg"></i>
                                                    </a>
                                                @endif
                                                <form action="{{ route('team.applications.destroy', $app) }}"
                                                      method="POST"
                                                      class="d-inline"
                                                      onsubmit="return confirm('Are you sure you want to delete this application?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                            class="action-btn-icon delete"
                                                            title="Delete Application">
                                                        <i class="bi bi-trash-fill"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
