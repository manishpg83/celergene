@extends('layouts.admin')

@section('content')
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Add Vendor
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Vendor Information</h3>

                @livewire('admin.add-vendor') <!-- Include the Livewire component here -->

                <div class="mt-6">
                    <a href="{{ route('admin.vendors.index') }}" class="text-blue-600 hover:text-blue-900">
                        &larr; Back to Vendors
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
