@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
    <style>
        .admin-dashboard {
            max-width: 1800px;
            margin: 0 auto;
        }
        
        /* Header */
        .admin-header {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            border-radius: 25px;
            padding: 2.5rem;
            margin-bottom: 2rem;
            color: white;
            position: relative;
            overflow: hidden;
        }
        .admin-header::before {
            content: '';
            position: absolute;
            top: -30%;
            right: -5%;
            width: 350px;
            height: 350px;
            background: rgba(255,255,255,0.1);
            border-radius: 50%;
            z-index: -1;
        }
        .admin-header h1 {
            font-size: 2.5rem;
            font-weight: 800;
            margin-bottom: 0.5rem;
            position: relative;
            z-index: 1;
        }
        .admin-header p {
            font-size: 1.1rem;
            opacity: 0.95;
            position: relative;
            z-index: 1;
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
        .kpi-card.blue::before { background: linear-gradient(90deg, #4e73df, #224abe); }
        .kpi-card.green::before { background: linear-gradient(90deg, #1cc88a, #13855c); }
        .kpi-card.cyan::before { background: linear-gradient(90deg, #36b9cc, #0f6674); }
        .kpi-card.yellow::before { background: linear-gradient(90deg, #f6c23e, #c6951a); }
        
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
        .kpi-card.blue .kpi-icon { background: linear-gradient(135deg, #4e73df, #224abe); }
        .kpi-card.green .kpi-icon { background: linear-gradient(135deg, #1cc88a, #13855c); }
        .kpi-card.cyan .kpi-icon { background: linear-gradient(135deg, #36b9cc, #0f6674); }
        .kpi-card.yellow .kpi-icon { background: linear-gradient(135deg, #f6c23e, #c6951a); }
        
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
        
        /* Content Cards */
        .content-card {
            background: linear-gradient(to bottom, #ffffff, #f8f9ff);
            border-radius: 25px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.08);
            overflow: visible;
            margin-bottom: 2.5rem;
            border: 1px solid rgba(102, 126, 234, 0.1);
        }
        .content-card-header {
            padding: 2rem 2.5rem;
            border-bottom: 2px solid rgba(102, 126, 234, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: white;
            border-radius: 25px 25px 0 0;
        }
        .content-card-header h3 {
            font-size: 1.5rem;
            font-weight: 800;
            color: #2d3748;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        .content-card-header p {
            color: #8b92a7;
            margin: 0.25rem 0 0 0;
            font-size: 0.9rem;
        }
        .content-card-body {
            padding: 1.5rem;
        }
        
        /* Modern Table */
        .modern-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0 0.75rem;
        }
        .modern-table thead {
            background: transparent;
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
        
        /* Table Cell Styles */
        .table-cell-primary {
            font-weight: 700;
            font-size: 1.05rem;
            color: #2d3748;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
        .table-cell-avatar {
            width: 45px;
            height: 45px;
            border-radius: 12px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            font-size: 1.1rem;
        }
        .table-cell-secondary {
            font-size: 0.85rem;
            color: #8b92a7;
            margin-top: 0.25rem;
        }
        .table-cell-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            padding: 0.5rem 1rem;
            border-radius: 50px;
            font-size: 0.8rem;
            font-weight: 600;
            white-space: nowrap;
        }
        .table-cell-badge.success {
            background: linear-gradient(135deg, #d4fc79, #96e6a1);
            color: #155724;
        }
        .table-cell-badge.warning {
            background: linear-gradient(135deg, #ffeaa7, #fdcb6e);
            color: #856404;
        }
        .table-cell-badge.info {
            background: linear-gradient(135deg, #a8edea, #74ebd5);
            color: #004085;
        }
        .table-cell-badge.primary {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
        }
        
        /* Action Buttons */
        .action-btn {
            padding: 0.65rem 1.5rem;
            border-radius: 50px;
            font-weight: 700;
            font-size: 0.9rem;
            transition: all 0.3s ease;
            border: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }
        .action-btn.primary {
            background: linear-gradient(135deg, #f093fb, #f5576c);
            color: white;
            box-shadow: 0 4px 15px rgba(245, 87, 108, 0.3);
        }
        .action-btn.primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(245, 87, 108, 0.5);
            color: white;
        }
        .action-btn-icon {
            width: 40px;
            height: 40px;
            border-radius: 12px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            font-size: 1.1rem;
        }
        .action-btn-icon.pause { 
            background: linear-gradient(135deg, #ffeaa7, #fdcb6e);
            color: #f57c00;
            box-shadow: 0 4px 12px rgba(253, 203, 110, 0.4);
        }
        .action-btn-icon.play { 
            background: linear-gradient(135deg, #d4fc79, #96e6a1);
            color: #2d7a3e;
            box-shadow: 0 4px 12px rgba(150, 230, 161, 0.4);
        }
        .action-btn-icon.assign { 
            background: linear-gradient(135deg, #a8edea, #74ebd5);
            color: #0277bd;
            box-shadow: 0 4px 12px rgba(116, 235, 213, 0.4);
        }
        .action-btn-icon.edit { 
            background: linear-gradient(135deg, #d299c2, #fef9d7);
            color: #7b1fa2;
            box-shadow: 0 4px 12px rgba(210, 153, 194, 0.4);
        }
        .action-btn-icon.delete { 
            background: linear-gradient(135deg, #ff9a9e, #fecfef);
            color: #c62828;
            box-shadow: 0 4px 12px rgba(255, 154, 158, 0.4);
        }
        .action-btn-icon.view {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
        }
        .action-btn-icon:hover {
            transform: translateY(-3px) scale(1.05);
            box-shadow: 0 8px 20px rgba(0,0,0,0.2);
        }
        
        /* Status Badge */
        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1.1rem;
            border-radius: 50px;
            font-size: 0.85rem;
            font-weight: 700;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        .status-badge.active { 
            background: linear-gradient(135deg, #d4fc79, #96e6a1);
            color: #2d7a3e;
        }
        .status-badge.paused { 
            background: linear-gradient(135deg, #ffeaa7, #fdcb6e);
            color: #f57c00;
        }
        
        /* Progress Status Badges */
        .status-badge.pending {
    background: linear-gradient(176deg, #ff2e00, #ff0053);
    color: #ffffff;
        }
        .status-badge.in-progress {
            background: linear-gradient(135deg, #a8edea, #74ebd5);
            color: #0277bd;
        }
        .status-badge.completed {
            background: linear-gradient(135deg, #d4fc79, #96e6a1);
            color: #2d7a3e;
        }
        
        /* Toast */
        .toast-modern {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
            background: white;
            border-radius: 15px;
            padding: 1.25rem 1.5rem;
            box-shadow: 0 10px 40px rgba(0,0,0,0.15);
            display: flex;
            align-items: center;
            gap: 1rem;
            min-width: 300px;
            animation: slideIn 0.3s ease;
        }
        .toast-modern.success { border-left: 4px solid #10b981; }
        .toast-modern.error { border-left: 4px solid #ef4444; }
        @keyframes slideIn {
            from { transform: translateX(400px); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
        .toast-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.3rem;
        }
        .toast-modern.success .toast-icon { background: #d1fae5; color: #10b981; }
        .toast-modern.error .toast-icon { background: #fee2e2; color: #ef4444; }
        
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
        
        /* Modern Modal Styles */
        .modal-content {
            border-radius: 25px;
            border: none;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            overflow: hidden;
        }
        .modal-header {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            padding: 2rem 2.5rem;
            border: none;
        }
        .modal-header .modal-title {
            font-size: 1.5rem;
            font-weight: 800;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
        .modal-header .btn-close {
            filter: brightness(0) invert(1);
            opacity: 0.8;
        }
        .modal-header .btn-close:hover {
            opacity: 1;
        }
        .modal-body {
            padding: 2.5rem;
            background: #f8f9ff;
        }
        .modal-footer {
            padding: 1.5rem 2.5rem;
            border: none;
            background: white;
        }
        
        /* Modern Form Styles */
        .form-label {
            font-weight: 700;
            color: #2d3748;
            margin-bottom: 0.5rem;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .form-control, .form-select {
            border-radius: 12px;
            border: 2px solid #e0e7ff;
            padding: 0.75rem 1rem;
            transition: all 0.3s ease;
            background: white;
        }
        .form-control:focus, .form-select:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
            background: white;
        }
        .form-text {
            color: #8b92a7;
            font-size: 0.85rem;
            margin-top: 0.5rem;
        }
        .form-check-input {
            width: 1.25rem;
            height: 1.25rem;
            border-radius: 6px;
            border: 2px solid #e0e7ff;
        }
        .form-check-input:checked {
            background-color: #667eea;
            border-color: #667eea;
        }
        .form-check-label {
            font-weight: 600;
            color: #2d3748;
            margin-left: 0.5rem;
        }
        
        /* Modal Buttons */
        .btn-modal-primary {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            border: none;
            padding: 0.75rem 2rem;
            border-radius: 50px;
            font-weight: 700;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
        }
        .btn-modal-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.5);
            color: white;
        }
        .btn-modal-secondary {
            background: white;
            color: #667eea;
            border: 2px solid #667eea;
            padding: 0.75rem 2rem;
            border-radius: 50px;
            font-weight: 700;
            transition: all 0.3s ease;
        }
        .btn-modal-secondary:hover {
            background: #667eea;
            color: white;
            transform: translateY(-2px);
        }
        .btn-modal-cancel {
            background: #f0f0f0;
            color: #5a6c7d;
            border: none;
            padding: 0.75rem 2rem;
            border-radius: 50px;
            font-weight: 700;
            transition: all 0.3s ease;
        }
        .btn-modal-cancel:hover {
            background: #e0e0e0;
            color: #2d3748;
        }
        
        /* Input Group Styling */
        .mb-3 {
            margin-bottom: 1.5rem !important;
        }
        .modal-body .mb-3:last-child {
            margin-bottom: 0 !important;
        }
        
        /* Toast Notification Container */
        .toast-container-custom {
            position: fixed;
            top: 90px;
            right: 20px;
            z-index: 9999;
            max-width: 400px;
            pointer-events: none;
        }
        
        /* Toast Notification */
        .toast-notification {
            background: white;
            border-radius: 15px;
            padding: 1.25rem;
            margin-bottom: 1rem;
            box-shadow: 0 10px 40px rgba(0,0,0,0.15);
            border-left: 4px solid #667eea;
            animation: slideInRight 0.4s ease;
            pointer-events: all;
            position: relative;
            overflow: hidden;
        }
        .toast-notification::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, #667eea, #764ba2);
        }
        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(400px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
        .toast-notification.removing {
            animation: slideOutRight 0.3s ease forwards;
        }
        @keyframes slideOutRight {
            to {
                opacity: 0;
                transform: translateX(400px);
            }
        }
        .toast-header-custom {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-bottom: 0.75rem;
        }
        .toast-avatar {
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
            flex-shrink: 0;
        }
        .toast-user-info {
            flex: 1;
        }
        .toast-user-name {
            font-weight: 700;
            color: #2d3748;
            font-size: 0.95rem;
            margin-bottom: 0.1rem;
        }
        .toast-time {
            color: #a0aec0;
            font-size: 0.75rem;
            display: flex;
            align-items: center;
            gap: 0.25rem;
        }
        .toast-close {
            background: none;
            border: none;
            color: #a0aec0;
            font-size: 1.2rem;
            cursor: pointer;
            padding: 0;
            width: 24px;
            height: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            transition: all 0.2s ease;
        }
        .toast-close:hover {
            background: #f0f0f0;
            color: #2d3748;
        }
        .toast-body-custom {
            padding-left: 3.25rem;
        }
        .toast-job {
            font-weight: 600;
            color: #2d3748;
            font-size: 0.9rem;
            margin-bottom: 0.35rem;
            display: flex;
            align-items: center;
            gap: 0.4rem;
        }
        .toast-company {
            color: #667eea;
            font-size: 0.85rem;
            margin-bottom: 0.35rem;
            display: flex;
            align-items: center;
            gap: 0.4rem;
        }
        .toast-client {
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            padding: 0.3rem 0.75rem;
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 600;
            background: linear-gradient(135deg, #f8f9ff, #e8edff);
            color: #667eea;
            border: 1px solid #e0e7ff;
        }
        
        /* Activity Badge (Live indicator) */
        .activity-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            padding: 0.4rem 0.9rem;
            border-radius: 50px;
            font-size: 0.8rem;
            font-weight: 700;
            background: linear-gradient(135deg, #d4fc79, #96e6a1);
            color: #2d7a3e;
            box-shadow: 0 2px 8px rgba(150, 230, 161, 0.3);
        }
        
        /* Empty/Loading States */
        .activity-empty {
            text-align: center;
            padding: 4rem 2rem;
            color: #8b92a7;
        }
        .activity-empty-icon {
            font-size: 4rem;
            margin-bottom: 1rem;
            opacity: 0.3;
        }
        .activity-empty-text {
            font-size: 1.1rem;
            font-weight: 600;
        }
        .activity-loading {
            text-align: center;
            padding: 3rem 2rem;
            color: #8b92a7;
        }
        .activity-loading-spinner {
            display: inline-block;
            width: 40px;
            height: 40px;
            border: 4px solid #f0f0f0;
            border-top-color: #667eea;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }
        @keyframes spin {
            to { transform: rotate(360deg); }
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
        .digest-card.performer { border-left-color: #f093fb; }
        .digest-card.team { border-left-color: #43e97b; }
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
        
        /* Team Activity List */
        .team-activity-list {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }
        .activity-member-card {
            background: white;
            border-radius: 15px;
            padding: 1.25rem;
            border: 1px solid #f0f0f0;
            transition: all 0.3s ease;
        }
        .activity-member-card:hover {
            border-color: #667eea;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.1);
        }
        .member-avatar {
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
        .member-name {
            font-weight: 700;
            color: #2d3748;
            font-size: 1rem;
            margin-bottom: 0.4rem;
        }
        .member-clients {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
        }
        .client-tag {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 600;
            background: #f8f9ff;
            color: #667eea;
            border: 1px solid #e0e7ff;
        }
        .member-stats {
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
            font-size: 0.9rem;
        }
        .stat-badge.apps {
            background: linear-gradient(135deg, #a8edea, #74ebd5);
            color: #0277bd;
        }
        .stat-badge.earning {
            background: linear-gradient(135deg, #d4fc79, #96e6a1);
            color: #2d7a3e;
        }
        
        /* Progress Bar */
        .progress-container {
            width: 100%;
            max-width: 200px;
        }
        .progress-bar-wrapper {
            width: 100%;
            height: 8px;
            background: #f0f0f0;
            border-radius: 50px;
            overflow: hidden;
            margin-bottom: 0.4rem;
        }
        .progress-bar-fill {
            height: 100%;
            border-radius: 50px;
            transition: width 0.3s ease;
            background: linear-gradient(90deg, #667eea, #764ba2);
        }
        .progress-bar-fill.completed {
            background: linear-gradient(90deg, #d4fc79, #96e6a1);
        }
        .progress-text {
            font-size: 0.8rem;
            font-weight: 600;
            color: #5a6c7d;
            text-align: center;
        }
        .progress-text.completed {
            color: #2d7a3e;
        }
    </style>

    {{-- Toast Notifications --}}
    @if(session('success'))
        <div class="toast-modern success" id="toast">
            <div class="toast-icon">✓</div>
            <div class="flex-grow-1">
                <strong>Success!</strong>
                <div class="small text-muted">{{ session('success') }}</div>
            </div>
            <button type="button" class="btn-close" onclick="document.getElementById('toast').remove()"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="toast-modern error" id="toast">
            <div class="toast-icon">!</div>
            <div class="flex-grow-1">
                <strong>Error</strong>
                @foreach($errors->all() as $error)
                    <div class="small text-muted">{{ $error }}</div>
                @endforeach
            </div>
            <button type="button" class="btn-close" onclick="document.getElementById('toast').remove()"></button>
        </div>
    @endif

    <div class="admin-dashboard">
        {{-- Header --}}
        <div class="admin-header">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1>🎯 Admin Dashboard</h1>
                    <p>Manage your team, clients, and track all applications</p>
                </div>
                <div class="col-md-4 text-md-end mt-3 mt-md-0">
                    <a href="{{ route('admin.earnings.index') }}" class="btn btn-light btn-lg rounded-pill">
                        <i class="bi bi-graph-up-arrow me-2"></i>View Team Earnings
                    </a>
                </div>
            </div>
        </div>

        {{-- KPI Cards --}}
        @php
            $totalClients      = $clients->count();
            $totalTeamMembers  = $teamMembers->count();
            $totalApplications = 0;
            $totalEarnings     = 0;

            foreach ($clients as $c) {
                if ($c->relationLoaded('applications') || method_exists($c, 'applications')) {
                    $totalApplications += $c->applications->count();
                    $totalEarnings     += $c->applications->sum('earning');
                }
            }
        @endphp

        <div class="kpi-grid">
            <div class="kpi-card blue">
                <div class="kpi-icon">👥</div>
                <div class="kpi-label">Total Clients</div>
                <div class="kpi-value">{{ $totalClients }}</div>
                <div class="kpi-description">Active clients</div>
            </div>
            
            <div class="kpi-card green">
                <div class="kpi-icon">👨‍💼</div>
                <div class="kpi-label">Team Members</div>
                <div class="kpi-value">{{ $totalTeamMembers }}</div>
                <div class="kpi-description">Active team</div>
            </div>
            
            <div class="kpi-card cyan">
                <div class="kpi-icon">📄</div>
                <div class="kpi-label">Applications</div>
                <div class="kpi-value">{{ $totalApplications }}</div>
                <div class="kpi-description">Total submitted</div>
            </div>
            
            <div class="kpi-card yellow">
                <div class="kpi-icon">💰</div>
                <div class="kpi-label">Total Earnings</div>
                <div class="kpi-value">Rs. {{ number_format($totalEarnings, 0) }}</div>
                <div class="kpi-description">Revenue generated</div>
            </div>
        </div>

        {{-- Toast Notification Container --}}
        <div class="toast-container-custom" id="toast-container">
            <!-- Toast notifications will appear here -->
        </div>
        
        {{-- Recent Activity Info Card --}}
        <div class="content-card">
            <div class="content-card-header">
                <div>
                    <h3><i class="bi bi-bell-fill me-2" style="color: #f5576c;"></i>Live Notifications</h3>
                    <p>Real-time toast notifications when team members submit applications</p>
                </div>
                <div class="activity-badge">
                    <i class="bi bi-circle-fill" style="font-size: 0.5rem;"></i>
                    Live
                </div>
            </div>
            <div class="content-card-body">
                <div id="activity-loading" class="activity-loading">
                    <div class="activity-loading-spinner"></div>
                    <div class="mt-2">Monitoring for new activities...</div>
                </div>
                <div id="activity-empty" class="activity-empty" style="display: none;">
                    <div class="activity-empty-icon">🔔</div>
                    <div class="activity-empty-text">Waiting for new applications</div>
                    <div class="mt-2" style="font-size: 0.9rem; color: #a0aec0;">Toast notifications will appear in the top-right corner when team members submit applications</div>
                </div>
            </div>
        </div>

        {{-- Daily Digest Section --}}
        <div class="content-card">
            <div class="content-card-header">
                <div>
                    <h3><i class="bi bi-calendar-check me-2" style="color: #f5576c;"></i>Daily Digest</h3>
                    <p>Summary of today's team activity</p>
                </div>
                <div class="activity-badge">
                    <i class="bi bi-calendar-day"></i>
                    {{ now()->format('M d, Y') }}
                </div>
            </div>
            <div class="content-card-body p-4">
                @php
                    $today = now()->startOfDay();
                    $todayApplications = \App\Models\Application::whereDate('created_at', $today)->get();
                    $todayCount = $todayApplications->count();
                    $todayEarnings = $todayApplications->sum('earning');
                    $todayTailored = $todayApplications->where('tailored_resume', true)->count();
                    
                    // Group by team member
                    $teamActivity = $todayApplications->groupBy('team_id')->map(function($apps) {
                        return [
                            'user' => $apps->first()->teamMember,
                            'count' => $apps->count(),
                            'earning' => $apps->sum('earning'),
                            'clients' => $apps->pluck('client.name')->unique()->filter()->values()
                        ];
                    })->sortByDesc('count');
                    
                    // Top performer
                    $topPerformer = $teamActivity->first();
                @endphp
                
                <div class="digest-grid">
                    {{-- Today's Summary --}}
                    <div class="digest-card summary">
                        <div class="digest-icon">📊</div>
                        <div class="digest-content">
                            <div class="digest-label">Today's Applications</div>
                            <div class="digest-value">{{ $todayCount }}</div>
                            <div class="digest-meta">
                                Rs. {{ number_format($todayEarnings, 2) }} earned • {{ $todayTailored }} tailored
                            </div>
                        </div>
                    </div>
                    
                    {{-- Top Performer --}}
                    @if($topPerformer)
                    <div class="digest-card performer">
                        <div class="digest-icon">🏆</div>
                        <div class="digest-content">
                            <div class="digest-label">Top Performer Today</div>
                            <div class="digest-value">{{ $topPerformer['user']->name ?? 'N/A' }}</div>
                            <div class="digest-meta">
                                {{ $topPerformer['count'] }} applications • Rs. {{ number_format($topPerformer['earning'], 2) }}
                            </div>
                        </div>
                    </div>
                    @endif
                    
                    {{-- Active Team Members --}}
                    <div class="digest-card team">
                        <div class="digest-icon">👥</div>
                        <div class="digest-content">
                            <div class="digest-label">Active Team Members</div>
                            <div class="digest-value">{{ $teamActivity->count() }}</div>
                            <div class="digest-meta">
                                {{ $teamMembers->count() }} total members
                            </div>
                        </div>
                    </div>
                </div>
                
                {{-- Team Activity Breakdown --}}
                @if($teamActivity->isNotEmpty())
                <div class="mt-4">
                    <h5 class="mb-3" style="font-weight: 700; color: #2d3748;">
                        <i class="bi bi-person-lines-fill me-2"></i>Team Activity Breakdown
                    </h5>
                    <div class="team-activity-list">
                        @foreach($teamActivity as $activity)
                        <div class="activity-member-card">
                            <div class="d-flex align-items-center gap-3">
                                <div class="member-avatar">
                                    {{ strtoupper(substr($activity['user']->name ?? 'N', 0, 2)) }}
                                </div>
                                <div class="flex-grow-1">
                                    <div class="member-name">{{ $activity['user']->name ?? 'Unknown' }}</div>
                                    <div class="member-clients">
                                        @foreach($activity['clients']->take(3) as $client)
                                            <span class="client-tag">{{ $client }}</span>
                                        @endforeach
                                        @if($activity['clients']->count() > 3)
                                            <span class="client-tag">+{{ $activity['clients']->count() - 3 }} more</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="member-stats">
                                    <div class="stat-badge apps">
                                        <i class="bi bi-file-earmark-text"></i>
                                        {{ $activity['count'] }}
                                    </div>
                                    <div class="stat-badge earning">
                                        <i class="bi bi-currency-dollar"></i>
                                        {{ number_format($activity['earning'], 0) }}
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
                    <div class="empty-state-text">No activity today yet</div>
                    <p class="text-muted mt-2">Team activity will appear here as applications are submitted</p>
                </div>
                @endif
            </div>
        </div>

        {{-- Clients Section --}}
        <div class="content-card">
            <div class="content-card-header">
                <div>
                    <h3><i class="bi bi-people-fill me-2" style="color: #f5576c;"></i>Clients</h3>
                    <p>Manage your client database</p>
                </div>
                <button class="action-btn primary" data-bs-toggle="modal" data-bs-target="#addClientModal">
                    <i class="bi bi-plus-lg me-2"></i>Add Client
                </button>
            </div>
            <div class="content-card-body">
                @if($clients->isEmpty())
                    <div class="empty-state">
                        <div class="empty-state-icon">👥</div>
                        <div class="empty-state-text">No clients yet. Add your first client to get started!</div>
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="modern-table">
                            <thead>
                                <tr>
                                    <th>Client</th>
                                    <th>Contact</th>
                                    <th>Sheet</th>
                                    <th class="text-center">Progress</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($clients as $client)
                                    <tr>
                                        <td>
                                            <div class="table-cell-primary">
                                                <div class="table-cell-avatar">
                                                    {{ strtoupper(substr($client->name, 0, 2)) }}
                                                </div>
                                                <div>
                                                    <div>{{ $client->name }}</div>
                                                    <div class="table-cell-secondary">ID: #{{ $client->id }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="small">
                                                @if($client->email)
                                                    <div><i class="bi bi-envelope me-1"></i>{{ $client->email }}</div>
                                                @endif
                                                @if($client->phone)
                                                    <div><i class="bi bi-telephone me-1"></i>{{ $client->phone }}</div>
                                                @endif
                                            </div>
                                        </td>
                                        <td>
                                            @if($client->google_sheet_id)
                                                <a href="https://docs.google.com/spreadsheets/d/{{ $client->google_sheet_id }}" 
                                                   target="_blank" 
                                                   class="table-cell-badge success">
                                                    <i class="bi bi-file-earmark-spreadsheet"></i> Linked
                                                </a>
                                            @else
                                                <span class="table-cell-badge" style="background: #f0f0f0; color: #8b92a7;">
                                                    <i class="bi bi-x-circle"></i> Not linked
                                                </span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @php
                                                $clientTasks = $client->tasks;
                                                $totalTarget = $clientTasks->sum('target_applications');
                                                $totalCompleted = $clientTasks->sum('completed_applications');
                                                $isAssigned = $clientTasks->count() > 0;
                                                $isCompleted = $totalTarget > 0 && $totalCompleted >= $totalTarget;
                                                
                                                if (!$isAssigned) {
                                                    $progressStatus = 'pending';
                                                    $progressText = 'Pending';
                                                    $progressIcon = 'clock';
                                                } elseif ($isCompleted) {
                                                    $progressStatus = 'completed';
                                                    $progressText = 'Completed';
                                                    $progressIcon = 'check-circle-fill';
                                                } else {
                                                    $progressStatus = 'in-progress';
                                                    $progressText = 'In Progress';
                                                    $progressIcon = 'arrow-repeat';
                                                }
                                            @endphp
                                            <span class="status-badge {{ $progressStatus }}">
                                                <i class="bi bi-{{ $progressIcon }}"></i> {{ $progressText }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            @if($client->application_status === 'paused')
                                                <span class="status-badge paused">
                                                    <i class="bi bi-pause-fill"></i> Paused
                                                </span>
                                            @else
                                                <span class="status-badge active">
                                                    <i class="bi bi-check-circle-fill"></i> Active
                                                </span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <div class="d-flex justify-content-center gap-2">
                                                @if($client->application_status === 'paused')
                                                    <form action="{{ route('clients.resume', $client) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        <button type="submit" class="action-btn-icon play" title="Resume">
                                                            <i class="bi bi-play-fill"></i>
                                                        </button>
                                                    </form>
                                                @else
                                                    <form action="{{ route('clients.pause', $client) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        <button type="submit" class="action-btn-icon pause" title="Pause">
                                                            <i class="bi bi-pause-fill"></i>
                                                        </button>
                                                    </form>
                                                @endif
                                                <button class="action-btn-icon assign" data-bs-toggle="modal" data-bs-target="#assignClientModal-{{ $client->id }}" title="Assign">
                                                    <i class="bi bi-person-plus"></i>
                                                </button>
                                                <button class="action-btn-icon edit" data-bs-toggle="modal" data-bs-target="#editClientModal-{{ $client->id }}" title="Edit">
                                                    <i class="bi bi-pencil"></i>
                                                </button>
                                                <form action="{{ route('clients.destroy', $client) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this client?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="action-btn-icon delete" title="Delete">
                                                        <i class="bi bi-trash"></i>
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

        {{-- Team Members Section --}}
        <div class="content-card">
            <div class="content-card-header">
                <div>
                    <h3><i class="bi bi-person-workspace me-2" style="color: #f5576c;"></i>Team Members</h3>
                    <p>Manage your team</p>
                </div>
                <button class="action-btn primary" data-bs-toggle="modal" data-bs-target="#addTeamMemberModal">
                    <i class="bi bi-person-plus-fill me-2"></i>Add Member
                </button>
            </div>
            <div class="content-card-body">
                @if($teamMembers->isEmpty())
                    <div class="empty-state">
                        <div class="empty-state-icon">👨‍💼</div>
                        <div class="empty-state-text">No team members yet. Add your first team member!</div>
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="modern-table">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($teamMembers as $member)
                                    <tr>
                                        <td>
                                            <div class="table-cell-primary">
                                                <div class="table-cell-avatar" style="background: linear-gradient(135deg, #4facfe, #00f2fe);">
                                                    {{ strtoupper(substr($member->name, 0, 2)) }}
                                                </div>
                                                <div>{{ $member->name }}</div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="table-cell-secondary" style="font-size: 0.95rem; color: #5a6c7d;">
                                                <i class="bi bi-envelope me-1"></i>{{ $member->email }}
                                            </div>
                                        </td>
                                        <td><span class="table-cell-badge primary">{{ ucfirst($member->role) }}</span></td>
                                        <td class="text-center">
                                            <form action="{{ route('team-members.destroy', $member) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this team member?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="action-btn-icon delete" title="Delete">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>

        {{-- Task Assignments --}}
        <div class="content-card">
            <div class="content-card-header">
                <div>
                    <h3><i class="bi bi-diagram-3-fill me-2" style="color: #f5576c;"></i>Task Assignments</h3>
                    <p>Manage team member assignments and pause/resume access</p>
                </div>
            </div>
            <div class="content-card-body">
                @php
                    $allTasks = \App\Models\Task::with(['client', 'assignee'])->where('is_active', true)->get();
                @endphp
                @if($allTasks->isEmpty())
                    <div class="empty-state">
                        <div class="empty-state-icon">📋</div>
                        <div class="empty-state-text">No task assignments yet</div>
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="modern-table">
                            <thead>
                                <tr>
                                    <th>Team Member</th>
                                    <th>Client</th>
                                    <th class="text-center">Progress</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($allTasks as $task)
                                    @php
                                        $target = $task->target_applications ?? 0;
                                        $completed = $task->completed_applications ?? 0;
                                        $percentage = $target > 0 ? min(($completed / $target) * 100, 100) : 0;
                                        $isCompleted = $target > 0 && $completed >= $target;
                                    @endphp
                                    <tr>
                                        <td>
                                            <div class="table-cell-primary">
                                                <div class="table-cell-avatar" style="background: linear-gradient(135deg, #43e97b, #38f9d7);">
                                                    {{ strtoupper(substr($task->assignee->name ?? 'N', 0, 2)) }}
                                                </div>
                                                <div>{{ $task->assignee->name ?? 'N/A' }}</div>
                                            </div>
                                        </td>
                                        <td>
                                            <strong style="color: #2d3748;">{{ $task->client->name ?? 'N/A' }}</strong>
                                        </td>
                                        <td class="text-center">
                                            <div class="progress-container mx-auto">
                                                <div class="progress-bar-wrapper">
                                                    <div class="progress-bar-fill {{ $isCompleted ? 'completed' : '' }}" 
                                                         style="width: {{ $percentage }}%">
                                                    </div>
                                                </div>
                                                <div class="progress-text {{ $isCompleted ? 'completed' : '' }}">
                                                    {{ $completed }} / {{ $target }} ({{ number_format($percentage, 0) }}%)
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            @if($isCompleted)
                                                <span class="status-badge completed">
                                                    <i class="bi bi-check-circle-fill"></i> Completed
                                                </span>
                                            @elseif($task->is_paused)
                                                <span class="status-badge paused">
                                                    <i class="bi bi-pause-fill"></i> Paused
                                                </span>
                                            @else
                                                <span class="status-badge in-progress">
                                                    <i class="bi bi-arrow-repeat"></i> In Progress
                                                </span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <div class="d-flex justify-content-center gap-2">
                                                @if($task->is_paused)
                                                    <form action="{{ route('tasks.resume', $task) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        <button type="submit" class="action-btn-icon play" title="Resume">
                                                            <i class="bi bi-play-fill"></i>
                                                        </button>
                                                    </form>
                                                @else
                                                    <form action="{{ route('tasks.pause', $task) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        <button type="submit" class="action-btn-icon pause" title="Pause">
                                                            <i class="bi bi-pause-fill"></i>
                                                        </button>
                                                    </form>
                                                @endif
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

        {{-- Application Summary --}}
        <div class="content-card">
            <div class="content-card-header">
                <div>
                    <h3><i class="bi bi-bar-chart-fill me-2" style="color: #f5576c;"></i>Application Summary</h3>
                    <p>Overview of applications per client</p>
                </div>
            </div>
            <div class="content-card-body">
                @if($clients->isEmpty())
                    <div class="empty-state">
                        <div class="empty-state-icon">📊</div>
                        <div class="empty-state-text">No data available yet</div>
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="modern-table">
                            <thead>
                                <tr>
                                    <th>Client</th>
                                    <th>Assigned To</th>
                                    <th class="text-center">Target</th>
                                    <th class="text-center">Completed</th>
                                    <th class="text-center">Progress</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($clients as $client)
                                    @php
                                        $clientTasks    = $client->tasks;
                                        $totalTarget    = $clientTasks->sum('target_applications');
                                        $totalCompleted = $clientTasks->sum('completed_applications');
                                        $assignedNames = $clientTasks->pluck('assignee.name')->filter()->unique()->values();
                                        $assignedToText = $assignedNames->isEmpty() ? 'Not assigned' : $assignedNames->join(', ');
                                        
                                        // Calculate progress status
                                        $isAssigned = $clientTasks->count() > 0;
                                        $isCompleted = $totalTarget > 0 && $totalCompleted >= $totalTarget;
                                        
                                        if (!$isAssigned) {
                                            $progressStatus = 'pending';
                                            $progressText = 'Pending';
                                            $progressIcon = 'clock';
                                        } elseif ($isCompleted) {
                                            $progressStatus = 'completed';
                                            $progressText = 'Completed';
                                            $progressIcon = 'check-circle-fill';
                                        } else {
                                            $progressStatus = 'in-progress';
                                            $progressText = 'In Progress';
                                            $progressIcon = 'arrow-repeat';
                                        }
                                    @endphp
                                    <tr>
                                        <td>
                                            <div class="table-cell-primary">
                                                <div class="table-cell-avatar" style="background: linear-gradient(135deg, #fa709a, #fee140);">
                                                    {{ strtoupper(substr($client->name, 0, 2)) }}
                                                </div>
                                                <div>{{ $client->name }}</div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="table-cell-secondary" style="font-size: 0.95rem; color: #5a6c7d;">
                                                <i class="bi bi-people me-1"></i>{{ $assignedToText }}
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <span class="table-cell-badge" style="background: #f0f0f0; color: #5a6c7d;">
                                                <i class="bi bi-bullseye"></i> {{ $totalTarget }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <span class="table-cell-badge primary">
                                                <i class="bi bi-check-circle-fill"></i> {{ $totalCompleted }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <span class="status-badge {{ $progressStatus }}">
                                                <i class="bi bi-{{ $progressIcon }}"></i> {{ $progressText }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <div class="d-flex justify-content-center gap-2">
                                                <button class="action-btn-icon assign" data-bs-toggle="modal" data-bs-target="#assignClientModal-{{ $client->id }}" title="Assign">
                                                    <i class="bi bi-person-plus"></i>
                                                </button>
                                                <a href="{{ route('admin.clients.applications', $client->id) }}" class="action-btn-icon view" title="View Applications">
                                                    <i class="bi bi-eye-fill"></i>
                                                </a>
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
                                        

    {{-- ========= MODALS (unchanged logic, just styled with Bootstrap) ========= --}}

    {{-- Add Client Modal --}}
    <div class="modal fade" id="addClientModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="{{ route('clients.store') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">
                            <i class="bi bi-person-plus-fill"></i>
                            Add New Client
                        </h5>
                        <button
                            type="button"
                            class="btn-close"
                            data-bs-dismiss="modal"
                            aria-label="Close"
                        ></button>
                    </div>
                    <div class="modal-body">

                        <div class="mb-3">
                            <label class="form-label" for="client_name">Name *</label>
                            <input type="text" id="client_name" name="name"
                                   class="form-control" required />
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="client_email">Email</label>
                            <input type="email" id="client_email" name="email"
                                   class="form-control" />
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="client_phone">Phone</label>
                            <input type="text" id="client_phone" name="phone"
                                   class="form-control" />
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="client_linkedin">LinkedIn URL</label>
                            <input type="url" id="client_linkedin" name="linkedin_url"
                                   class="form-control" />
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="client_notes">Notes</label>
                            <textarea id="client_notes" name="notes"
                                      class="form-control" rows="3"></textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="client_sheet_url">
                                Google Sheet URL or ID (optional)
                            </label>
                            <input
                                type="text"
                                id="client_sheet_url"
                                name="sheet_url"
                                class="form-control @error('sheet_url') is-invalid @enderror"
                                value="{{ old('sheet_url') }}"
                            />
                            @error('sheet_url')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                            <div class="form-text">
                                Paste a Google Sheet link like
                                <span class="text-muted">
                                    https://docs.google.com/spreadsheets/d/XXXXX/edit
                                </span>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn-modal-cancel" data-bs-dismiss="modal">
                            <i class="bi bi-x-lg me-2"></i>Cancel
                        </button>
                        <button type="submit" class="btn-modal-primary">
                            <i class="bi bi-check-lg me-2"></i>Save Client
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Add Team Member Modal --}}
    <div class="modal fade" id="addTeamMemberModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="{{ route('team-members.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="_form" value="team_member">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            <i class="bi bi-person-workspace"></i>
                            Add Team Member
                        </h5>
                        <button
                            type="button"
                            class="btn-close"
                            data-bs-dismiss="modal"
                            aria-label="Close"
                        ></button>
                    </div>
                    <div class="modal-body">

                        <div class="mb-3">
                            <label class="form-label" for="tm_name">Name *</label>
                            <input
                                type="text"
                                id="tm_name"
                                name="name"
                                class="form-control @error('name') is-invalid @enderror"
                                value="{{ old('name') }}"
                                required
                            />
                            @error('name')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="tm_email">Email *</label>
                            <input
                                type="email"
                                id="tm_email"
                                name="email"
                                class="form-control @error('email') is-invalid @enderror"
                                value="{{ old('email') }}"
                                required
                            />
                            @error('email')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="tm_password">Password *</label>
                            <input
                                type="password"
                                id="tm_password"
                                name="password"
                                class="form-control @error('password') is-invalid @enderror"
                                required
                            />
                            @error('password')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-check mb-3">
                            <input
                                class="form-check-input"
                                type="checkbox"
                                value="1"
                                id="tm_active"
                                name="is_active"
                                {{ old('is_active', '1') ? 'checked' : '' }}
                            />
                            <label class="form-check-label" for="tm_active">
                                Active
                            </label>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn-modal-cancel" data-bs-dismiss="modal">
                            <i class="bi bi-x-lg me-2"></i>Cancel
                        </button>
                        <button type="submit" class="btn-modal-primary">
                            <i class="bi bi-check-lg me-2"></i>Save Member
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Edit Client Modals --}}
    @foreach($clients as $client)
        <div class="modal fade" id="editClientModal-{{ $client->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form action="{{ route('clients.update', $client) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="modal-header">
                            <h5 class="modal-title">
                                <i class="bi bi-pencil-square"></i>
                                Edit Client
                            </h5>
                            <button
                                type="button"
                                class="btn-close"
                                data-bs-dismiss="modal"
                                aria-label="Close"
                            ></button>
                        </div>
                        <div class="modal-body">

                            <div class="mb-3">
                                <label class="form-label" for="client_name_{{ $client->id }}">Name *</label>
                                <input
                                    type="text"
                                    id="client_name_{{ $client->id }}"
                                    name="name"
                                    class="form-control"
                                    value="{{ old('name', $client->name) }}"
                                    required
                                />
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="client_email_{{ $client->id }}">Email</label>
                                <input
                                    type="email"
                                    id="client_email_{{ $client->id }}"
                                    name="email"
                                    class="form-control"
                                    value="{{ old('email', $client->email) }}"
                                />
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="client_phone_{{ $client->id }}">Phone</label>
                                <input
                                    type="text"
                                    id="client_phone_{{ $client->id }}"
                                    name="phone"
                                    class="form-control"
                                    value="{{ old('phone', $client->phone) }}"
                                />
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="client_linkedin_{{ $client->id }}">LinkedIn URL</label>
                                <input
                                    type="url"
                                    id="client_linkedin_{{ $client->id }}"
                                    name="linkedin_url"
                                    class="form-control"
                                    value="{{ old('linkedin_url', $client->linkedin_url) }}"
                                />
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="client_notes_{{ $client->id }}">Notes</label>
                                <textarea
                                    id="client_notes_{{ $client->id }}"
                                    name="notes"
                                    class="form-control"
                                    rows="3"
                                >{{ old('notes', $client->notes) }}</textarea>
                            </div>

                            <div class="mb-3">
                                @php
                                    $sheetUrlValue = old('sheet_url', $client->google_sheet_id
                                        ? 'https://docs.google.com/spreadsheets/d/'.$client->google_sheet_id.'/edit'
                                        : ''
                                    );
                                @endphp
                                <label class="form-label" for="client_sheet_url_{{ $client->id }}">
                                    Google Sheet URL or ID (optional)
                                </label>
                                <input
                                    type="text"
                                    id="client_sheet_url_{{ $client->id }}"
                                    name="sheet_url"
                                    class="form-control @error('sheet_url') is-invalid @enderror"
                                    value="{{ $sheetUrlValue }}"
                                />
                                @error('sheet_url')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror>
                                <div class="form-text">
                                    Paste a Google Sheet link or leave blank.
                                </div>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn-modal-cancel" data-bs-dismiss="modal">
                                <i class="bi bi-x-lg me-2"></i>Cancel
                            </button>
                            <button type="submit" class="btn-modal-primary">
                                <i class="bi bi-check-lg me-2"></i>Update Client
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach

    {{-- Assign Client to Team Member Modals --}}
    @foreach($clients as $client)
        @php
            $assignedUserIds = $client->tasks
                ->pluck('assigned_to_id')
                ->filter()
                ->unique()
                ->values()
                ->toArray();
        @endphp
        <div class="modal fade" id="assignClientModal-{{ $client->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <form action="{{ route('tasks.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="client_id" value="{{ $client->id }}">

                        <div class="modal-header">
                            <h5 class="modal-title">
                                <i class="bi bi-person-plus-fill"></i>
                                Assign {{ $client->name }} to Team Member
                            </h5>
                            <button
                                type="button"
                                class="btn-close"
                                data-bs-dismiss="modal"
                                aria-label="Close"
                            ></button>
                        </div>

                        <div class="modal-body">

                            <div class="mb-3">
                                <label for="assigned_to_{{ $client->id }}" class="form-label">
                                    Team Member *
                                </label>
                                <select
                                    id="assigned_to_{{ $client->id }}"
                                    name="assigned_to_id"
                                    class="form-select"
                                    required
                                >
                                    <option value="">-- Select Team Member --</option>
                                    @foreach($teamMembers as $member)
                                        @if($member->user)
                                            @php
                                                $alreadyAssigned = in_array($member->user_id, $assignedUserIds);
                                            @endphp
                                            <option
                                                value="{{ $member->user_id }}"
                                                @if($alreadyAssigned) disabled @endif
                                            >
                                                {{ $member->name }} ({{ $member->email }})
                                                @if($alreadyAssigned)
                                                    - already assigned
                                                @endif
                                            </option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="target_apps_{{ $client->id }}">
                                    Target Applications (optional)
                                </label>
                                <input
                                    type="number"
                                    id="target_apps_{{ $client->id }}"
                                    name="target_applications"
                                    class="form-control"
                                    min="0"
                                    value="0"
                                />
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="app_limit_{{ $client->id }}">
                                    Application Limit (optional)
                                </label>
                                <input
                                    type="number"
                                    id="app_limit_{{ $client->id }}"
                                    name="application_limit"
                                    class="form-control"
                                    min="1"
                                    placeholder="No limit"
                                />
                                <div class="form-text">
                                    Maximum number of applications this team member can submit for this client
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="task_desc_{{ $client->id }}">
                                    Task Description *
                                </label>
                                <textarea
                                    id="task_desc_{{ $client->id }}"
                                    name="description"
                                    class="form-control"
                                    rows="3"
                                    required
                                >Apply to jobs for {{ $client->name }}</textarea>
                            </div>

                        </div>

                        <div class="modal-footer">
                            <button
                                type="button"
                                class="btn-modal-cancel"
                                data-bs-dismiss="modal"
                            >
                                <i class="bi bi-x-lg me-2"></i>Cancel
                            </button>
                            <button type="submit" class="btn-modal-secondary">
                                <i class="bi bi-person-check-fill me-2"></i>Assign Task
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    @endforeach

    @push('scripts')
        @if(old('_form') === 'team_member' && $errors->any())
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    var modalEl = document.getElementById('addTeamMemberModal');
                    if (modalEl && window.bootstrap && bootstrap.Modal) {
                        var modal = new bootstrap.Modal(modalEl);
                        modal.show();
                    }
                });
            </script>
        @endif
        
        {{-- Recent Activity Auto-Update Script --}}
        <script>
            let lastActivityTimestamp = 0;
            let activityUpdateInterval;
            let isFirstLoad = true;
            
            // Load last seen timestamp from localStorage
            function loadLastSeenTimestamp() {
                const stored = localStorage.getItem('lastActivityTimestamp');
                if (stored) {
                    lastActivityTimestamp = parseInt(stored);
                }
            }
            
            // Save last seen timestamp to localStorage
            function saveLastSeenTimestamp(timestamp) {
                localStorage.setItem('lastActivityTimestamp', timestamp.toString());
            }
            
            function fetchRecentActivities() {
                fetch('{{ route('admin.recent-activities') }}')
                    .then(response => response.json())
                    .then(data => {
                        if (data.success && data.activities) {
                            updateActivityDisplay(data.activities);
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching activities:', error);
                    });
            }
            
            function updateActivityDisplay(activities) {
                const loadingEl = document.getElementById('activity-loading');
                const emptyEl = document.getElementById('activity-empty');
                
                // Hide loading after first fetch
                if (loadingEl) loadingEl.style.display = 'none';
                
                if (activities.length === 0) {
                    emptyEl.style.display = 'block';
                    return;
                }
                
                // Hide empty state
                emptyEl.style.display = 'none';
                
                // On first load, just set the timestamp without showing toasts
                if (isFirstLoad) {
                    activities.forEach(activity => {
                        if (activity.created_at_timestamp > lastActivityTimestamp) {
                            lastActivityTimestamp = activity.created_at_timestamp;
                        }
                    });
                    saveLastSeenTimestamp(lastActivityTimestamp);
                    isFirstLoad = false;
                    return;
                }
                
                // Show toast for new activities (only after first load)
                activities.forEach(activity => {
                    const isNew = activity.created_at_timestamp > lastActivityTimestamp;
                    
                    if (isNew) {
                        showToastNotification(activity);
                        // Update and save timestamp
                        lastActivityTimestamp = activity.created_at_timestamp;
                        saveLastSeenTimestamp(lastActivityTimestamp);
                    }
                });
            }
            
            function showToastNotification(activity) {
                const toastContainer = document.getElementById('toast-container');
                if (!toastContainer) return;
                
                const initials = activity.user_name.split(' ').map(n => n[0]).join('').substring(0, 2).toUpperCase();
                const toastId = 'toast-' + activity.id + '-' + Date.now();
                
                const toastHtml = `
                    <div class="toast-notification" id="${toastId}">
                        <div class="toast-header-custom">
                            <div class="toast-avatar">${initials}</div>
                            <div class="toast-user-info">
                                <div class="toast-user-name">${escapeHtml(activity.user_name)}</div>
                                <div class="toast-time">
                                    <i class="bi bi-clock"></i>
                                    ${activity.created_at}
                                </div>
                            </div>
                            <button class="toast-close" onclick="closeToast('${toastId}')">
                                <i class="bi bi-x"></i>
                            </button>
                        </div>
                        <div class="toast-body-custom">
                            <div class="toast-job">
                                <i class="bi bi-briefcase-fill"></i>
                                ${escapeHtml(activity.job_title)}
                            </div>
                            <div class="toast-company">
                                <i class="bi bi-building"></i>
                                ${escapeHtml(activity.company)}
                            </div>
                            <div class="toast-client">
                                <i class="bi bi-person-badge"></i>
                                ${escapeHtml(activity.client_name)}
                            </div>
                        </div>
                    </div>
                `;
                
                toastContainer.insertAdjacentHTML('afterbegin', toastHtml);
                
                // Auto-remove after 8 seconds
                setTimeout(() => {
                    closeToast(toastId);
                }, 8000);
            }
            
            function closeToast(toastId) {
                const toast = document.getElementById(toastId);
                if (toast) {
                    toast.classList.add('removing');
                    setTimeout(() => {
                        toast.remove();
                    }, 300);
                }
            }
            
            function escapeHtml(text) {
                const div = document.createElement('div');
                div.textContent = text;
                return div.innerHTML;
            }
            
            // Initialize on page load
            document.addEventListener('DOMContentLoaded', function() {
                // Load last seen timestamp from localStorage
                loadLastSeenTimestamp();
                
                // Fetch immediately
                fetchRecentActivities();
                
                // Then fetch every 10 seconds
                activityUpdateInterval = setInterval(fetchRecentActivities, 10000);
            });
            
            // Clean up interval when leaving page
            window.addEventListener('beforeunload', function() {
                if (activityUpdateInterval) {
                    clearInterval(activityUpdateInterval);
                }
            });
        </script>
    @endpush

@endsection
