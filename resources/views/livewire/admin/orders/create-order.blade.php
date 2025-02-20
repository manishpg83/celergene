<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div
                    class="card-header sticky-element bg-label-secondary d-flex justify-content-between align-items-center flex-column flex-sm-row">
                    <h5 class="card-title mb-sm-0 me-2">Create Order</h5>
                    <div class="action-btns">
                        <button wire:click="back" class="btn btn-label-primary me-4">
                            <span class="align-middle"> Back</span>
                        </button>
                    </div>
                </div>

                <div class="card-body">
                    <form wire:submit.prevent="submitOrder">
                        <div class="row g-3 mt-0">
                            <div class="col-md-6">
                                <label for="entity" class="form-label">Select Entity:</label>
                                <select wire:model="entity_id" id="entity"
                                    class="form-select @error('entity_id') is-invalid @enderror">
                                    <option value="">Select an entity</option>
                                    @foreach ($entities as $entity)
                                        <option value="{{ $entity->id }}">{{ $entity->company_name }}</option>
                                    @endforeach
                                </select>
                                @error('entity_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="customer" class="form-label">Select Customer:</label>
                                <select wire:model.live="customer_id" id="customer"
                                    class="form-select @error('customer_id') is-invalid @enderror">
                                    <option value="">Select a customer</option>
                                    @foreach ($customers as $customer)
                                        <option value="{{ $customer->id }}">{{ $customer->first_name }}
                                            {{ $customer->last_name }}</option>
                                    @endforeach
                                </select>
                                @error('customer_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="workflow_type" class="form-label">Order Type:</label>
                                <select wire:model="workflow_type" id="workflow_type"
                                    class="form-select @error('workflow_type') is-invalid @enderror">
                                    @foreach (\App\Enums\OrderWorkflowType::options() as $value => $label)
                                        <option value="{{ $value }}">{{ $label }}</option>
                                    @endforeach
                                </select>
                                @error('workflow_type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            @if ($customer_id)
                                <div class="col-md-6">
                                    <label for="selected_shipping_address" class="form-label">Select Shipping
                                        Address:</label>
                                    <select wire:model.live="selected_shipping_address" id="selected_shipping_address"
                                        class="form-select @error('selected_shipping_address') is-invalid @enderror">
                                        @foreach ($shipping_addresses as $key => $address)
                                            @if ($address)
                                                <option value="{{ $key }}">Address {{ $key }}
                                                </option>
                                            @endif
                                        @endforeach
                                    </select>
                                    @error('selected_shipping_address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-12">
                                    <label for="shipping_address" class="form-label">Shipping Address:</label>
                                    <input type="text" wire:model="shipping_address" id="shipping_address"
                                        class="form-control @error('shipping_address') is-invalid @enderror" readonly>
                                    @error('shipping_address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            @endif
                        </div>

                        <div class="row g-3 mt-4">
                            <div class="col-md-6">
                                <label for="payment_mode" class="form-label">Payment Mode:</label>
                                <select wire:model="payment_mode" id="payment_mode"
                                    class="form-select @error('payment_mode') is-invalid @enderror">
                                    <option value="Bank Transfer">Bank Transfer</option>
                                    <option value="Credit Card">Credit Card</option>
                                    <option value="Cash">Cash</option>
                                </select>
                                @error('payment_mode')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="order_date" class="form-label">Invoice Date:</label>
                                <input type="date" wire:model="order_date" id="order_date"
                                    min="{{ now()->format('Y-m-d') }}"
                                    class="form-control @error('order_date') is-invalid @enderror">
                                @error('order_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>

                        <div class="row g-3 mt-4 mb-4">
                            <div class="col-md-6">
                                <label for="delivery_status" class="form-label">Delivery Status:</label>
                                <select wire:model="delivery_status" id="delivery_status"
                                    class="form-select @error('delivery_status') is-invalid @enderror">
                                    <option value="Pending">Pending</option>
                                    <option value="Shipped">Shipped</option>
                                    <option value="Delivered">Delivered</option>
                                    <option value="Cancelled">Cancelled</option>
                                </select>
                                @error('delivery_status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
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
                        </div>
                        <hr>
                        <div class="row g-3 mt-2">
                            <div class="col-12">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h5>Order Details</h5>
                                    <div style="width: 250px">
                                        <select wire:model.live="currency_id"
                                            class="form-select @error('currency_id') is-invalid @enderror">
                                            <option value="">Select Currency</option>
                                            @foreach ($currencies as $currency)
                                                <option value="{{ $currency->id }}">{{ $currency->name }}
                                                    ({{ $currency->symbol }})</option>
                                            @endforeach
                                        </select>
                                        @error('currency_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                @foreach ($orderDetails as $index => $orderDetail)
                                    <div class="row align-items-end mt-0 g-2">
                                        <div class="col-md-3">
                                            <select wire:model.live="orderDetails.{{ $index }}.product_id"
                                                class="form-select @error('orderDetails.' . $index . '.product_id') is-invalid @enderror">
                                                <option value="">Select a product</option>
                                                @foreach ($this->getAvailableProducts($index) as $product)
                                                    <option value="{{ $product->id }}">{{ $product->product_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('orderDetails.' . $index . '.product')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-3">
                                            <div class="col-12">Custom Name & Desc</div>
                                            <input type="text"
                                                wire:model="orderDetails.{{ $index }}.manual_product_name"
                                                placeholder="Custom Name & Desc"
                                                class="form-control @error('orderDetails.' . $index . '.manual_product_name') is-invalid @enderror">
                                            @error("orderDetails.{$index}.manual_product_name")
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-2" >
                                            <div class="col-6 mb-1">
                                                Quantity
                                                @if (isset($orderDetails[$index]['product_id']) && $orderDetails[$index]['product_id'] != 1)
                                                    <small style="color: green;">
                                                        (Avl:
                                                        {{ $this->getAvailableQuantity($orderDetails[$index]['product_id']) }})
                                                    </small>
                                                @endif
                                            </div>
                                            <input type="number"
                                                wire:model.lazy="orderDetails.{{ $index }}.quantity"
                                                placeholder="Quantity"
                                                class="form-control @error('orderDetails.' . $index . '.quantity') is-invalid @enderror"
                                                min="1">
                                            @error('orderDetails.' . $index . '.quantity')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-2" style="width: 147px">
                                            <div class="col-6 mb-1" style="width: 80%;">Sample Quantity</div>
                                            <input type="number"
                                                wire:model.lazy="orderDetails.{{ $index }}.sample_quantity"
                                                placeholder="Sample Quantity"
                                                class="form-control @error('orderDetails.' . $index . '.sample_quantity') is-invalid @enderror">
                                            @error('orderDetails.' . $index . '.sample_quantity')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-2" style="width: 100px">
                                            <div class="col-7 mb-1">Price</div>
                                            <input type="number"
                                                wire:model.lazy="orderDetails.{{ $index }}.unit_price"
                                                placeholder="Price" class="form-control">
                                        </div>

                                        <div class="col-md-1 mb-1">
                                            <button wire:click.prevent="removeOrderDetail({{ $index }})"
                                                class="btn btn-danger btn-sm">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                @endforeach

                                <button wire:click.prevent="addOrderDetail" class="btn btn-primary mt-3">+ Add
                                    Item</button>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-md-6 ms-auto">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row mb-2">
                                            <div class="col-6">Subtotal:</div>
                                            <div class="col-6 text-end">{{ $currency_symbol }}
                                                {{ number_format($subtotal, 2) }}</div>
                                        </div>
                                        {{-- <div class="row mb-2">
                                            <div class="col-6">Discount:</div>
                                            <div class="col-6 text-end text-danger">
                                                -${{ number_format($totalDiscount, 2) }}</div>
                                        </div> --}}
                                        <div class="row mb-2">
                                            <div class="col-6">Freight:</div>
                                            <div class="col-6">
                                                <div class="input-group">
                                                    <span class="input-group-text">{{ $currency_symbol }}</span>
                                                    <input type="number" wire:model.lazy="freight"
                                                        class="form-control" min="0" step="0.01"
                                                        value="0">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col-6">Tax:</div>
                                            <div class="col-6">
                                                <div class="input-group">
                                                    <span class="input-group-text">{{ $currency_symbol }}</span>
                                                    <input type="number" wire:model.lazy="tax" class="form-control"
                                                        min="0" step="0.01" value="0">
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row mt-2">
                                            <div class="col-6"><strong>Total:</strong></div>
                                            <div class="col-6 text-end">
                                                <strong>{{ $currency_symbol }} {{ number_format($total, 2) }}</strong>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row g-3 mt-4">
                            <div class="col-md-6">
                                <label for="payment_terms" class="form-label">Payment Terms:</label>
                                <textarea wire:model="payment_terms" id="payment_terms"
                                    class="form-control @error('payment_terms') is-invalid @enderror"></textarea>
                                @error('payment_terms')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="remarks" class="form-label">Remarks:</label>
                                <textarea wire:model="remarks" id="remarks" class="form-control @error('remarks') is-invalid @enderror"></textarea>
                                @error('remarks')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="actual_freight" class="form-label">Actual Freight:</label>
                                <input type="number" step="0.01" wire:model="actual_freight" id="actual_freight"
                                    class="form-control @error('actual_freight') is-invalid @enderror" />
                                @error('actual_freight')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="d-flex justify-content-end mt-4">
                            <button type="submit" class="btn btn-success d-flex align-items-center gap-2"
                                wire:loading.attr="disabled" wire:target="submitOrder">
                                @if ($isSubmitting)
                                    <div class="spinner-border spinner-border-sm" role="status">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>
                                    <span>Processing...</span>
                                @else
                                    <span>Submit Order</span>
                                @endif
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        $('#customer').select2({
            placeholder: 'Search for a customer...',
            allowClear: true
        });

        $('#customer').on('change', function() {
            var customerId = $(this).val();
            @this.set('customer_id', customerId);
        });
    });
</script>
