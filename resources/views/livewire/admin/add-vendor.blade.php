<div class="bg-white p-6 rounded-md shadow-md">
    <h2 class="text-lg font-semibold mb-6">Add Vendor</h2>

    <form wire:submit.prevent="submit" class="grid grid-cols-2 gap-4">

        <!-- Full Name Input -->
        <div class="mb-4">
            <label for="name" class="block text-sm font-medium text-gray-700">Full Name</label>
            <input type="text" id="name" wire:model="name"
                class="mt-1 h-9 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                required>
            @error('name')
                <span class="text-red-600 text-sm">{{ $message }}</span>
            @enderror
        </div>

        {{--  <!-- Company Input -->
        <div class="mb-4">
            <label for="company" class="block text-sm font-medium text-gray-700">Company</label>
            <input type="text" id="company" wire:model="company"
                class="mt-1 h-9 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                required>
        </div> --}}

        <!-- Email Input -->
        <div class="mb-4">
            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
            <input type="email" id="email" wire:model="email"
                class="mt-1 h-9 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                required>
            @error('email')
                <span class="text-red-600 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <!-- Password Input -->
        <div class="mb-4">
            <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
            <input type="password" id="password" wire:model="password"
                class="mt-1 h-9 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                required>
            @error('password')
                <span class="text-red-600 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <!-- Password Confirmation Input -->
        <div class="mb-4">
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm Password</label>
            <input type="password" id="password_confirmation" wire:model="password_confirmation"
                class="mt-1 h-9 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                required>
        </div>
        <!-- Roles Selection -->
        <div class="mb-4 col-span-2">
            <label class="block text-sm font-medium text-gray-700">Roles</label>
            <div class="mt-2">
                @foreach ($availableRoles as $role)
                    <div class="flex items-center mb-2">
                        <input type="checkbox" id="role_{{ $role->id }}" wire:model="roles"
                            value="{{ $role->id }}"
                            class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                        <label for="role_{{ $role->id }}" class="ml-2 block text-sm text-gray-800">
                            {{ $role->name }}
                        </label>
                    </div>
                @endforeach
            </div>
            @error('roles.*')
                <span class="text-red-600 text-sm">{{ $message }}</span>
            @enderror
        </div>


        <!-- Submit Button -->
        <div class="flex justify-end col-span-2 mt-6">
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
