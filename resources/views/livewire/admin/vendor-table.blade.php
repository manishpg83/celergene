<div class="bg-white p-4 rounded-md shadow-md">
    <h2 class="text-lg font-semibold mb-6">Vendors</h2>

    <!-- Search and Status Filter -->
    <div class="flex items-center mb-4 space-x-4">
        <!-- Search Input (will reset on refresh) -->
        <input
            wire:model.live="searchVendor"
            type="text"
            placeholder="Search Vendor..."
            class="border rounded p-2 w-full"
        >

        <!-- Status Filter (will reset on refresh) -->
        <select wire:model.live="status" class="border rounded p-2">
            <option value="all">All Statuses</option>
            <option value="active">Active</option>
            <option value="inactive">Inactive</option>
        </select>
    </div>

    <!-- Table -->
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @if($vendors->isEmpty())
                <tr>
                    <td colspan="4" class="px-6 py-4 text-center text-gray-500">
                        No vendors found.
                    </td>
                </tr>
            @else
                @foreach ($vendors as $vendor)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $vendor->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $vendor->email }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            <!-- Toggle Button for Status -->
                            <button
                                wire:click="toggleStatus({{ $vendor->id }})"
                                class="relative inline-flex items-center h-6 rounded-full w-11 focus:outline-none {{ $vendor->status === 'active' ? 'bg-green-500' : 'bg-gray-200' }}"
                            >
                                <span class="{{ $vendor->status === 'active' ? 'translate-x-6' : 'translate-x-1' }} inline-block w-4 h-4 transform bg-white rounded-full transition ease-in-out duration-200"></span>
                            </button>
                            <span class="ml-2">{{ $vendor->status === 'active' ? 'Active' : 'Inactive' }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <a href="#" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                            <a href="#" class="text-red-600 hover:text-red-900 ml-4">Delete</a>
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $vendors->links() }}
    </div>
</div>
