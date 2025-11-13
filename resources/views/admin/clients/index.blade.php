@extends('layouts.app')

@section('title', 'Clients')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">Clients</h2>
        <a href="{{ route('clients.create') }}" class="btn btn-primary btn-rounded">
            + Add Client
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success mb-3">
            {{ session('success') }}
        </div>
    @endif

    @if($clients->isEmpty())
        <div class="text-center text-muted">
            No clients yet. Click "Add Client" to create one.
        </div>
    @else
        <div class="card shadow-3-strong">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>LinkedIn</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($clients as $client)
                                <tr>
                                    <td>{{ $client->id }}</td>
                                    <td>{{ $client->name }}</td>
                                    <td>{{ $client->email }}</td>
                                    <td>{{ $client->phone }}</td>
                                    <td>
                                        @if($client->linkedin_url)
                                            <a href="{{ $client->linkedin_url }}" target="_blank">
                                                View Profile
                                            </a>
                                        @else
                                            <span class="text-muted">N/A</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('clients.edit', $client) }}"
                                               class="btn btn-sm btn-outline-primary btn-rounded">
                                                Edit
                                            </a>

                                            <form action="{{ route('clients.destroy', $client) }}"
                                                  method="POST"
                                                  onsubmit="return confirm('Delete this client?')">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-sm btn-outline-danger btn-rounded">
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif
@endsection
