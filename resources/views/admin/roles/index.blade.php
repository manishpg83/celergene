@extends('layouts.admin')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        @livewire('admin.role-manager')
        @livewire('admin.user-manager')
    </div>
@endsection
