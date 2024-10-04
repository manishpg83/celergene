<div class="p-6">
    @if (session()->has('message'))
        <div class="mb-4 px-4 py-2 bg-green-100 border border-green-400 text-green-700 rounded">
            {{ session('message') }}
        </div>
    @endif

    <button wire:click="create" class="mb-4 px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Create New Entity</button>

    <table class="w-full border-collapse">
        <thead>
            <tr class="bg-gray-100">
                <th class="p-2 border">Company Name</th>
                <th class="p-2 border">Country</th>
                <th class="p-2 border">Status</th>
                <th class="p-2 border">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($entities as $entity)
                <tr class="border-b">
                    <td class="p-2 border">{{ $entity->company_name }}</td>
                    <td class="p-2 border">{{ $entity->country }}</td>
                    <td class="p-2 border">
                        <button wire:click="toggleActive({{ $entity->id }})"
                                class="px-2 py-1 text-xs rounded {{ $entity->is_active ? 'bg-green-500 text-white' : 'bg-gray-300 text-gray-700' }}">
                            {{ $entity->is_active ? 'Active' : 'Inactive' }}
                        </button>
                    </td>
                    <td class="p-2 border">
                        <button wire:click="edit({{ $entity->id }})" class="px-2 py-1 text-xs bg-blue-500 text-white rounded hover:bg-blue-600">Edit</button>
                        <button wire:click="confirmDelete({{ $entity->id }})" class="px-2 py-1 text-xs bg-red-500 text-white rounded hover:bg-red-600">Delete</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Modal for Add/Edit Entity -->
    @if ($isEditing)
    <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full" id="my-modal" role="dialog" aria-labelledby="modal-title">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3 text-center">
                <h3 id="modal-title" class="text-lg leading-6 font-medium text-gray-900">{{ $entity->id ? 'Edit' : 'Add' }} Entity</h3>
                <div class="mt-2 px-7 py-3">
                    <form wire:submit.prevent="save">
                        <!-- Company Name -->
                        <div class="mb-4">
                            <label for="company_name" class="block text-gray-700 text-sm font-bold mb-2">Company Name</label>
                            <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="company_name" wire:model="entity.company_name" required>
                            @error('entity.company_name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <!-- Country -->
                        <div class="mb-4">
                            <label for="country" class="block text-gray-700 text-sm font-bold mb-2">Country</label>
                            <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="country" wire:model="entity.country" required>
                            @error('entity.country') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <!-- Address -->
                        <div class="mb-4">
                            <label for="address" class="block text-gray-700 text-sm font-bold mb-2">Address</label>
                            <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="address" wire:model="entity.address" required>
                            @error('entity.address') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <!-- Postal Code -->
                        <div class="mb-4">
                            <label for="postal_code" class="block text-gray-700 text-sm font-bold mb-2">Postal Code</label>
                            <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="postal_code" wire:model="entity.postal_code" required>
                            @error('entity.postal_code') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <!-- Business Registration Number -->
                        <div class="mb-4">
                            <label for="business_reg_number" class="block text-gray-700 text-sm font-bold mb-2">Business Registration Number</label>
                            <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="business_reg_number" wire:model="entity.business_reg_number">
                            @error('entity.business_reg_number') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <!-- VAT Number -->
                        <div class="mb-4">
                            <label for="vat_number" class="block text-gray-700 text-sm font-bold mb-2">VAT Number</label>
                            <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="vat_number" wire:model="entity.vat_number">
                            @error('entity.vat_number') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <!-- Bank Account Name -->
                        <div class="mb-4">
                            <label for="bank_account_name" class="block text-gray-700 text-sm font-bold mb-2">Bank Account Name</label>
                            <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="bank_account_name" wire:model="entity.bank_account_name" required>
                            @error('entity.bank_account_name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <!-- Bank Account Number -->
                        <div class="mb-4">
                            <label for="bank_account_number" class="block text-gray-700 text-sm font-bold mb-2">Bank Account Number</label>
                            <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="bank_account_number" wire:model="entity.bank_account_number" required>
                            @error('entity.bank_account_number') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <!-- Currency -->
                        <div class="mb-4">
                            <label for="currency" class="block text-gray-700 text-sm font-bold mb-2">Currency</label>
                            <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="currency" wire:model="entity.currency" required maxlength="3">
                            @error('entity.currency') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <!-- Bank Name -->
                        <div class="mb-4">
                            <label for="bank_name" class="block text-gray-700 text-sm font-bold mb-2">Bank Name</label>
                            <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="bank_name" wire:model="entity.bank_name" required>
                            @error('entity.bank_name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <!-- Bank Address -->
                        <div class="mb-4">
                            <label for="bank_address" class="block text-gray-700 text-sm font-bold mb-2">Bank Address</label>
                            <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="bank_address" wire:model="entity.bank_address" required>
                            @error('entity.bank_address') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <!-- Bank Swift Code -->
                        <div class="mb-4">
                            <label for="bank_swift_code" class="block text-gray-700 text-sm font-bold mb-2">Bank Swift Code</label>
                            <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="bank_swift_code" wire:model="entity.bank_swift_code">
                            @error('entity.bank_swift_code') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <!-- Bank IBAN Number -->
                        <div class="mb-4">
                            <label for="bank_iban_number" class="block text-gray-700 text-sm font-bold mb-2">Bank IBAN Number</label>
                            <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="bank_iban_number" wire:model="entity.bank_iban_number">
                            @error('entity.bank_iban_number') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <!-- Bank Code -->
                        <div class="mb-4">
                            <label for="bank_code" class="block text-gray-700 text-sm font-bold mb-2">Bank Code</label>
                            <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="bank_code" wire:model="entity.bank_code">
                            @error('entity.bank_code') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <!-- Bank Branch Code -->
                        <div class="mb-4">
                            <label for="bank_branch_code" class="block text-gray-700 text-sm font-bold mb-2">Bank Branch Code</label>
                            <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="bank_branch_code" wire:model="entity.bank_branch_code">
                            @error('entity.bank_branch_code') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <!-- Status -->
                        <div class="mb-4">
                            <label for="is_active" class="block text-gray-700 text-sm font-bold mb-2">Status</label>
                            <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="is_active" wire:model="entity.is_active">
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>

                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Save</button>
                        <button type="button" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" wire:click="cancel">Cancel</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endif


    <!-- Modal for Delete Confirmation -->
    @if ($confirmingDeletion)
        <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full" id="my-modal">
            <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
                <div class="mt-3 text-center">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Confirm Deletion</h3>
                    <div class="mt-2 px-7 py-3">
                        <p class="text-sm text-gray-500">Are you sure you want to delete this entity?</p>
                    </div>
                    <div class="items-center px-4 py-3">
                        <button wire:click="$set('confirmingDeletion', false)" class="px-4 py-2 bg-gray-500 text-white text-base font-medium rounded-md w-24 mr-2 hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-300">
                            Cancel
                        </button>
                        <button wire:click="delete" class="px-4 py-2 bg-red-500 text-white text-base font-medium rounded-md w-24 hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-300">
                            Delete
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
