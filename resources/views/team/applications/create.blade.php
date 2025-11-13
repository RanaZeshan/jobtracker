@extends('layouts.app')

@section('title', 'Add Application')

@section('content')
    <style>
        .app-create-page {
            max-width: 1400px;
            margin: 0 auto;
        }
        .app-form-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 20px;
            padding: 2px;
            margin-bottom: 2rem;
        }
        .app-form-inner {
            background: white;
            border-radius: 18px;
            padding: 2.5rem;
        }
        .app-form-header {
            text-align: center;
            margin-bottom: 2rem;
        }
        .app-form-header h2 {
            font-size: 2rem;
            font-weight: 700;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 0.5rem;
        }
        .app-form-header .client-badge {
            display: inline-block;
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            color: white;
            padding: 0.5rem 1.5rem;
            border-radius: 50px;
            font-weight: 600;
            font-size: 0.95rem;
        }
        .form-section {
            background: #f8f9ff;
            border-radius: 15px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
        }
        .form-section-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: #667eea;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        .form-section-title i {
            font-size: 1.3rem;
        }
        .custom-input {
            border: 2px solid #e0e7ff;
            border-radius: 10px;
            padding: 0.75rem 1rem;
            transition: all 0.3s ease;
        }
        .custom-input:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.15);
        }
        .custom-checkbox {
            width: 1.3rem;
            height: 1.3rem;
            border-radius: 6px;
            border: 2px solid #667eea;
        }
        .custom-checkbox:checked {
            background-color: #667eea;
            border-color: #667eea;
        }
        .btn-gradient {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            color: white;
            padding: 0.75rem 2rem;
            border-radius: 50px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .btn-gradient:hover:not(:disabled) {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
            color: white;
        }
        .btn-gradient:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }
        .btn-back {
            background: white;
            border: 2px solid #e0e7ff;
            color: #667eea;
            padding: 0.75rem 2rem;
            border-radius: 50px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .btn-back:hover {
            background: #f8f9ff;
            border-color: #667eea;
            color: #667eea;
        }
        .alert-modern {
            border-radius: 15px;
            border: none;
            padding: 1.25rem 1.5rem;
            margin-bottom: 1.5rem;
        }
        .alert-modern i {
            font-size: 1.3rem;
            margin-right: 0.5rem;
        }
        .applications-list-card {
            border-radius: 20px;
            border: none;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
        }
        .applications-list-header {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            color: white;
            padding: 1.5rem;
            border-radius: 20px 20px 0 0;
        }
        .applications-list-header h4 {
            margin: 0;
            font-weight: 700;
        }
        .table-modern thead {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        .table-modern thead th {
            border: none;
            padding: 1rem;
            font-weight: 600;
        }
        .table-modern tbody tr {
            transition: all 0.2s ease;
        }
        .table-modern tbody tr:hover {
            background: #f8f9ff;
            transform: scale(1.01);
        }
    </style>

    <div class="app-create-page">
        @if(session('success'))
            <div class="alert alert-success alert-modern">
                <i class="bi bi-check-circle-fill"></i>
                <strong>Success!</strong> {{ session('success') }}
                <button type="button" class="btn-close float-end" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @php
            $task = \App\Models\Task::where('assigned_to_id', auth()->id())
                ->where('client_id', $client->id)
                ->where('is_active', true)
                ->first();
            $currentCount = \App\Models\Application::where('client_id', $client->id)
                ->where('team_id', auth()->id())
                ->count();
            $hasLimit = $task && $task->application_limit;
            $limitReached = $hasLimit && $currentCount >= $task->application_limit;
            $limitClose = $hasLimit && !$limitReached && ($currentCount >= $task->application_limit - 2);
            $isClientPaused = $client->application_status === 'paused';
            $isTaskPaused = $task && $task->is_paused;
            $isPaused = $isClientPaused || $isTaskPaused;
        @endphp

        @if($isTaskPaused)
            <div class="alert alert-danger alert-modern">
                <i class="bi bi-pause-circle-fill"></i>
                <strong>You've Been Paused!</strong> The admin has paused you from adding applications for this client. Please contact the admin for more information.
            </div>
        @elseif($isClientPaused)
            <div class="alert alert-danger alert-modern">
                <i class="bi bi-pause-circle-fill"></i>
                <strong>Client Applications Paused!</strong> The admin has paused all applications for this client. You cannot add new applications at this time.
            </div>
        @elseif($limitReached)
            <div class="alert alert-danger alert-modern">
                <i class="bi bi-exclamation-triangle-fill"></i>
                <strong>Application Limit Reached!</strong> You have reached the maximum limit of {{ $task->application_limit }} applications for this client.
            </div>
        @elseif($limitClose)
            <div class="alert alert-warning alert-modern">
                <i class="bi bi-exclamation-circle-fill"></i>
                <strong>Approaching Limit:</strong> You have submitted {{ $currentCount }} out of {{ $task->application_limit }} allowed applications for this client.
            </div>
        @endif

        <div class="app-form-card">
            <div class="app-form-inner">
                <div class="app-form-header">
                    <h2>✨ Add New Application</h2>
                    <span class="client-badge">
                        <i class="bi bi-person-circle me-1"></i> {{ $client->name }}
                    </span>
                </div>

                <form action="{{ route('team.applications.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="client_id" value="{{ $client->id }}">

                    {{-- Job Details Section --}}
                    <div class="form-section">
                        <div class="form-section-title">
                            <i class="bi bi-briefcase-fill"></i>
                            Job Details
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold" for="app_job_title">Job Title *</label>
                                <input
                                    type="text"
                                    id="app_job_title"
                                    name="job_title"
                                    class="form-control custom-input @error('job_title') is-invalid @enderror"
                                    value="{{ old('job_title') }}"
                                    placeholder="e.g. Senior Software Engineer"
                                    required
                                />
                                @error('job_title')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold" for="app_company">Company *</label>
                                <input
                                    type="text"
                                    id="app_company"
                                    name="company_applied_to"
                                    class="form-control custom-input @error('company_applied_to') is-invalid @enderror"
                                    value="{{ old('company_applied_to') }}"
                                    placeholder="e.g. Google"
                                    required
                                />
                                @error('company_applied_to')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold" for="app_location">Location</label>
                                <input
                                    type="text"
                                    id="app_location"
                                    name="location"
                                    class="form-control custom-input @error('location') is-invalid @enderror"
                                    value="{{ old('location') }}"
                                    placeholder="e.g. San Francisco, CA"
                                />
                                @error('location')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="app_status" class="form-label fw-semibold">Status</label>
                                <select
                                    id="app_status"
                                    name="status"
                                    class="form-select custom-input @error('status') is-invalid @enderror"
                                >
                                    @php
                                        $statusOptions = ['submitted', 'interview', 'offer', 'rejected'];
                                        $oldStatus = old('status', 'submitted');
                                    @endphp
                                    @foreach($statusOptions as $status)
                                        <option value="{{ $status }}" @selected($oldStatus === $status)>
                                            {{ ucfirst($status) }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('status')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- Application Source Section --}}
                    <div class="form-section">
                        <div class="form-section-title">
                            <i class="bi bi-link-45deg"></i>
                            Application Source
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold" for="app_job_link">Job Link</label>
                                <input
                                    type="url"
                                    id="app_job_link"
                                    name="job_link"
                                    class="form-control custom-input @error('job_link') is-invalid @enderror"
                                    value="{{ old('job_link') }}"
                                    placeholder="https://..."
                                />
                                @error('job_link')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold" for="app_source_site">Source Site</label>
                                <input
                                    type="text"
                                    id="app_source_site"
                                    name="source_site"
                                    class="form-control custom-input @error('source_site') is-invalid @enderror"
                                    value="{{ old('source_site') }}"
                                    placeholder="e.g. LinkedIn, Indeed"
                                />
                                @error('source_site')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- Resume Section --}}
                    <div class="form-section">
                        <div class="form-section-title">
                            <i class="bi bi-file-earmark-text-fill"></i>
                            Resume Information
                        </div>
                        <div class="form-check mb-3">
                            <input
                                class="form-check-input custom-checkbox"
                                type="checkbox"
                                value="1"
                                id="app_tailored_resume"
                                name="tailored_resume"
                                {{ old('tailored_resume') ? 'checked' : '' }}
                            />
                            <label class="form-check-label fw-semibold" for="app_tailored_resume">
                                <i class="bi bi-star-fill text-warning me-1"></i>
                                I used a tailored resume for this application
                            </label>
                        </div>
                        <div id="resume_upload_group" style="display: none;">
                            <label for="app_resume_file" class="form-label fw-semibold">Upload Tailored Resume</label>
                            <input
                                type="file"
                                id="app_resume_file"
                                name="resume_file"
                                class="form-control custom-input @error('resume_file') is-invalid @enderror"
                                accept=".pdf,.doc,.docx"
                            >
                            @error('resume_file')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                            <div class="form-text">
                                <i class="bi bi-info-circle me-1"></i>
                                Accepted formats: PDF, DOC, DOCX (Max 4MB)
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mt-4">
                        <a href="{{ route('team.dashboard') }}" class="btn btn-back">
                            <i class="bi bi-arrow-left me-2"></i>Back to Dashboard
                        </a>
                        <button type="submit" class="btn btn-gradient" {{ ($isPaused || $limitReached) ? 'disabled' : '' }}>
                            <i class="bi bi-check-circle me-2"></i>Save Application
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Existing applications for this client (by this team member) --}}
        <div class="card applications-list-card">
            <div class="applications-list-header">
                <h4>
                    <i class="bi bi-list-check me-2"></i>
                    My Applications for {{ $client->name }}
                </h4>
            </div>
            <div class="card-body p-0">
                @if($errors->has('applications'))
                    <div class="alert alert-danger m-3">
                        {{ $errors->first('applications') }}
                    </div>
                @endif

                @if($applications->isEmpty())
                    <div class="text-center py-5">
                        <i class="bi bi-inbox" style="font-size: 3rem; color: #ddd;"></i>
                        <p class="text-muted mt-3 mb-0">
                            You haven't added any applications for this client yet.
                        </p>
                    </div>
                @else
                    @php
                        $isPaused = $client->application_status === 'paused' || $task->is_paused;
                    @endphp
                    
                    @if($isPaused)
                        <div class="alert alert-warning m-3 d-flex align-items-center" style="border-radius: 15px; border-left: 4px solid #ffc107;">
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
                    
                    <form
                        id="bulk-delete-form-create"
                        action="{{ route('team.clients.applications.bulk-destroy', $client->id) }}"
                        method="POST"
                    >
                        @csrf

                        <div class="d-flex justify-content-between align-items-center p-3 bg-light border-bottom">
                            <button type="button" class="btn btn-sm btn-danger rounded-pill" onclick="confirmBulkDelete()" {{ $isPaused ? 'disabled' : '' }}>
                                <i class="bi bi-trash me-1"></i> Delete Selected
                            </button>
                            <div class="form-check">
                                <input
                                    class="form-check-input"
                                    type="checkbox"
                                    id="select-all-apps"
                                >
                                <label class="form-check-label fw-semibold" for="select-all-apps">
                                    Select All
                                </label>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-modern align-middle mb-0">
                                <thead>
                                    <tr>
                                        <th style="width: 50px;"></th>
                                        <th>Date</th>
                                        <th>Job Title</th>
                                        <th>Company</th>
                                        <th>Status</th>
                                        <th>Tailored</th>
                                        <th>Resume</th>
                                        <th>Earning</th>
                                        <th>Job Link</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($applications as $app)
                                        @php
                                            $date = $app->applied_on ?? $app->created_at;
                                        @endphp
                                        <tr>
                                            <td>
                                                <input
                                                    type="checkbox"
                                                    class="form-check-input app-checkbox"
                                                    name="application_ids[]"
                                                    value="{{ $app->id }}"
                                                    {{ $isPaused ? 'disabled' : '' }}
                                                >
                                            </td>
                                            <td class="small">{{ $date ? $date->format('M d, Y') : '-' }}</td>
                                            <td class="fw-semibold">{{ $app->job_title }}</td>
                                            <td>{{ $app->company_applied_to }}</td>
                                            <td>
                                                <span class="badge rounded-pill 
                                                    @if($app->status === 'offer') bg-success
                                                    @elseif($app->status === 'interview') bg-info
                                                    @elseif($app->status === 'rejected') bg-danger
                                                    @else bg-secondary
                                                    @endif">
                                                    {{ ucfirst($app->status) }}
                                                </span>
                                            </td>
                                            <td>
                                                @if($app->tailored_resume)
                                                    <i class="bi bi-star-fill text-warning"></i>
                                                @else
                                                    <span class="text-muted">—</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($app->resume_file)
                                                    <a
                                                        href="{{ asset('storage/' . $app->resume_file) }}"
                                                        target="_blank"
                                                        class="btn btn-sm btn-outline-success rounded-pill"
                                                        title="Download resume"
                                                    >
                                                        <i class="bi bi-file-earmark-pdf"></i>
                                                    </a>
                                                @else
                                                    <span class="text-muted small">—</span>
                                                @endif
                                            </td>
                                            <td class="fw-bold text-success">Rs. {{ number_format($app->earning, 2) }}</td>
                                            <td>
                                                @if($app->job_link)
                                                    <a
                                                        href="{{ $app->job_link }}"
                                                        target="_blank"
                                                        class="btn btn-sm btn-outline-primary rounded-pill"
                                                    >
                                                        <i class="bi bi-box-arrow-up-right"></i>
                                                    </a>
                                                @else
                                                    <span class="text-muted small">—</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </form>
                @endif
            </div>
        </div>
    </div>

    
