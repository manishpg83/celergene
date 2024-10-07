<div class="w-full">
    <div class="flex items-center mb-4">
        <input type="text" wire:model="search" placeholder="Search Customers..." class="border p-2 mr-2" />
        <select wire:model="perPage" class="border p-2">
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
            <tr>
                <th class="border border-gray-200 px-4 py-2">First Name</th>
                <th class="border border-gray-200 px-4 py-2">Last Name</th>
                <th class="border border-gray-200 px-4 py-2">Email</th>
                <th class="border border-gray-200 px-4 py-2">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($customers as $customer)
                <tr>
                    <td class="border border-gray-200 px-4 py-2">{{ $customer->first_name }}</td>
                    <td class="border border-gray-200 px-4 py-2">{{ $customer->last_name }}</td>
                    <td class="border border-gray-200 px-4 py-2">{{ $customer->email }}</td>
                    <td>{{-- <button wire:click="edit({{ $customer->id }})"
                            class="bg-yellow-500 text-white px-2 py-1">Edit</button>
                        <button wire:click="delete({{ $customer->id }})"
                            class="bg-red-500 text-white px-2 py-1">Delete</button> --}}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $customers->links() }} <!-- Pagination links -->

    <h3 class="mt-6">
        <button wire:click="$toggle('showForm')" class="bg-blue-500 text-white px-4 py-2">
            @if ($showForm)
                Hide Form
            @else
                Add New Customer
            @endif
        </button>
    </h3>
    <div x-show="$wire.showForm">
        <form wire:submit.prevent="store">
            <div>
                <label for="customer_type">Customer Type:</label>
                <input type="radio" wire:model="customer_type" value="Corporate" /> Corporate
                <input type="radio" wire:model="customer_type" value="Individual" /> Individual
            </div>

            <div>
                <label for="salutation">Salutation:</label>
                <select wire:model="salutation" class="border p-2">
                    <option value="">Select Salutation</option>
                    <option value="Mr">Mr</option>
                    <option value="Mrs">Mrs</option>
                    <option value="Ms">Ms</option>
                </select>
            </div>

            <input type="text" wire:model="first_name" placeholder="First Name" class="border p-2" required />
            <input type="text" wire:model="last_name" placeholder="Last Name" class="border p-2" required />
            <input type="text" wire:model="mobile_number" placeholder="Mobile Number" class="border p-2" required />
            <input type="email" wire:model="email" placeholder="Email" class="border p-2" required />

            <input type="text" wire:model="company_name" placeholder="Company Name" class="border p-2" />
            <input type="text" wire:model="business_reg_number" placeholder="Business Reg Number"
                class="border p-2" />
            <input type="text" wire:model="vat_number" placeholder="VAT Number" class="border p-2" />

            <input type="text" wire:model="payment_term_display" placeholder="Payment Term (Display)"
                class="border p-2" required />
            <select wire:model="payment_term_actual" class="border p-2" required>
                <option value="">Select Payment Term (Actual)</option>
                <option value="Term1">Term1</option>
                <option value="Term2">Term2</option>
                <option value="Term3">Term3</option>
            </select>

            <input type="text" wire:model="credit_rating" placeholder="Credit Rating" class="border p-2" required />

            <div>
                <label>Allow Consignment:</label>
                <input type="checkbox" wire:model="allow_consignment" />
            </div>

            <div>
                <label>Must Receive Payment Before Delivery:</label>
                <input type="checkbox" wire:model="must_receive_payment_before_delivery" />
            </div>

            <input type="text" wire:model="billing_address" placeholder="Billing Address" class="border p-2"
                required />
            <select wire:model="billing_country" class="border p-2" required>
                <option value="">Select Billing Country</option>
                <option value="Country1">Country1</option>
                <option value="Country2">Country2</option>
            </select>
            <input type="text" wire:model="billing_postal_code" placeholder="Billing Postal Code" class="border p-2"
                required />

            <input type="text" wire:model="shipping_address_receiver_name_1"
                placeholder="Shipping Address Receiver Name 1" class="border p-2" required />
            <input type="text" wire:model="shipping_address_1" placeholder="Shipping Address 1"
                class="border p-2" required />
            <select wire:model="shipping_country_1" class="border p-2" required>
                <option value="">Select Shipping Country 1</option>
                <option value="Country1">Country1</option>
                <option value="Country2">Country2</option>
            </select>
            <input type="text" wire:model="shipping_postal_code_1" placeholder="Shipping Postal Code 1"
                class="border p-2" required />

            <input type="text" wire:model="shipping_address_receiver_name_2"
                placeholder="Shipping Address Receiver Name 2" class="border p-2" />
            <input type="text" wire:model="shipping_address_2" placeholder="Shipping Address 2"
                class="border p-2" />
            <select wire:model="shipping_country_2" class="border p-2">
                <option value="">Select Shipping Country 2</option>
                <option value="Country1">Country1</option>
                <option value="Country2">Country2</option>
            </select>
            <input type="text" wire:model="shipping_postal_code_2" placeholder="Shipping Postal Code 2"
                class="border p-2" />

            <input type="text" wire:model="shipping_address_receiver_name_3"
                placeholder="Shipping Address Receiver Name 3" class="border p-2" />
            <input type="text" wire:model="shipping_address_3" placeholder="Shipping Address 3"
                class="border p-2" />
            <select wire:model="shipping_country_3" class="border p-2">
                <option value="">Select Shipping Country 3</option>
                <option value="Country1">Country1</option>
                <option value="Country2">Country2</option>
            </select>
            <input type="text" wire:model="shipping_postal_code_3" placeholder="Shipping Postal Code 3"
                class="border p-2" />

            <button type="submit" class="bg-blue-500 text-white px-4 py-2 mt-2">Add Customer</button>
        </form>
    </div>
</div>
