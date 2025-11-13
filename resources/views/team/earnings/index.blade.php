@extends('layouts.app')

@section('title', 'My Earnings')

@section('content')
    <style>
        .details-page {
            max-width: 1600px;
            margin: 0 auto;
        }
        
        .details-header {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            border-radius: 25px;
            padding: 2.5rem;
            margin-bottom: 2rem;
            color: white;
            position: relative;
            overflow: hidden;
        }
        .details-header::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -10%;
            width: 400px;
            height: 400px;
            background: rgba(255,255,255,0.1);
            border-radius: 50%;
        }
        .details-header h1 {
            font-size: 2.5rem;
            font-weight: 800;
            margin-bottom: 0.5rem;
            position: relative;
            z-index: 1;
        }
        
        .kpi-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
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
        .kpi-card.green::before { background: linear-gradient(90deg, #10b981, #059669); }
        .kpi-card.blue::before { background: linear-gradient(90deg, #3b82f6, #2563eb); }
        .kpi-card.purple::before { background: linear-gradient(90deg, #8b5cf6, #7c3aed); }
        .kpi-card.orange::before { background: linear-gradient(90deg, #f59e0b, #d97706); }
        
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
        .kpi-card.green .kpi-icon { background: linear-gradient(135deg, #10b981, #059669); }
        .kpi-card.blue .kpi-icon { background: linear-gradient(135deg, #3b82f6, #2563eb); }
        .kpi-card.purple .kpi-icon { background: linear-gradient(135deg, #8b5cf6, #7c3aed); }
        .kpi-card.orange .kpi-icon { background: linear-gradient(135deg, #f59e0b, #d97706); }
        
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
            margin: 0;
        }
        
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
            color: #10b981;
            border: none;
        }
        .modern-table tbody td {
            padding: 1.25rem 1.5rem;
            border-bottom: 1px solid #f0f0f0;
            vertical-align: middle;
        }
        .modern-table tbody tr:hover {
            background: #f8f9ff;
        }
        
        .chart-container {
            padding: 2rem;
            height: 300px;
        }
        
        .date-filter-form {
            background: rgba(255,255,255,0.25);
            backdrop-filter: blur(10px);
            padding: 1rem 1.5rem;
            border-radius: 20px;
            border: 2px solid rgba(255,255,255,0.3);
        }
        .date-input {
            background: rgba(255,255,255,0.9);
            border: 2px solid rgba(255,255,255,0.5);
            border-radius: 10px;
            padding: 0.5rem 1rem;
            color: #2d3748;
            font-weight: 600;
            font-size: 0.9rem;
        }
        .date-input:focus {
            outline: none;
            border-color: white;
            background: white;
        }
        .date-label {
            color: white;
            font-weight: 600;
            font-size: 0.85rem;
            margin-bottom: 0.5rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .filter-btn {
            background: white;
            color: #10b981;
            border: none;
            padding: 0.5rem 1.5rem;
            border-radius: 10px;
            font-weight: 700;
            transition: all 0.2s ease;
        }
        .filter-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(255,255,255,0.3);
            color: #10b981;
        }
    </style>

    <div class="details-page">
        {{-- Header --}}
        <div class="details-header">
            <div class="row align-items-end">
                <div class="col-md-6">
                    <h1>💵 My Earnings</h1>
                    <p>From {{ date('M d, Y', strtotime($fromDate)) }} to {{ date('M d, Y', strtotime($toDate)) }}</p>
                </div>
                <div class="col-md-6 mt-3 mt-md-0">
                    <form method="GET" action="{{ route('team.earnings.index') }}" class="date-filter-form">
                        <div class="row g-2 align-items-end">
                            <div class="col-md-5">
                                <label class="date-label">From Date</label>
                                <input 
                                    type="date" 
                                    name="from_date" 
                                    value="{{ $fromDate }}" 
                                    class="form-control date-input"
                                    required
                                >
                            </div>
                            <div class="col-md-5">
                                <label class="date-label">To Date</label>
                                <input 
                                    type="date" 
                                    name="to_date" 
                                    value="{{ $toDate }}" 
                                    class="form-control date-input"
                                    required
                                >
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn filter-btn w-100">
                                    <i class="bi bi-search"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Back Button --}}
        <div class="mb-3">
            <a href="{{ route('team.dashboard') }}" class="btn btn-outline-secondary rounded-pill">
                <i class="bi bi-arrow-left me-2"></i>Back to Dashboard
            </a>
        </div>

        {{-- KPI Cards --}}
        <div class="kpi-grid">
            <div class="kpi-card green">
                <div class="kpi-icon">💰</div>
                <div class="kpi-label">Total Earnings</div>
                <div class="kpi-value">Rs. {{ number_format($totalEarnings, 2) }}</div>
                <div class="kpi-description">Selected period</div>
            </div>
            
            <div class="kpi-card blue">
                <div class="kpi-icon">📄</div>
                <div class="kpi-label">Applications</div>
                <div class="kpi-value">{{ $totalApplications }}</div>
                <div class="kpi-description">Submitted</div>
            </div>
            
            <div class="kpi-card purple">
                <div class="kpi-icon">⭐</div>
                <div class="kpi-label">Tailored CVs</div>
                <div class="kpi-value">{{ $tailoredCount }}</div>
                <div class="kpi-description">{{ $totalApplications > 0 ? round(($tailoredCount / $totalApplications) * 100) : 0 }}% of total</div>
            </div>
            
            <div class="kpi-card orange">
                <div class="kpi-icon">📊</div>
                <div class="kpi-label">Average</div>
                <div class="kpi-value">Rs. {{ number_format($averageEarning, 2) }}</div>
                <div class="kpi-description">Per application</div>
            </div>
        </div>

        {{-- Monthly Trend Chart --}}
        <div class="content-card">
            <div class="content-card-header">
                <h3><i class="bi bi-graph-up me-2" style="color: #10b981;"></i>6-Month Trend</h3>
            </div>
            <div class="chart-container">
                <canvas id="earningsChart"></canvas>
            </div>
        </div>

        {{-- Earnings by Client --}}
        <div class="content-card">
            <div class="content-card-header">
                <h3><i class="bi bi-people-fill me-2" style="color: #10b981;"></i>Earnings by Client</h3>
            </div>
            <div class="content-card-body">
                @if($earningsByClient->isEmpty())
                    <div class="text-center py-5">
                        <i class="bi bi-inbox" style="font-size: 3rem; color: #ddd;"></i>
                        <p class="text-muted mt-3">No earnings data for this month</p>
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="modern-table">
                            <thead>
                                <tr>
                                    <th>Client</th>
                                    <th class="text-center">Applications</th>
                                    <th class="text-center">Earnings</th>
                                    <th class="text-center">Avg per App</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($earningsByClient as $data)
                                    <tr>
                                        <td><strong>{{ $data['client']->name ?? 'N/A' }}</strong></td>
                                        <td class="text-center">
                                            <span class="badge bg-primary rounded-pill">{{ $data['count'] }}</span>
                                        </td>
                                        <td class="text-center">
                                            <strong class="text-success">Rs. {{ number_format($data['earnings'], 2) }}</strong>
                                        </td>
                                        <td class="text-center">
                                            Rs. {{ number_format($data['earnings'] / $data['count'], 2) }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>

        {{-- All Applications --}}
        <div class="content-card">
            <div class="content-card-header">
                <h3><i class="bi bi-list-check me-2" style="color: #10b981;"></i>All Applications ({{ date('M d', strtotime($fromDate)) }} - {{ date('M d, Y', strtotime($toDate)) }})</h3>
            </div>
            <div class="content-card-body">
                @if($applications->isEmpty())
                    <div class="text-center py-5">
                        <i class="bi bi-inbox" style="font-size: 3rem; color: #ddd;"></i>
                        <p class="text-muted mt-3">No applications for this period</p>
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="modern-table">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Client</th>
                                    <th>Job Title</th>
                                    <th>Company</th>
                                    <th class="text-center">Tailored</th>
                                    <th class="text-center">Earning</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($applications as $app)
                                    <tr>
                                        <td>{{ $app->applied_on ? $app->applied_on->format('M d, Y') : '-' }}</td>
                                        <td>{{ $app->client->name ?? 'N/A' }}</td>
                                        <td><strong>{{ $app->job_title }}</strong></td>
                                        <td>{{ $app->company_applied_to }}</td>
                                        <td class="text-center">
                                            @if($app->tailored_resume)
                                                <i class="bi bi-star-fill text-warning"></i>
                                            @else
                                                <span class="text-muted">—</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <strong class="text-success">Rs. {{ number_format($app->earning, 2) }}</strong>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>

        {{-- All-Time Stats --}}
        <div class="content-card">
            <div class="content-card-header">
                <h3><i class="bi bi-trophy-fill me-2" style="color: #10b981;"></i>All-Time Performance</h3>
            </div>
            <div class="content-card-body p-4">
                <div class="row text-center">
                    <div class="col-md-6">
                        <div class="p-3">
                            <div class="text-muted mb-2">Total Applications</div>
                            <div class="display-4 fw-bold text-primary">{{ $allTimeApplications }}</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-3">
                            <div class="text-muted mb-2">Total Earnings</div>
                            <div class="display-4 fw-bold text-success">Rs. {{ number_format($allTimeEarnings, 2) }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Chart.js --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <script>
        const ctx = document.getElementById('earningsChart');
        
        const monthlyData = @json($monthlyData);
        
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: monthlyData.map(d => d.month),
                datasets: [
                    {
                        label: 'Earnings ($)',
                        data: monthlyData.map(d => d.earnings),
                        borderColor: '#10b981',
                        backgroundColor: 'rgba(16, 185, 129, 0.1)',
                        tension: 0.4,
                        fill: true,
                        yAxisID: 'y'
                    },
                    {
                        label: 'Applications',
                        data: monthlyData.map(d => d.applications),
                        borderColor: '#3b82f6',
                        backgroundColor: 'rgba(59, 130, 246, 0.1)',
                        tension: 0.4,
                        fill: true,
                        yAxisID: 'y1'
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: {
                    mode: 'index',
                    intersect: false,
                },
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        type: 'linear',
                        display: true,
                        position: 'left',
                        title: {
                            display: true,
                            text: 'Earnings ($)'
                        }
                    },
                    y1: {
                        type: 'linear',
                        display: true,
                        position: 'right',
                        title: {
                            display: true,
                            text: 'Applications'
                        },
                        grid: {
                            drawOnChartArea: false,
                        },
                    },
                }
            }
        });
    </script>
@endsection
