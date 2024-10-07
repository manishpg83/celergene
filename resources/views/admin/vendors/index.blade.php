@extends('layouts.admin')

@section('content')
    <div>
        @livewire('admin.add-vendor')
    </div>
    <div class="mt-4">
        @livewire('admin.vendor-table')
    </div>
@endsection
