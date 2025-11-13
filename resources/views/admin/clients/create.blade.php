@extends('layouts.app')

@section('title', 'Add Client')

@section('content')
    <h2 class="mb-4">Add Client</h2>

    <form action="{{ route('clients.store') }}" method="POST" class="card p-4 shadow-3-strong">
        @csrf

        <div class="form-outline mb-4">
            <input type="text" id="name" name="name"
                   class="form-control @error('name') is-invalid @enderror"
                   value="{{ old('name') }}" />
            <label class="form-label" for="name">Name *</label>
            @error('name')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-outline mb-4">
            <input type="email" id="email" name="email"
                   class="form-control @error('email') is-invalid @enderror"
                   value="{{ old('email') }}" />
            <label class="form-label" for="email">Email</label>
            @error('email')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-outline mb-4">
            <input type="text" id="phone" name="phone"
                   class="form-control @error('phone') is-invalid @enderror"
                   value="{{ old('phone') }}" />
            <label class="form-label" for="phone">Phone</label>
            @error('phone')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-outline mb-4">
            <input type="url" id="linkedin_url" name="linkedin_url"
                   class="form-control @error('linkedin_url') is-invalid @enderror"
                   value="{{ old('linkedin_url') }}" />
            <label class="form-label" for="linkedin_url">LinkedIn URL</label>
            @error('linkedin_url')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-outline mb-4">
            <textarea id="notes" name="notes"
                      class="form-control @error('notes') is-invalid @enderror"
                      rows="3">{{ old('notes') }}</textarea>
            <label class="form-label" for="notes">Notes</label>
            @error('notes')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>

        <div class="d-flex justify-content-end gap-2">
            <a href="{{ route('clients.index') }}" class="btn btn-light btn-rounded">
                Cancel
            </a>
            <button type="submit" class="btn btn-primary btn-rounded">
                Save Client
            </button>
        </div>
    </form>
@endsection
