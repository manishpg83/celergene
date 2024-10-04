<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Vendor Permissions
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <form action="{{ route('admin.vendors.update', $vendor) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <h3 class="text-lg font-medium text-gray-900">Roles</h3>
                        @foreach($roles as $role)
                        <div class="flex items-center mt-2">
                            <input type="checkbox"
                                   name="roles[]"
                                   value="{{ $role->id }}"
                                   id="role_{{ $role->id }}"
                                   @if($vendor->hasRole($role)) checked @endif
                                   class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                            <label for="role_{{ $role->id }}" class="ml-2 block text-sm text-gray-900">
                                {{ $role->name }}
                            </label>
                        </div>
                        @endforeach
                    </div>

                    <div class="flex justify-end mt-4">
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Update Permissions
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
