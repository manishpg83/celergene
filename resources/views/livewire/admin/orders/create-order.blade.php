<div class="container mt-5">
    <h2 class="mb-4">Create Order</h2>

    @if (session()->has('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <form wire:submit.prevent="submitOrder" class="bg-light p-4 rounded shadow">
        <div class="mb-3">
            <label for="customer" class="form-label">Select Customer:</label>
            <select wire:model="customer_id" id="customer"
                class="form-select @error('customer_id') is-invalid @enderror">
                <option value="">Select a customer</option>
                @foreach ($customers as $customer)
                    <option value="{{ $customer->id }}">{{ $customer->first_name }} {{ $customer->last_name }}</option>
                @endforeach
            </select>
            @error('customer_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="shipping_address" class="form-label">Shipping Address:</label>
            <input type="text" wire:model="shipping_address" id="shipping_address"
                class="form-control @error('shipping_address') is-invalid @enderror">
            @error('shipping_address')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="payment_mode" class="form-label">Payment Mode:</label>
            <select wire:model="payment_mode" id="payment_mode"
                class="form-select @error('payment_mode') is-invalid @enderror">
                <option value="Credit Card">Credit Card</option>
                <option value="Bank Transfer">Bank Transfer</option>
                <option value="Cash">Cash</option>
            </select>
            @error('payment_mode')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="invoice_status" class="form-label">Invoice Status:</label>
            <select wire:model="invoice_status" id="invoice_status"
                class="form-select @error('invoice_status') is-invalid @enderror">
                <option value="Pending">Pending</option>
                <option value="Paid">Paid</option>
                <option value="Cancelled">Cancelled</option>
            </select>
            @error('invoice_status')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <h5>Order Details</h5>
            @foreach ($orderDetails as $index => $orderDetail)
                <div class="row mb-3 align-items-end">
                    <div class="col">
                        <select wire:model.live="orderDetails.{{ $index }}.product_id"
                            class="form-select @error('orderDetails.' . $index . '.product_id') is-invalid @enderror">
                            <option value="">Select a product</option>
                            @foreach ($products as $product)
                                <option value="{{ $product->id }}">{{ $product->product_name }}</option>
                            @endforeach
                        </select>
                        @error('orderDetails.' . $index . '.product_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col">
                        <input type="number" wire:model.live="orderDetails.{{ $index }}.quantity"
                            placeholder="Quantity"
                            class="form-control @error('orderDetails.' . $index . '.quantity') is-invalid @enderror"
                            min="1">
                        @error('orderDetails.' . $index . '.quantity')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col">
                        <input type="number" wire:model.live="orderDetails.{{ $index }}.unit_price"
                            placeholder="Unit Price" class="form-control" readonly>
                    </div>
                    <div class="col">
                        <input type="number" wire:model.live="orderDetails.{{ $index }}.discount"
                            placeholder="Discount"
                            class="form-control @error('orderDetails.' . $index . '.discount') is-invalid @enderror"
                            min="0" step="0.01">
                        @error('orderDetails.' . $index . '.discount')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-auto">
                        <button wire:click.prevent="removeOrderDetail({{ $index }})"
                            class="btn btn-danger btn-sm">Remove</button>
                    </div>
                </div>
            @endforeach

            <button wire:click.prevent="addOrderDetail" class="btn btn-primary">+ Add Item</button>
        </div>

        <div class="mb-3">
            <label for="subtotal" class="form-label">Subtotal:</label>
            <input type="text" wire:model="subtotal" id="subtotal" readonly class="form-control"
                placeholder="Subtotal">
        </div>

        <div class="mb-3">
            <div class="d-flex justify-content-between align-items-center">
                <label class="form-label mb-0">Total Discount:</label>
                <span class="fw-bold">{{ number_format($totalDiscount, 2) }}</span>
            </div>
        </div>

        <div class="mb-3">
            <label for="tax" class="form-label">Tax:</label>
            <input type="number" wire:model.live="tax" id="tax"
                class="form-control @error('tax') is-invalid @enderror" min="0" step="0.01">
            @error('tax')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="total" class="form-label">Total:</label>
            <input type="text" wire:model="total" id="total" readonly class="form-control"
                placeholder="Total">
        </div>

        <button type="submit" class="btn btn-success">Submit Order</button>
    </form>
</div>
