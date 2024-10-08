<div class="">
    <div class="">
        @if (session()->has('message'))
            <div class="mb-4 text-green-600 font-semibold">{{ session('message') }}</div>
        @endif

        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between mb-3">
                    <!-- Pagination Dropdown (Left-aligned) -->
                    <select wire:model.live="perPage" class="form-select" style="width: auto;">
                        <option value="5">5</option>
                        <option value="20">20</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>

                    <!-- Search Input (Right-aligned) -->
                    <input type="text" wire:model.live="search" placeholder="Search Customers..."
                        class="form-control" style="width: auto;" />
                </div>

                @if (session()->has('message'))
                    <div class="alert alert-success">{{ session('message') }}</div>
                @endif

                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Email</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($customers->isEmpty())
                                <tr>
                                    <td colspan="4" class="text-center">No customers found.</td>
                                </tr>
                            @else
                                @foreach ($customers as $customer)
                                    <tr>
                                        <td>{{ $customer->first_name }}</td>
                                        <td>{{ $customer->last_name }}</td>
                                        <td>{{ $customer->email }}</td>
                                        <td>
                                            <div class="d-flex justify-content-around">
                                                <!-- Edit Button -->
                                                <button wire:click="edit({{ $customer->id }})"
                                                    class="btn btn-icon btn-text-primary" title="Edit">
                                                    <i class="ti ti-pencil"></i>
                                                </button>

                                                <!-- Delete Button -->
                                                <button wire:click="confirmDelete({{ $customer->id }})"
                                                    class="btn btn-icon btn-text-danger" title="Delete">
                                                    <i class="ti ti-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    {{ $customers->links() }}
                </div>
            </div>
        </div>
    </div>


    <div class="bg-white shadow-custom-card rounded-lg p-6 mb-4">
        <h3 class="mt-6">
            <button wire:click="$toggle('showForm')" class="bg-blue-500 text-white px-4 py-2 rounded">
                @if ($showForm)
                    Hide Form
                @else
                    Add New Customer
                @endif
            </button>
        </h3>

        <div x-show="$wire.showForm" class="mt-4 bg-white p-4 rounded shadow-custom-card border-2">
            <form wire:submit.prevent="store">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="customer_type" class="block mb-1 font-semibold">Customer Type:</label>
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
                        <label for="salutation" class="block mb-1 font-semibold">Salutation:</label>
                        <select wire:model="salutation"
                            class="border p-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Select Salutation</option>
                            <option value="Mr">Mr</option>
                            <option value="Mrs">Mrs</option>
                            <option value="Ms">Ms</option>
                        </select>
                    </div>

                    <input type="text" wire:model="first_name" placeholder="First Name"
                        class="border p-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-500" required />
                    <input type="text" wire:model="last_name" placeholder="Last Name"
                        class="border p-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-500" required />
                    <input type="text" wire:model="mobile_number" placeholder="Mobile Number"
                        class="border p-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-500" required />
                    <input type="email" wire:model="email" placeholder="Email"
                        class="border p-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-500" required />

                    <input type="text" wire:model="company_name" placeholder="Company Name"
                        class="border p-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-500" />
                    <input type="text" wire:model="business_reg_number" placeholder="Business Reg Number"
                        class="border p-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-500" />
                    <input type="text" wire:model="vat_number" placeholder="VAT Number"
                        class="border p-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-500" />

                    <input type="text" wire:model="payment_term_display" placeholder="Payment Term (Display)"
                        class="border p-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-500" required />
                    <select wire:model="payment_term_actual"
                        class="border p-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        <option value="">Select Payment Term (Actual)</option>
                        <option value="Term1">Term1</option>
                        <option value="Term2">Term2</option>
                        <option value="Term3">Term3</option>
                    </select>

                    <input type="text" wire:model="credit_rating" placeholder="Credit Rating"
                        class="border p-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-500" required />

                    <div class="flex items-center">
                        <label class="mr-2 font-semibold">Allow Consignment:</label>
                        <input type="checkbox" wire:model="allow_consignment" class="border rounded" />
                    </div>

                    <div class="flex items-center">
                        <label class="mr-2 font-semibold">Must Receive Payment Before Delivery:</label>
                        <input type="checkbox" wire:model="must_receive_payment_before_delivery"
                            class="border rounded" />
                    </div>

                    <input type="text" wire:model="billing_address" placeholder="Billing Address"
                        class="border p-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-500" required />
                    <select wire:model="billing_country"
                        class="border p-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        <option value="">Select Billing Country</option>
                        <option value="Country1">Country1</option>
                        <option value="Country2">Country2</option>
                    </select>
                    <input type="text" wire:model="billing_postal_code" placeholder="Billing Postal Code"
                        class="border p-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-500" required />

                    <input type="text" wire:model="shipping_address_receiver_name_1"
                        placeholder="Shipping Address Receiver Name 1"
                        class="border p-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-500" required />
                    <input type="text" wire:model="shipping_address_1" placeholder="Shipping Address 1"
                        class="border p-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-500" required />
                    <select wire:model="shipping_country_1"
                        class="border p-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        <option value="">Select Shipping Country 1</option>
                        <option value="Country1">Country1</option>
                        <option value="Country2">Country2</option>
                    </select>
                    <input type="text" wire:model="shipping_postal_code_1" placeholder="Shipping Postal Code 1"
                        class="border p-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-500" required />

                    <input type="text" wire:model="shipping_address_receiver_name_2"
                        placeholder="Shipping Address Receiver Name 2"
                        class="border p-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-500" />
                    <input type="text" wire:model="shipping_address_2" placeholder="Shipping Address 2"
                        class="border p-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-500" />
                    <select wire:model="shipping_country_2"
                        class="border p-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Select Shipping Country 2</option>
                        <option value="Country1">Country1</option>
                        <option value="Country2">Country2</option>
                    </select>
                    <input type="text" wire:model="shipping_postal_code_2" placeholder="Shipping Postal Code 2"
                        class="border p-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-500" />

                    <input type="text" wire:model="shipping_address_receiver_name_3"
                        placeholder="Shipping Address Receiver Name 3"
                        class="border p-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-500" />
                    <input type="text" wire:model="shipping_address_3" placeholder="Shipping Address 3"
                        class="border p-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-500" />
                    <select wire:model="shipping_country_3"
                        class="border p-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Select Shipping Country 3</option>
                        <option value="Country1">Country1</option>
                        <option value="Country2">Country2</option>
                    </select>
                    <input type="text" wire:model="shipping_postal_code_3" placeholder="Shipping Postal Code 3"
                        class="border p-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-500" />

                    <div class="col-span-2 mt-4 text-end">
                        <button type="submit"
                            class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition duration-200">Add
                            Customer</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Customer Modal with 2x2 Grid Layout -->
    <div x-data="{ open: @entangle('showEditForm') }" x-show="open"
        class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
        <div class="bg-white rounded shadow-lg p-6 w-1/2 max-h-[90%] overflow-auto">
            <h2 class="text-lg font-bold mb-4">Edit Customer</h2>
            <form wire:submit.prevent="update">
                <!-- Updated Grid Layout -->
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <!-- Customer Type -->
                    <div>
                        <label for="customer_type" class="block text-sm font-medium">Customer Type</label>
                        <div class="flex items-center space-x-4">
                            <label>
                                <input type="radio" wire:model="customer_type" value="Corporate" class="mr-1" />
                                Corporate
                            </label>
                            <label>
                                <input type="radio" wire:model="customer_type" value="Individual"
                                    class="mr-1" />
                                Individual
                            </label>
                        </div>
                    </div>

                    <!-- Salutation -->
                    <div>
                        <label class="block text-sm font-medium">Salutation</label>
                        <select wire:model="salutation" class="border p-2 rounded w-full">
                            <option value="">Select Salutation</option>
                            <option value="Mr">Mr</option>
                            <option value="Mrs">Mrs</option>
                            <option value="Ms">Ms</option>
                        </select>
                    </div>

                    <!-- First Name -->
                    <div>
                        <label class="block text-sm font-medium">First Name</label>
                        <input type="text" wire:model="first_name" class="border p-2 rounded w-full" required />
                    </div>

                    <!-- Last Name -->
                    <div>
                        <label class="block text-sm font-medium">Last Name</label>
                        <input type="text" wire:model="last_name" class="border p-2 rounded w-full" required />
                    </div>

                    <!-- Mobile Number -->
                    <div>
                        <label class="block text-sm font-medium">Mobile Number</label>
                        <input type="text" wire:model="mobile_number" class="border p-2 rounded w-full"
                            required />
                    </div>

                    <!-- Email -->
                    <div>
                        <label class="block text-sm font-medium">Email</label>
                        <input type="email" wire:model="email" class="border p-2 rounded w-full" required />
                    </div>

                    <!-- Company Name -->
                    <div>
                        <label class="block text-sm font-medium">Company Name</label>
                        <input type="text" wire:model="company_name" class="border p-2 rounded w-full" />
                    </div>

                    <!-- Business Registration Number -->
                    <div>
                        <label class="block text-sm font-medium">Business Registration Number</label>
                        <input type="text" wire:model="business_reg_number" class="border p-2 rounded w-full" />
                    </div>

                    <!-- VAT Number -->
                    <div>
                        <label class="block text-sm font-medium">VAT Number</label>
                        <input type="text" wire:model="vat_number" class="border p-2 rounded w-full" />
                    </div>

                    <!-- Payment Term Display -->
                    <div>
                        <label class="block text-sm font-medium">Payment Term (Display)</label>
                        <input type="text" wire:model="payment_term_display" class="border p-2 rounded w-full"
                            required />
                    </div>

                    <!-- Payment Term Actual -->
                    <div>
                        <label class="block text-sm font-medium">Payment Term (Actual)</label>
                        <select wire:model="payment_term_actual" class="border p-2 rounded w-full" required>
                            <option value="">Select Payment Term</option>
                            <option value="Term1">Term 1</option>
                            <option value="Term2">Term 2</option>
                            <option value="Term3">Term 3</option>
                        </select>
                    </div>

                    <!-- Credit Rating -->
                    <div>
                        <label class="block text-sm font-medium">Credit Rating</label>
                        <input type="text" wire:model="credit_rating" class="border p-2 rounded w-full"
                            required />
                    </div>

                    <!-- Allow Consignment Checkbox -->
                    <div class="col-span-2">
                        <label class="inline-flex items-center">
                            <input type="checkbox" wire:model="allow_consignment"
                                class="form-checkbox h-5 w-5 text-blue-600" />
                            <span class="ml-2 text-sm">Allow Consignment</span>
                        </label>
                    </div>

                    <!-- Must Receive Payment Checkbox -->
                    <div class="col-span-2">
                        <label class="inline-flex items-center">
                            <input type="checkbox" wire:model="must_receive_payment_before_delivery"
                                class="form-checkbox h-5 w-5 text-blue-600" />
                            <span class="ml-2 text-sm">Must Receive Payment Before Delivery</span>
                        </label>
                    </div>

                    <!-- Billing Address -->
                    <div class="col-span-2">
                        <label class="block text-sm font-medium">Billing Address</label>
                        <input type="text" wire:model="billing_address" class="border p-2 rounded w-full"
                            required />
                    </div>

                    <!-- Billing Country -->
                    <div class="col-span-2">
                        <label class="block text-sm font-medium">Billing Country</label>
                        <select wire:model="billing_country" class="border p-2 rounded w-full" required>
                            <option value="">Select Billing Country</option>
                            <option value="Country1">Country 1</option>
                            <option value="Country2">Country 2</option>
                        </select>
                    </div>

                    <!-- Billing Postal Code -->
                    <div class="col-span-2">
                        <label class="block text-sm font-medium">Billing Postal Code</label>
                        <input type="text" wire:model="billing_postal_code" class="border p-2 rounded w-full"
                            required />
                    </div>

                    <!-- Shipping Address Receiver Name 1 -->
                    <div>
                        <label class="block text-sm font-medium">Shipping Address Receiver Name 1</label>
                        <input type="text" wire:model="shipping_address_receiver_name_1"
                            class="border p-2 rounded w-full" required />
                    </div>

                    <!-- Shipping Address 1 -->
                    <div>
                        <label class="block text-sm font-medium">Shipping Address 1</label>
                        <input type="text" wire:model="shipping_address_1" class="border p-2 rounded w-full"
                            required />
                    </div>

                    <!-- Shipping Country 1 -->
                    <div>
                        <label class="block text-sm font-medium">Shipping Country 1</label>
                        <select wire:model="shipping_country_1" class="border p-2 rounded w-full" required>
                            <option value="">Select Shipping Country 1</option>
                            <option value="Country1">Country 1</option>
                            <option value="Country2">Country 2</option>
                        </select>
                    </div>

                    <!-- Shipping Postal Code 1 -->
                    <div>
                        <label class="block text-sm font-medium">Shipping Postal Code 1</label>
                        <input type="text" wire:model="shipping_postal_code_1" class="border p-2 rounded w-full"
                            required />
                    </div>

                    <!-- Shipping Address Receiver Name 2 -->
                    <div>
                        <label class="block text-sm font-medium">Shipping Address Receiver Name 2</label>
                        <input type="text" wire:model="shipping_address_receiver_name_2"
                            class="border p-2 rounded w-full" />
                    </div>

                    <!-- Shipping Address 2 -->
                    <div>
                        <label class="block text-sm font-medium">Shipping Address 2</label>
                        <input type="text" wire:model="shipping_address_2" class="border p-2 rounded w-full" />
                    </div>

                    <!-- Shipping Country 2 -->
                    <div>
                        <label class="block text-sm font-medium">Shipping Country 2</label>
                        <select wire:model="shipping_country_2" class="border p-2 rounded w-full">
                            <option value="">Select Shipping Country 2</option>
                            <option value="Country1">Country 1</option>
                            <option value="Country2">Country 2</option>
                        </select>
                    </div>

                    <!-- Shipping Postal Code 2 -->
                    <div>
                        <label class="block text-sm font-medium">Shipping Postal Code 2</label>
                        <input type="text" wire:model="shipping_postal_code_2"
                            class="border p-2 rounded w-full" />
                    </div>

                    <!-- Shipping Address Receiver Name 3 -->
                    <div>
                        <label class="block text-sm font-medium">Shipping Address Receiver Name 3</label>
                        <input type="text" wire:model="shipping_address_receiver_name_3"
                            class="border p-2 rounded w-full" />
                    </div>

                    <!-- Shipping Address 3 -->
                    <div>
                        <label class="block text-sm font-medium">Shipping Address 3</label>
                        <input type="text" wire:model="shipping_address_3" class="border p-2 rounded w-full" />
                    </div>

                    <!-- Shipping Country 3 -->
                    <div>
                        <label class="block text-sm font-medium">Shipping Country 3</label>
                        <select wire:model="shipping_country_3" class="border p-2 rounded w-full">
                            <option value="">Select Shipping Country 3</option>
                            <option value="Country1">Country 1</option>
                            <option value="Country2">Country 2</option>
                        </select>
                    </div>

                    <!-- Shipping Postal Code 3 -->
                    <div>
                        <label class="block text-sm font-medium">Shipping Postal Code 3</label>
                        <input type="text" wire:model="shipping_postal_code_3"
                            class="border p-2 rounded w-full" />
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end mt-4">
                    <button type="button" @click="open = false; @this.resetInputFields();"
                        class="bg-gray-300 text-gray-700 px-4 py-2 rounded mr-2">Cancel</button>
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
                        <p class="text-sm text-gray-500">Are you sure you want to delete this Customer?</p>
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
