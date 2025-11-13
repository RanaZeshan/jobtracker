@extends('layouts.app')

@section('title', 'Team Earnings')

@section('content')
    <style>
        .earnings-page {
            max-width: 1600px;
            margin: 0 auto;
        }
        
        .earnings-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 25px;
            padding: 2.5rem;
            margin-bottom: 2rem;
            color: white;
            position: relative;
            overflow: hidden;
        }
        .earnings-header::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -10%;
            width: 400px;
            height: 400px;
            background: rgba(255,255,255,0.1);
            border-radius: 50%;
        }
        .earnings-header h1 {
            font-size: 2.5rem;
            font-weight: 800;
            margin-bottom: 0.5rem;
            position: relative;
            z-index: 1;
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
            color: #667eea;
            border: none;
            padding: 0.5rem 1.5rem;
            border-radius: 10px;
            font-weight: 700;
            transition: all 0.2s ease;
        }
        .filter-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(255,255,255,0.3);
            color: #667eea;
        }
        
        .earnings-card {
            background: white;
            border-radius: 20px;
            padding: 2rem;
            box-shadow: 0 10px 40px rgba(0,0,0,0.08);
            margin-bottom: 1.5rem;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        .earnings-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 50px rgba(0,0,0,0.12);
        }
        .earnings-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 5px;
            background: linear-gradient(90deg, #667eea, #764ba2);
        }
        
        .member-avatar {
            width: 70px;
            height: 70px;
            border-radius: 20px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 800;
            font-size: 1.8rem;
            margin-right: 1.5rem;
        }
        
        .member-info h3 {
            font-size: 1.5rem;
            font-weight: 700;
            color: #2d3748;
            margin-bottom: 0.25rem;
        }
        .member-info p {
            color: #8b92a7;
            margin: 0;
        }
        
        .earnings-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 1.5rem;
            margin-top: 1.5rem;
        }
        .stat-box {
            text-align: center;
            padding: 1rem;
            background: #f8f9ff;
            border-radius: 15px;
        }
        .stat-label {
            font-size: 0.8rem;
            color: #8b92a7;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 0.5rem;
        }
        .stat-value {
            font-size: 1.8rem;
            font-weight: 800;
            color: #2d3748;
        }
        .stat-value.earnings {
            color: #10b981;
        }
        
        .view-details-btn {
            padding: 0.75rem 2rem;
            border-radius: 50px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            border: none;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .view-details-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.4);
            color: white;
        }
        
        .rank-badge {
            position: absolute;
            top: 1.5rem;
            right: 1.5rem;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            font-size: 1.2rem;
        }
        .rank-badge.gold {
            background: linear-gradient(135deg, #ffd700, #ffed4e);
            color: #b8860b;
        }
        .rank-badge.silver {
            background: linear-gradient(135deg, #c0c0c0, #e8e8e8);
            color: #696969;
        }
        .rank-badge.bronze {
            background: linear-gradient(135deg, #cd7f32, #e6a85c);
            color: #8b4513;
        }
        .rank-badge.default {
            background: #f0f0f0;
            color: #8b92a7;
        }
        
        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
        }
        .empty-state-icon {
            font-size: 4rem;
            margin-bottom: 1rem;
        }
        .empty-state-text {
            color: #8b92a7;
            font-size: 1.1rem;
        }
    </style>

    <div class="earnings-page">
        {{-- Header --}}
        <div class="earnings-header">
            <div class="row align-items-end">
                <div class="col-md-6">
                    <h1>💰 Team Earnings Report</h1>
                    <p>Track individual team member performance and earnings</p>
                </div>
                <div class="col-md-6 mt-3 mt-md-0">
                    <form method="GET" action="{{ route('admin.earnings.index') }}" class="date-filter-form">
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
            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary rounded-pill">
                <i class="bi bi-arrow-left me-2"></i>Back to Dashboard
            </a>
        </div>

        {{-- Earnings Cards --}}
        @if(empty($earningsData) || collect($earningsData)->sum('total_applications') == 0)
            <div class="earnings-card">
                <div class="empty-state">
                    <div class="empty-state-icon">📊</div>
                    <div class="empty-state-text">No earnings data from {{ date('M d, Y', strtotime($fromDate)) }} to {{ date('M d, Y', strtotime($toDate)) }}</div>
                </div>
            </div>
        @else
            @foreach($earningsData as $index => $data)
                @php
                    $rankClass = match($index) {
                        0 => 'gold',
                        1 => 'silver',
                        2 => 'bronze',
                        default => 'default'
                    };
                    $rankIcon = match($index) {
                        0 => '🥇',
                        1 => '🥈',
                        2 => '🥉',
                        default => '#' . ($index + 1)
                    };
                @endphp
                
                <div class="earnings-card">
                    <div class="rank-badge {{ $rankClass }}">
                        {{ $rankIcon }}
                    </div>
                    
                    <div class="d-flex align-items-center">
                        <div class="member-avatar">
                            {{ strtoupper(substr($data['member']->name, 0, 2)) }}
                        </div>
                        <div class="member-info flex-grow-1">
                            <h3>{{ $data['member']->name }}</h3>
                            <p><i class="bi bi-envelope me-2"></i>{{ $data['member']->email }}</p>
                        </div>
                        <div>
                            <a href="{{ route('admin.earnings.show', ['user' => $data['member']->id, 'from_date' => $fromDate, 'to_date' => $toDate]) }}" 
                               class="view-details-btn">
                                <i class="bi bi-eye me-2"></i>View Details
                            </a>
                        </div>
                    </div>
                    
                    <div class="earnings-stats">
                        <div class="stat-box">
                            <div class="stat-label">Total Earnings</div>
                            <div class="stat-value earnings">Rs. {{ number_format($data['total_earnings'], 2) }}</div>
                        </div>
                        <div class="stat-box">
                            <div class="stat-label">Applications</div>
                            <div class="stat-value">{{ $data['total_applications'] }}</div>
                        </div>
                        <div class="stat-box">
                            <div class="stat-label">Tailored CVs</div>
                            <div class="stat-value">{{ $data['tailored_count'] }}</div>
                        </div>
                        <div class="stat-box">
                            <div class="stat-label">Avg per App</div>
                            <div class="stat-value earnings">
                                Rs. {{ $data['total_applications'] > 0 ? number_format($data['total_earnings'] / $data['total_applications'], 2) : '0.00' }}
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
@endsection
