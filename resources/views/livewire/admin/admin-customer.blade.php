<div class="w-full p-4">
    <div class="flex items-center mb-4">
        <input type="text" wire:model="search" placeholder="Search Customers..." class="border p-2 mr-2 rounded" />
        <select wire:model="perPage" class="border p-2 rounded">
            <option value="10">10</option>
            <option value="20">20</option>
            <option value="50">50</option>
            <option value="100">100</option>
        </select>
    </div>

    @if (session()->has('message'))
        <div class="mb-4 text-green-600">{{ session('message') }}</div>
    @endif

    <table class="min-w-full border-collapse border border-gray-200">
        <thead>
            <tr class="bg-gray-100">
                <th class="border border-gray-200 px-4 py-2">First Name</th>
                <th class="border border-gray-200 px-4 py-2">Last Name</th>
                <th class="border border-gray-200 px-4 py-2">Email</th>
                <th class="border border-gray-200 px-4 py-2">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($customers as $customer)
                <tr class="hover:bg-gray-50">
                    <td class="border border-gray-200 px-4 py-2">{{ $customer->first_name }}</td>
                    <td class="border border-gray-200 px-4 py-2">{{ $customer->last_name }}</td>
                    <td class="border border-gray-200 px-4 py-2">{{ $customer->email }}</td>
                    <td class="border border-gray-200 px-4 py-2">
                        <button wire:click="edit({{ $customer->id }})"
                            class="bg-yellow-500 text-white px-2 py-1 rounded">Edit</button>
                        <button wire:click="confirmDelete({{ $customer->id }})"
                            class="bg-red-500 text-white px-2 py-1 rounded">Delete</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $customers->links() }} <!-- Pagination links -->

    <h3 class="mt-6">
        <button wire:click="$toggle('showForm')" class="bg-blue-500 text-white px-4 py-2 rounded">
            @if ($showForm)
                Hide Form
            @else
                Add New Customer
            @endif
        </button>
    </h3>

    <div x-show="$wire.showForm" class="mt-4 bg-gray-100 p-4 rounded shadow-md">
        <form wire:submit.prevent="store">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="customer_type" class="block mb-1">Customer Type:</label>
                    <div class="flex items-center space-x-4">
                        <label>
                            <input type="radio" wire:model="customer_type" value="Corporate" class="mr-1" />
                            Corporate
                        </label>
                        <label>
                            <input type="radio" wire:model="customer_type" value="Individual" class="mr-1" />
                            Individual
                        </label>
                    </div>
                </div>

                <div>
                    <label for="salutation" class="block mb-1">Salutation:</label>
                    <select wire:model="salutation" class="border p-2 rounded">
                        <option value="">Select Salutation</option>
                        <option value="Mr">Mr</option>
                        <option value="Mrs">Mrs</option>
                        <option value="Ms">Ms</option>
                    </select>
                </div>

                <input type="text" wire:model="first_name" placeholder="First Name" class="border p-2 rounded"
                    required />
                <input type="text" wire:model="last_name" placeholder="Last Name" class="border p-2 rounded"
                    required />
                <input type="text" wire:model="mobile_number" placeholder="Mobile Number" class="border p-2 rounded"
                    required />
                <input type="email" wire:model="email" placeholder="Email" class="border p-2 rounded" required />

                <input type="text" wire:model="company_name" placeholder="Company Name" class="border p-2 rounded" />
                <input type="text" wire:model="business_reg_number" placeholder="Business Reg Number"
                    class="border p-2 rounded" />
                <input type="text" wire:model="vat_number" placeholder="VAT Number" class="border p-2 rounded" />

                <input type="text" wire:model="payment_term_display" placeholder="Payment Term (Display)"
                    class="border p-2 rounded" required />
                <select wire:model="payment_term_actual" class="border p-2 rounded" required>
                    <option value="">Select Payment Term (Actual)</option>
                    <option value="Term1">Term1</option>
                    <option value="Term2">Term2</option>
                    <option value="Term3">Term3</option>
                </select>

                <input type="text" wire:model="credit_rating" placeholder="Credit Rating" class="border p-2 rounded"
                    required />

                <div class="flex items-center">
                    <label class="mr-2">Allow Consignment:</label>
                    <input type="checkbox" wire:model="allow_consignment" />
                </div>

                <div class="flex items-center">
                    <label class="mr-2">Must Receive Payment Before Delivery:</label>
                    <input type="checkbox" wire:model="must_receive_payment_before_delivery" />
                </div>

                <input type="text" wire:model="billing_address" placeholder="Billing Address"
                    class="border p-2 rounded" required />
                <select wire:model="billing_country" class="border p-2 rounded" required>
                    <option value="">Select Billing Country</option>
                    <option value="Country1">Country1</option>
                    <option value="Country2">Country2</option>
                </select>
                <input type="text" wire:model="billing_postal_code" placeholder="Billing Postal Code"
                    class="border p-2 rounded" required />

                <input type="text" wire:model="shipping_address_receiver_name_1"
                    placeholder="Shipping Address Receiver Name 1" class="border p-2 rounded" required />
                <input type="text" wire:model="shipping_address_1" placeholder="Shipping Address 1"
                    class="border p-2 rounded" required />
                <select wire:model="shipping_country_1" class="border p-2 rounded" required>
                    <option value="">Select Shipping Country 1</option>
                    <option value="Country1">Country1</option>
                    <option value="Country2">Country2</option>
                </select>
                <input type="text" wire:model="shipping_postal_code_1" placeholder="Shipping Postal Code 1"
                    class="border p-2 rounded" required />

                <input type="text" wire:model="shipping_address_receiver_name_2"
                    placeholder="Shipping Address Receiver Name 2" class="border p-2 rounded" />
                <input type="text" wire:model="shipping_address_2" placeholder="Shipping Address 2"
                    class="border p-2 rounded" />
                <select wire:model="shipping_country_2" class="border p-2 rounded">
                    <option value="">Select Shipping Country 2</option>
                    <option value="Country1">Country1</option>
                    <option value="Country2">Country2</option>
                </select>
                <input type="text" wire:model="shipping_postal_code_2" placeholder="Shipping Postal Code 2"
                    class="border p-2 rounded" />

                <input type="text" wire:model="shipping_address_receiver_name_3"
                    placeholder="Shipping Address Receiver Name 3" class="border p-2 rounded" />
                <input type="text" wire:model="shipping_address_3" placeholder="Shipping Address 3"
                    class="border p-2 rounded" />
                <select wire:model="shipping_country_3" class="border p-2 rounded">
                    <option value="">Select Shipping Country 3</option>
                    <option value="Country1">Country1</option>
                    <option value="Country2">Country2</option>
                </select>
                <input type="text" wire:model="shipping_postal_code_3" placeholder="Shipping Postal Code 3"
                    class="border p-2 rounded" />

                <div class="col-span-2 mt-4">
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Add Customer</button>
                </div>
            </div>
        </form>
    </div>


    <!-- Edit Customer Modal -->
    <div x-data="{ open: @entangle('showEditForm') }" x-show="open" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
        <div class="bg-white rounded shadow-lg p-6 w-1/2 max-h-[90%] overflow-auto">
            <h2 class="text-lg font-bold mb-4">Edit Customer</h2>
            <form wire:submit.prevent="update">
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-sm font-medium">Customer Type</label>
                        <input type="text" wire:model="customer_type" class="border w-full p-2 rounded" required />
                        @error('customer_type') <span class="text-red-600">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium">Salutation</label>
                        <input type="text" wire:model="salutation" class="border w-full p-2 rounded" />
                        @error('salutation') <span class="text-red-600">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium">First Name</label>
                        <input type="text" wire:model="first_name" class="border w-full p-2 rounded" required />
                        @error('first_name') <span class="text-red-600">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium">Last Name</label>
                        <input type="text" wire:model="last_name" class="border w-full p-2 rounded" required />
                        @error('last_name') <span class="text-red-600">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium">Mobile Number</label>
                        <input type="text" wire:model="mobile_number" class="border w-full p-2 rounded" required />
                        @error('mobile_number') <span class="text-red-600">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium">Email</label>
                        <input type="email" wire:model="email" class="border w-full p-2 rounded" required />
                        @error('email') <span class="text-red-600">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium">Company Name</label>
                        <input type="text" wire:model="company_name" class="border w-full p-2 rounded" />
                        @error('company_name') <span class="text-red-600">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium">Business Registration Number</label>
                        <input type="text" wire:model="business_reg_number" class="border w-full p-2 rounded" />
                        @error('business_reg_number') <span class="text-red-600">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium">VAT Number</label>
                        <input type="text" wire:model="vat_number" class="border w-full p-2 rounded" />
                        @error('vat_number') <span class="text-red-600">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium">Payment Term Display</label>
                        <input type="text" wire:model="payment_term_display" class="border w-full p-2 rounded" required />
                        @error('payment_term_display') <span class="text-red-600">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium">Payment Term Actual</label>
                        <select wire:model="payment_term_actual" class="border w-full p-2 rounded" required>
                            <option value="">Select Payment Term</option>
                            <option value="Term1">Term 1</option>
                            <option value="Term2">Term 2</option>
                            <option value="Term3">Term 3</option>
                        </select>
                        @error('payment_term_actual') <span class="text-red-600">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium">Credit Rating</label>
                        <input type="text" wire:model="credit_rating" class="border w-full p-2 rounded" />
                        @error('credit_rating') <span class="text-red-600">{{ $message }}</span> @enderror
                    </div>
                    <div class="col-span-2">
                        <label class="inline-flex items-center">
                            <input type="checkbox" wire:model="allow_consignment" class="form-checkbox h-5 w-5 text-blue-600" />
                            <span class="ml-2 text-sm">Allow Consignment</span>
                        </label>
                    </div>
                    <div class="col-span-2">
                        <label class="inline-flex items-center">
                            <input type="checkbox" wire:model="must_receive_payment_before_delivery" class="form-checkbox h-5 w-5 text-blue-600" />
                            <span class="ml-2 text-sm">Must Receive Payment Before Delivery</span>
                        </label>
                    </div>
                    <div class="col-span-2">
                        <label class="block text-sm font-medium">Billing Address</label>
                        <input type="text" wire:model="billing_address" class="border w-full p-2 rounded" required />
                        @error('billing_address') <span class="text-red-600">{{ $message }}</span> @enderror
                    </div>
                    <div class="col-span-2">
                        <label class="block text-sm font-medium">Billing Country</label>
                        <input type="text" wire:model="billing_country" class="border w-full p-2 rounded" required />
                        @error('billing_country') <span class="text-red-600">{{ $message }}</span> @enderror
                    </div>
                    <div class="col-span-2">
                        <label class="block text-sm font-medium">Billing Postal Code</label>
                        <input type="text" wire:model="billing_postal_code" class="border w-full p-2 rounded" />
                        @error('billing_postal_code') <span class="text-red-600">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="flex justify-end mt-4">
                    <button type="button" @click="open = false; @this.resetInputFields();" class="bg-gray-300 text-gray-700 px-4 py-2 rounded mr-2">Cancel</button>
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Save</button>
                </div>
            </form>
        </div>
    </div>

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