@endsection

@push('scripts')

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Toggle resume upload
        var checkbox = document.getElementById('app_tailored_resume');
        var group    = document.getElementById('resume_upload_group');

        if (checkbox && group) {
            function toggleResumeUpload() {
                group.style.display = checkbox.checked ? 'block' : 'none';
            }

            checkbox.addEventListener('change', toggleResumeUpload);
            toggleResumeUpload();
        }

        // Select all applications
        var selectAll = document.getElementById('select-all-apps');
        var checkboxes = document.querySelectorAll('.app-checkbox');

        if (selectAll) {
            selectAll.addEventListener('change', function () {
                checkboxes.forEach(function (cb) {
                    cb.checked = selectAll.checked;
                });
            });
        }
    });
</script>



<script>
    document.addEventListener('DOMContentLoaded', function () {
        var checkbox = document.getElementById('app_tailored_resume');
        var group    = document.getElementById('resume_upload_group');

        if (!checkbox || !group) return;

        function toggleResumeUpload() {
            group.style.display = checkbox.checked ? 'block' : 'none';
        }

        checkbox.addEventListener('change', toggleResumeUpload);
        toggleResumeUpload(); // initial state
    });

    // Bulk delete confirmation
    function confirmBulkDelete() {
        const checkboxes = document.querySelectorAll('input[name="application_ids[]"]:checked');
        if (checkboxes.length === 0) {
            alert('Please select at least one application to delete.');
            return;
        }
        
        const message = `Are you sure you want to delete ${checkboxes.length} application(s)?`;
        if (confirm(message)) {
            document.getElementById('bulk-delete-form-create').submit();
        }
    }
</script>
@endpush
