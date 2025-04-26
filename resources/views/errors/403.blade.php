<!-- resources/views/admin/roles/index.blade.php -->
@extends('layouts.admin')

@section('content')
<div class="container-fluid d-flex align-items-center justify-content-center vh-100">
    <div class="text-center">
        <h1 class="display-1 fw-bold text-danger">403</h1>
        <p class="fs-3 text-muted">
            <span class="text-danger">Oops!</span> Forbidden
        </p>
        <p class="lead mb-4">
           Page not found..!
        </p>

        <a href="{{ route('home') }}" class="btn btn-primary">Go Home</a>
    </div>
</div>
@endsection
