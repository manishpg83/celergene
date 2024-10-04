
@extends('layouts.admin')

@section('content')
<div class="bg-white p-4 rounded-md shadow-md">
    <h2 class="text-lg font-semibold mb-6">Add Vendor</h2>

    <form wire:submit.prevent="submit" class="space-y-4">
        <div class="mb-4">
            <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
            <input type="text" id="name" wire:model="name"
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
            @error('name')
                <span class="text-red-600 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <div class="mb-4">
            <label for="shop_name" class="block text-sm font-medium text-gray-700">Shop Name</label>
            <input type="text" id="shop_name" wire:model="shop_name"
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
            @error('shop_name')
                <span class="text-red-600 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <div class="mb-4">
            <h3 class="text-lg font-medium text-gray-900 mb-2">Roles</h3>
            @foreach ($availableRoles as $role)
                <div class="flex items-center mt-2">
                    <input type="checkbox" wire:model="roles" value="{{ $role->id }}" id="role_{{ $role->id }}"
                        class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                    <label for="role_{{ $role->id }}" class="ml-2 block text-sm text-gray-900">
                        {{ $role->name }}
                    </label>
                </div>
            @endforeach
            @error('roles')
                <span class="text-red-600 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <div class="flex justify-end mt-6">
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Add Vendor
            </button>
        </div>
    </form>

    @if (session()->has('success'))
        <div class="mt-4 text-green-600 text-sm">
            {{ session('success') }}
        </div>
    @endif
    </div>
@endsection
