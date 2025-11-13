@extends('layouts.app')

@section('title', 'My Applications for ' . $client->name)

@section('content')
    <style>
        .applications-page {
            max-width: 1800px;
            margin: 0 auto;
        }
        
        /* Header */
        .page-header {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
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
        .header-btn {
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
        .header-btn:hover {
            background: rgba(255,255,255,0.3);
            transform: translateY(-2px);
            color: white;
        }
        .header-btn.primary {
            background: white;
            color: #4facfe;
            border-color: white;
        }
        .header-btn.primary:hover {
            background: rgba(255,255,255,0.9);
            color: #4facfe;
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
        .stat-card.total { border-left-color: #4facfe; }
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
            border-bottom: 2px solid rgba(79, 172, 254, 0.1);
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
            background: linear-gradient(135deg, #4facfe, #00f2fe);
            color: white;
            box-shadow: 0 4px 12px rgba(79, 172, 254, 0.4);
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
        
        /* Checkbox */
        .checkbox-custom {
            width: 20px;
            height: 20px;
            border-radius: 6px;
            border: 2px solid #e0e7ff;
            cursor: pointer;
            transition: all 0.2s ease;
        }
        .checkbox-custom:checked {
            background-color: #4facfe;
            border-color: #4facfe;
        }
        .checkbox-custom:hover {
            border-color: #4facfe;
        }
        
        /* Bulk Actions Bar */
        .bulk-actions-bar {
            position: fixed;
            bottom: 30px;
            left: 50%;
            transform: translateX(-50%);
            background: white;
            border-radius: 50px;
            padding: 1rem 2rem;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
            display: none;
            align-items: center;
            gap: 1.5rem;
            z-index: 1000;
            animation: slideUp 0.3s ease;
        }
        .bulk-actions-bar.show {
            display: flex;
        }
        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateX(-50%) translateY(100px);
            }
            to {
                opacity: 1;
                transform: translateX(-50%) translateY(0);
            }
        }
        .bulk-actions-text {
            font-weight: 700;
            color: #2d3748;
        }
        .bulk-action-btn {
            padding: 0.6rem 1.5rem;
            border-radius: 50px;
            font-weight: 700;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }
        .bulk-action-btn.delete {
            background: linear-gradient(135deg, #ff9a9e, #fecfef);
            color: #c62828;
            box-shadow: 0 4px 12px rgba(255, 154, 158, 0.4);
        }
        .bulk-action-btn.delete:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(255, 154, 158, 0.6);
        }
        .bulk-action-btn.cancel {
            background: #f0f0f0;
            color: #5a6c7d;
        }
        .bulk-action-btn.cancel:hover {
            background: #e0e0e0;
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
        
        /* Toast */
        .toast-success {
            position: fixed;
            top: 90px;
            right: 20px;
            z-index: 9999;
            background: white;
            border-radius: 15px;
            padding: 1.25rem 1.5rem;
            box-shadow: 0 10px 40px rgba(0,0,0,0.15);
            border-left: 4px solid #43e97b;
            animation: slideInRight 0.4s ease;
            display: flex;
            align-items: center;
            gap: 1rem;
            min-width: 300px;
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
        .toast-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            background: linear-gradient(135deg, #d4fc79, #96e6a1);
            color: #2d7a3e;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.3rem;
        }
        
        /* Custom Confirmation Modal */
        .confirm-modal-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(5px);
            z-index: 9999;
            animation: fadeIn 0.3s ease;
        }
        
        .confirm-modal-overlay.active {
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .confirm-modal {
            background: white;
            border-radius: 25px;
            padding: 0;
            max-width: 450px;
            width: 90%;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            animation: slideUp 0.3s ease;
            overflow: hidden;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        
        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(50px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .confirm-modal-header {
            background: linear-gradient(135deg, #ff6b6b, #ee5a6f);
            padding: 2rem;
            text-align: center;
            color: white;
        }
        
        .confirm-modal-icon {
            width: 80px;
            height: 80px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            font-size: 2.5rem;
        }
        
        .confirm-modal-title {
            font-size: 1.5rem;
            font-weight: 800;
            margin: 0;
        }
        
        .confirm-modal-body {
            padding: 2rem;
            text-align: center;
        }
        
        .confirm-modal-message {
            font-size: 1.1rem;
            color: #5a6c7d;
            margin-bottom: 0.5rem;
        }
        
        .confirm-modal-detail {
            font-size: 0.95rem;
            color: #8b92a7;
        }
        
        .confirm-modal-footer {
            padding: 0 2rem 2rem;
            display: flex;
            gap: 1rem;
        }
        
        .confirm-btn {
            flex: 1;
            padding: 0.875rem 1.5rem;
            border-radius: 50px;
            font-weight: 700;
            font-size: 0.95rem;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }
        
        .confirm-btn-cancel {
            background: #f0f0f0;
            color: #5a6c7d;
        }
        
        .confirm-btn-cancel:hover {
            background: #e0e0e0;
            transform: translateY(-2px);
        }
        
        .confirm-btn-delete {
            background: linear-gradient(135deg, #ff6b6b, #ee5a6f);
            color: white;
            box-shadow: 0 4px 15px rgba(255, 107, 107, 0.3);
        }
        
        .confirm-btn-delete:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(255, 107, 107, 0.4);
        }
    </style>

    <div class="applications-page">
        {{-- Success Toast --}}
        @if(session('success'))
            <div class="toast-success" id="success-toast">
                <div class="toast-icon">✓</div>
                <div class="flex-grow-1">
                    <strong>Success!</strong>
                    <div class="small text-muted">{{ session('success') }}</div>
                </div>
                <button type="button" class="btn-close" onclick="document.getElementById('success-toast').remove()"></button>
            </div>
            <script>
                setTimeout(() => {
                    const toast = document.getElementById('success-toast');
                    if (toast) toast.remove();
                }, 5000);
            </script>
        @endif

        {{-- Header --}}
        <div class="page-header">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div>
                    <h1><i class="bi bi-briefcase-fill me-2"></i>{{ $client->name }}</h1>
                    <p>View and manage your applications for this client</p>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('team.dashboard') }}" class="header-btn">
                        <i class="bi bi-arrow-left"></i>
                        Back
                    </a>
                    <a href="{{ route('team.clients.applications.create', $client->id) }}" class="header-btn primary">
                        <i class="bi bi-plus-lg"></i>
                        Add Application
                    </a>
                </div>
            </div>
        </div>

        {{-- Pause Warning --}}
        @php
            $isPaused = $client->application_status === 'paused' || $task->is_paused;
        @endphp
        
        @if($isPaused)
            <div class="alert alert-warning d-flex align-items-center" style="border-radius: 15px; border-left: 4px solid #ffc107;">
                <i class="bi bi-pause-circle-fill me-3" style="font-size: 1.5rem;"></i>
                <div>
                    <strong>Applications Paused</strong><br>
                    <small>
                        @if($client->application_status === 'paused')
                            This client is paused. You cannot delete applications until it's resumed.
                        @else
                            Your task is paused. You cannot delete applications until it's resumed.
                        @endif
                    </small>
                </div>
            </div>
        @endif

        {{-- Stats Cards --}}
        @php
            $totalApplications = $applications->count();
            $totalEarnings = $applications->sum('earning');
            $tailoredCount = $applications->where('tailored_resume', true)->count();
        @endphp
        <div class="stats-grid">
            <div class="stat-card total">
                <div class="stat-label">My Applications</div>
                <div class="stat-value">{{ $totalApplications }}</div>
            </div>
            <div class="stat-card earning">
                <div class="stat-label">My Earnings</div>
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
                <h3><i class="bi bi-list-ul me-2" style="color: #4facfe;"></i>My Applications</h3>
            </div>
            <div class="content-card-body p-4">
                @if($applications->isEmpty())
                    <div class="empty-state">
                        <div class="empty-state-icon">📋</div>
                        <div class="empty-state-text">No applications yet</div>
                        <p class="text-muted mt-2">Click "Add Application" to submit your first application</p>
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="modern-table">
                            <thead>
                                <tr>
                                    <th style="width: 50px;">
                                        <input type="checkbox" 
                                               class="checkbox-custom" 
                                               id="select-all"
                                               onchange="toggleSelectAll(this)">
                                    </th>
                                    <th>Date</th>
                                    <th>Job Title</th>
                                    <th>Company</th>
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
                                            <input type="checkbox" 
                                                   class="checkbox-custom application-checkbox" 
                                                   value="{{ $app->id }}"
                                                   onchange="updateBulkActions()"
                                                   {{ $isPaused ? 'disabled' : '' }}>
                                        </td>
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
                                            <div style="color: #4facfe; font-weight: 600;">
                                                {{ $app->company_applied_to }}
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
                                                      class="d-inline delete-form">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button"
                                                            class="action-btn-icon delete"
                                                            title="{{ $isPaused ? 'Cannot delete while paused' : 'Delete Application' }}"
                                                            onclick="showConfirmModal('Are you sure you want to delete this application?', this.closest('form'))"
                                                            {{ $isPaused ? 'disabled style=opacity:0.5;cursor:not-allowed;' : '' }}>
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

    {{-- Bulk Actions Bar --}}
    <div class="bulk-actions-bar" id="bulk-actions-bar">
        <span class="bulk-actions-text">
            <span id="selected-count">0</span> selected
        </span>
        <button type="button" class="bulk-action-btn delete" onclick="bulkDelete()" {{ $isPaused ? 'disabled style=opacity:0.5;cursor:not-allowed;' : '' }}>
            <i class="bi bi-trash-fill"></i>
            Delete Selected
        </button>
        <button type="button" class="bulk-action-btn cancel" onclick="clearSelection()">
            Cancel
        </button>
    </div>

    {{-- Bulk Delete Form --}}
    <form id="bulk-delete-form" 
          action="{{ route('team.clients.applications.bulk-destroy', $client->id) }}" 
          method="POST" 
          style="display: none;">
        @csrf
        {{-- IDs will be added dynamically by JavaScript --}}
    </form>

    <script>
        function toggleSelectAll(checkbox) {
            const checkboxes = document.querySelectorAll('.application-checkbox');
            checkboxes.forEach(cb => {
                cb.checked = checkbox.checked;
            });
            updateBulkActions();
        }

        function updateBulkActions() {
            const checkboxes = document.querySelectorAll('.application-checkbox:checked');
            const count = checkboxes.length;
            const bulkBar = document.getElementById('bulk-actions-bar');
            const countSpan = document.getElementById('selected-count');
            const selectAll = document.getElementById('select-all');

            countSpan.textContent = count;

            if (count > 0) {
                bulkBar.classList.add('show');
            } else {
                bulkBar.classList.remove('show');
            }

            // Update select all checkbox
            const allCheckboxes = document.querySelectorAll('.application-checkbox');
            selectAll.checked = count === allCheckboxes.length && count > 0;
        }

        function clearSelection() {
            const checkboxes = document.querySelectorAll('.application-checkbox');
            checkboxes.forEach(cb => {
                cb.checked = false;
            });
            document.getElementById('select-all').checked = false;
            updateBulkActions();
        }

        function bulkDelete() {
            const checkboxes = document.querySelectorAll('.application-checkbox:checked');
            const ids = Array.from(checkboxes).map(cb => cb.value);

            if (ids.length === 0) {
                alert('Please select at least one application to delete.');
                return;
            }

            const confirmMessage = `Are you sure you want to delete ${ids.length} application(s)? This action cannot be undone.`;
            
            // Use custom modal instead of confirm
            showConfirmModal(confirmMessage, null, function() {
                // Create hidden inputs for each ID
                const form = document.getElementById('bulk-delete-form');
                // Clear any existing inputs
                form.querySelectorAll('input[name="application_ids[]"]').forEach(input => input.remove());
                
                // Add new inputs for each ID
                ids.forEach(id => {
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'application_ids[]';
                    input.value = id;
                    form.appendChild(input);
                });
                
                form.submit();
            });
        }
    </script>

    {{-- Custom Confirmation Modal --}}
    <div class="confirm-modal-overlay" id="confirmModal">
        <div class="confirm-modal">
            <div class="confirm-modal-header">
                <div class="confirm-modal-icon">
                    <i class="bi bi-exclamation-triangle"></i>
                </div>
                <h3 class="confirm-modal-title">Confirm Delete</h3>
            </div>
            <div class="confirm-modal-body">
                <p class="confirm-modal-message" id="confirmMessage">Are you sure you want to delete this?</p>
                <p class="confirm-modal-detail">This action cannot be undone.</p>
            </div>
            <div class="confirm-modal-footer">
                <button type="button" class="confirm-btn confirm-btn-cancel" onclick="closeConfirmModal()">
                    <i class="bi bi-x-circle"></i>
                    Cancel
                </button>
                <button type="button" class="confirm-btn confirm-btn-delete" id="confirmDeleteBtn">
                    <i class="bi bi-trash"></i>
                    Delete
                </button>
            </div>
        </div>
    </div>

    <script>
        let deleteForm = null;
        let deleteCallback = null;

        function showConfirmModal(message, form, callback) {
            deleteForm = form;
            deleteCallback = callback;
            document.getElementById('confirmMessage').textContent = message;
            document.getElementById('confirmModal').classList.add('active');
        }

        function closeConfirmModal() {
            document.getElementById('confirmModal').classList.remove('active');
            deleteForm = null;
            deleteCallback = null;
        }

        document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
            if (deleteForm) {
                deleteForm.submit();
            } else if (deleteCallback) {
                deleteCallback();
            }
            closeConfirmModal();
        });

        // Close modal when clicking outside
        document.getElementById('confirmModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeConfirmModal();
            }
        });

        // Close modal with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeConfirmModal();
            }
        });
    </script>
@endsection
