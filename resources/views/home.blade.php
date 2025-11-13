@extends('layouts.app')

@section('title', 'Home')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-3-strong">
                <div class="card-body">
                    <h3 class="card-title mb-3">Welcome 🎉</h3>
                    <p class="card-text">
                        This is your first Laravel project with
                        <strong>Material Design Bootstrap</strong>.
                    </p>
                    <p class="card-text">
                        Next, we’ll turn this into a real project (like a task manager).
                    </p>
                    <a href="#" class="btn btn-primary btn-rounded">
                        Just a sample button
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
