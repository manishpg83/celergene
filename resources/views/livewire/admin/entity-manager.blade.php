<div class="w-full p-4">
    <div class="bg-white p-4 rounded-md shadow-custom-card">
        @if (session()->has('message'))
            <div class="mb-4 px-4 py-2 bg-green-100 border border-green-400 text-green-700 rounded">
                {{ session('message') }}
            </div>
        @endif

        <div class="flex items-center mb-4 space-x-4">
            <div class="flex-grow flex space-x-4">
                <select wire:model.live="perPage" class="border p-2 rounded">
                    <option value="5">5</option>
                    <option value="20">20</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
                <select wire:model.live="status" class="border rounded p-2">
                    <option value="all">All Statuses</option>
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                </select>
            </div>
            <div class="relative">
                <input wire:model.live="search" type="text" placeholder="Search Entities..."
                    class="border rounded p-2 pl-10 w-full max-w-xs">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 4a7 7 0 011.746 13.664l4.3 4.3a1 1 0 001.414-1.414l-4.3-4.3A7 7 0 1111 4z" />
                    </svg>
                </span>
            </div>
        </div>

        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Company
                        Name</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Country
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @if ($entities && $entities->isEmpty())
                    <tr>
                        <td colspan="4" class="text-center text-gray-500">No entities found.</td>
                    </tr>
                @else
                    @foreach ($entities as $entity)
                        <tr class="hover:bg-gray-50 transition duration-150 ease-in-out">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $entity->company_name }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $entity->country }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                <button wire:click="toggleActive({{ $entity->id }})"
                                    class="px-2 py-1 text-xs rounded {{ $entity->is_active ? 'bg-green-500 text-white' : 'bg-gray-300 text-gray-700' }}">
                                    {{ $entity->is_active ? 'Active' : 'Inactive' }}
                                </button>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex space-x-2">
                                    <button wire:click="edit({{ $entity->id }})"
                                        class="text-indigo-600 hover:text-indigo-900" title="Edit">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                        </svg>
                                    </button>
                                    <button wire:click="confirmDelete({{ $entity->id }})"
                                        class="text-red-600 hover:text-red-900" title="Delete">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
        <div class="mt-4">
            {{ $entities->links() }}
        </div>
    </div>

    <!-- Modal for Add/Edit Entity -->
    @if ($isEditing)
        <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full" id="my-modal" role="dialog"
            aria-labelledby="modal-title">
            <div class="relative mt-10 mb-10 mx-auto border w-11/12 md:w-4/5 lg:w-1/2 shadow-lg rounded-md bg-white">
                <div class="text-center border-2 border-gray-300 rounded-lg">
                    <h2 id="modal-title"
                        class="text-2xl leading-6 font-medium text-white bg-blue-600 border-b-2 border-gray-300 pb-2 px-4 py-2 rounded-t">
                        {{ $entityId ? 'Edit' : 'Add' }} Entity
                    </h2>
                    <div class="mt-2 px-7 py-3">
                        <form wire:submit.prevent="save">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                                <!-- Company Name -->
                                <div class="mb-4">
                                    <label for="company_name" class="block text-gray-700 text-sm font-bold mb-2">Company
                                        Name</label>
                                    <input type="text"
                                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                        id="company_name" wire:model.defer="company_name" required>
                                    @error('company_name')
                                        <span class="text-red-500 text-xs">The company name field is required.</span>
                                    @enderror
                                </div>

                                <!-- Country -->
                                <div class="mb-4">
                                    <label for="country"
                                        class="block text-gray-700 text-sm font-bold mb-2">Country</label>
                                    <input type="text"
                                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                        id="country" wire:model.defer="country" required>
                                    @error('country')
                                        <span class="text-red-500 text-xs">The country field is required.</span>
                                    @enderror
                                </div>

                                <!-- Address -->
                                <div class="mb-4">
                                    <label for="address"
                                        class="block text-gray-700 text-sm font-bold mb-2">Address</label>
                                    <input type="text"
                                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                        id="address" wire:model.defer="address" required>
                                    @error('address')
                                        <span class="text-red-500 text-xs">The address field is required.</span>
                                    @enderror
                                </div>

                                <!-- Postal Code -->
                                <div class="mb-4">
                                    <label for="postal_code" class="block text-gray-700 text-sm font-bold mb-2">Postal
                                        Code</label>
                                    <input type="text"
                                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                        id="postal_code" wire:model.defer="postal_code" required>
                                    @error('postal_code')
                                        <span class="text-red-500 text-xs">The postal code field is required.</span>
                                    @enderror
                                </div>

                                <!-- Business Registration Number -->
                                <div class="mb-4">
                                    <label for="business_reg_number"
                                        class="block text-gray-700 text-sm font-bold mb-2">Business Registration
                                        Number</label>
                                    <input type="text"
                                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                        id="business_reg_number" wire:model="business_reg_number">
                                    @error('business_reg_number')
                                        <span class="text-red-500 text-xs">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- VAT Number -->
                                <div class="mb-4">
                                    <label for="vat_number" class="block text-gray-700 text-sm font-bold mb-2">VAT
                                        Number</label>
                                    <input type="text"
                                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                        id="vat_number" wire:model="vat_number">
                                    @error('vat_number')
                                        <span class="text-red-500 text-xs">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Bank Account Name -->
                                <div class="mb-4">
                                    <label for="bank_account_name"
                                        class="block text-gray-700 text-sm font-bold mb-2">Bank
                                        Account Name</label>
                                    <input type="text"
                                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                        id="bank_account_name" wire:model="bank_account_name" required>
                                    @error('bank_account_name')
                                        <span class="text-red-500 text-xs">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Bank Account Number -->
                                <div class="mb-4">
                                    <label for="bank_account_number"
                                        class="block text-gray-700 text-sm font-bold mb-2">Bank Account Number</label>
                                    <input type="text"
                                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                        id="bank_account_number" wire:model="bank_account_number" required>
                                    @error('bank_account_number')
                                        <span class="text-red-500 text-xs">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Currency -->
                                <div class="mb-4">
                                    <label for="currency"
                                        class="block text-gray-700 text-sm font-bold mb-2">Currency</label>
                                    <input type="text"
                                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                        id="currency" wire:model="currency" required maxlength="3">
                                    @error('currency')
                                        <span class="text-red-500 text-xs">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Bank Name -->
                                <div class="mb-4">
                                    <label for="bank_name" class="block text-gray-700 text-sm font-bold mb-2">Bank
                                        Name</label>
                                    <input type="text"
                                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                        id="bank_name" wire:model="bank_name" required>
                                    @error('bank_name')
                                        <span class="text-red-500 text-xs">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Bank Address -->
                                <div class="mb-4">
                                    <label for="bank_address" class="block text-gray-700 text-sm font-bold mb-2">Bank
                                        Address</label>
                                    <input type="text"
                                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                        id="bank_address" wire:model="bank_address" required>
                                    @error('bank_address')
                                        <span class="text-red-500 text-xs">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Bank Swift Code -->
                                <div class="mb-4">
                                    <label for="bank_swift_code"
                                        class="block text-gray-700 text-sm font-bold mb-2">Bank
                                        Swift Code</label>
                                    <input type="text"
                                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                        id="bank_swift_code" wire:model="bank_swift_code">
                                    @error('bank_swift_code')
                                        <span class="text-red-500 text-xs">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Bank IBAN Number -->
                                <div class="mb-4">
                                    <label for="bank_iban_number"
                                        class="block text-gray-700 text-sm font-bold mb-2">Bank
                                        IBAN Number</label>
                                    <input type="text"
                                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                        id="bank_iban_number" wire:model="bank_iban_number">
                                    @error('bank_iban_number')
                                        <span class="text-red-500 text-xs">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Bank Code -->
                                <div class="mb-4">
                                    <label for="bank_code" class="block text-gray-700 text-sm font-bold mb-2">Bank
                                        Code</label>
                                    <input type="text"
                                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                        id="bank_code" wire:model="bank_code">
                                    @error('bank_code')
                                        <span class="text-red-500 text-xs">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Bank Branch Code -->
                                <div class="mb-4">
                                    <label for="bank_branch_code"
                                        class="block text-gray-700 text-sm font-bold mb-2">Bank
                                        Branch Code</label>
                                    <input type="text"
                                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                        id="bank_branch_code" wire:model="bank_branch_code">
                                    @error('bank_branch_code')
                                        <span class="text-red-500 text-xs">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Status -->
                                <div class="mb-4">
                                    <label for="is_active"
                                        class="block text-gray-700 text-sm font-bold mb-2">Status</label>
                                    <select
                                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                        id="is_active" wire:model="is_active">
                                        <option value="1">Active</option>
                                        <option value="0">Inactive</option>
                                    </select>
                                </div>

                            </div>

                            <div class="flex justify-end mt-4">
                                <button type="button"
                                    class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                                    wire:click="cancel">Cancel</button>
                                <button type="submit"
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline ml-2">Save</button>
                            </div>
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
                        <button wire:click="$set('confirmingDeletion', false)"
                            class="px-4 py-2 bg-gray-500 text-white text-base font-medium rounded-md w-24 mr-2 hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-300">
                            Cancel
                        </button>
                        <button wire:click="delete"
                            class="px-4 py-2 bg-red-500 text-white text-base font-medium rounded-md w-24 hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-300">
                            Delete
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

