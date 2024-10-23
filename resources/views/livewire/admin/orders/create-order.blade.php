<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header sticky-element bg-label-secondary d-flex justify-content-between align-items-center flex-column flex-sm-row">
                    <h5 class="card-title mb-sm-0 me-2">Create Order</h5>
                    <div class="action-btns">
                        <button wire:click="back" class="btn btn-label-primary me-4">
                            <span class="align-middle"> Back</span>
                        </button>
                    </div>
                </div>

                <div class="card-body">
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

                    <form wire:submit.prevent="submitOrder">
                        <!-- Customer Selection -->
                        <div class="row g-3 mt-0">
                            <div class="col-md-6">
                                <label for="customer" class="form-label">Select Customer:</label>
                                <select wire:model.live="customer_id" id="customer" class="form-select @error('customer_id') is-invalid @enderror">
                                    <option value="">Select a customer</option>
                                    @foreach ($customers as $customer)
                                        <option value="{{ $customer->id }}">{{ $customer->first_name }} {{ $customer->last_name }}</option>
                                    @endforeach
                                </select>
                                @error('customer_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            @if ($customer_id)
                                <div class="col-md-6">
                                    <label for="selected_shipping_address" class="form-label">Select Shipping Address:</label>
                                    <select wire:model.live="selected_shipping_address" id="selected_shipping_address" class="form-select @error('selected_shipping_address') is-invalid @enderror">
                                        @foreach ($shipping_addresses as $key => $address)
                                            @if ($address)
                                                <option value="{{ $key }}">Address {{ $key }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                    @error('selected_shipping_address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-12">
                                    <label for="shipping_address" class="form-label">Shipping Address:</label>
                                    <input type="text" wire:model="shipping_address" id="shipping_address" class="form-control @error('shipping_address') is-invalid @enderror" readonly>
                                    @error('shipping_address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            @endif
                        </div>

                        <!-- Payment and Invoice Details -->
                        <div class="row g-3 mt-4">
                            <div class="col-md-6">
                                <label for="payment_mode" class="form-label">Payment Mode:</label>
                                <select wire:model="payment_mode" id="payment_mode" class="form-select @error('payment_mode') is-invalid @enderror">
                                    <option value="Credit Card">Credit Card</option>
                                    <option value="Bank Transfer">Bank Transfer</option>
                                    <option value="Cash">Cash</option>
                                </select>
                                @error('payment_mode')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="invoice_status" class="form-label">Invoice Status:</label>
                                <select wire:model="invoice_status" id="invoice_status" class="form-select @error('invoice_status') is-invalid @enderror">
                                    <option value="Pending">Pending</option>
                                    <option value="Paid">Paid</option>
                                    <option value="Cancelled">Cancelled</option>
                                </select>
                                @error('invoice_status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Order Details -->
                        <div class="row g-3 mt-4">
                            <div class="col-12">
                                <h5>Order Details</h5>
                                @foreach ($orderDetails as $index => $orderDetail)
                                    <div class="row align-items-end mt-0 g-2">
                                        <div class="col-md-3">
                                            <select wire:model.live="orderDetails.{{ $index }}.product_id" class="form-select @error('orderDetails.' . $index . '.product_id') is-invalid @enderror">
                                                <option value="">Select a product</option>
                                                @foreach ($products as $product)
                                                    <option value="{{ $product->id }}">{{ $product->product_name }}</option>
                                                @endforeach
                                            </select>
                                            @error('orderDetails.' . $index . '.product_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-2">
                                            <div class="col-6">Quantity</div>
                                            <input type="number" wire:model.live="orderDetails.{{ $index }}.quantity" placeholder="Quantity" class="form-control @error('orderDetails.' . $index . '.quantity') is-invalid @enderror" min="1">
                                            @error('orderDetails.' . $index . '.quantity')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-2">
                                            <div class="col-6">Unit Price</div>
                                            <input type="number" wire:model.live="orderDetails.{{ $index }}.unit_price" placeholder="Unit Price" class="form-control" readonly>
                                        </div>

                                        <div class="col-md-2">
                                            <div class="col-6">Discount</div>
                                            <input type="number" wire:model.live="orderDetails.{{ $index }}.discount" placeholder="Discount" class="form-control @error('orderDetails.' . $index . '.discount') is-invalid @enderror" min="0" step="0.01">
                                            @error('orderDetails.' . $index . '.discount')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-1 mb-1">
                                            <button wire:click.prevent="removeOrderDetail({{ $index }})" class="btn btn-danger btn-sm">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>
                                        
                                    </div>
                                @endforeach

                                <button wire:click.prevent="addOrderDetail" class="btn btn-primary mt-3">+ Add Item</button>
                            </div>
                        </div>

                        <!-- Order Summary -->
                        <div class="row mt-4">
                            <div class="col-md-6 ms-auto">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row mb-2">
                                            <div class="col-6">Subtotal:</div>
                                            <div class="col-6 text-end">${{ number_format($subtotal, 2) }}</div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col-6">Discount:</div>
                                            <div class="col-6 text-end text-danger">-${{ number_format($totalDiscount, 2) }}</div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col-6">Tax:</div>
                                            <div class="col-6">
                                                <div class="input-group">
                                                    <span class="input-group-text">$</span>
                                                    <input type="number" wire:model.live="tax" class="form-control" min="0" step="0.01">
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-6"><strong>Total:</strong></div>
                                            <div class="col-6 text-end"><strong>${{ number_format($total, 2) }}</strong></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="d-flex justify-content-end mt-4">
                            <button type="submit" class="btn btn-success">Submit Order</button>
                        </div>                        
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
