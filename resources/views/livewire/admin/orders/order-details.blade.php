<div class="container-fluid">
    <div class="mb-4 row">
        <div class="mb-4 col-md-12">
            <div class="mt-4 card">
                <div
                    class="card-header sticky-element bg-label-secondary d-flex justify-content-between align-items-center flex-column flex-sm-row">
                    <h5 class="card-title mb-sm-0 me-2">Order Details</h5>
                    <div class="action-btns">
                        <button wire:click="back" class="btn btn-label-primary me-4">
                            <span class="align-middle"> Back</span>
                        </button>
                    </div>
                </div>
                <div class="py-0 pt-4 pr-6 ml-3 card-header">
                    <h5 class="card-title">Order ID #{{ $order->order_id }}</h5>
                </div>
                <div class="card-body">
                    <div class="mb-4 row">
                        <div class="mb-2 col-md-6">
                            <div class="mb-4 card">
                                <div class="card-body">
                                    <h6 class="mb-2">Entity Details:</h6>
                                    <p class="mb-1"><strong>Company:</strong>
                                        {{ $order->entity->company_name }}</p>
                                    <p class="mb-1"><strong>Address:</strong>
                                        {{ $order->entity->address }}</p>
                                    <p class="mb-1"><strong>Country:</strong>
                                        {{ $order->entity->country }}
                                        {{ $order->entity->postal_code }}
                                    </p>
                                    <p class="mb-1"><strong>Reg. No:</strong>
                                        {{ $order->entity->business_reg_number }}</p>
                                    <p class="mb-7"><strong>VAT No:</strong>
                                        {{ $order->entity->vat_number }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="mb-4 col-md-6">
                            <div class="mb-4 card">
                                <div class="card-body">
                                    <h6 class="mb-2">Order Information:</h6>
                                    <p class="mb-1">
                                        Order Date: {{ date('M d, Y', strtotime($order->order_date)) }}
                                        <i class="ml-1 cursor-pointer fas fa-edit text-primary"
                                            wire:click="$set('isEditingOrderDate', true)" data-bs-toggle="modal"
                                            data-bs-target="#editOrderDateModal">
                                        </i>
                                    </p>
                                    <p class="mb-1">Payment Mode: {{ $order->payment_mode }}</p>
                                    <p class="mb-1">Status:
                                        <span
                                            class="badge bg-{{ $order->order_status === 'Paid' ? 'success' : ($order->order_status === 'Pending' ? 'warning' : 'danger') }}">
                                            {{ $order->order_status }}
                                        </span>
                                    </p>
                                    <p class="mb-1">Remarks: {{ $order->remarks }}</p>
                                    <p class="mb-1">Payment Terms: {{ $order->payment_terms }}</p>
                                    <p>Delivery Status:
                                        <span
                                            class="badge bg-{{ $order->delivery_status === 'Delivered'
                                                ? 'success'
                                                : ($order->delivery_status === 'Pending'
                                                    ? 'warning'
                                                    : ($order->delivery_status === 'Shipped'
                                                        ? 'info'
                                                        : 'danger')) }}">
                                            {{ $order->delivery_status }}
                                        </span>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="mb-4 col-md-12">
                            <div class="mb-4 card">
                                <div class="card-body">
                                    <h6 class="mb-2">Customer Details:</h6>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <p class="mb-1">Name: {{ $order->customer->first_name }}
                                                {{ $order->customer->last_name }}
                                            </p>
                                            <p class="mb-1">Type: {{ $order->customer->customerType->customer_type }}
                                            </p>
                                            <p class="mb-1">Email: {{ $order->customer->email }}</p>
                                            <p class="mb-1">Phone: {{ $order->customer->mobile_number }}</p>
                                        </div>
                                        <div class="col-md-4">
                                            <h6>Billing Address:</h6>
                                            <p class="mb-1">
                                                @foreach (explode(',', $order->customer->billing_address) as $line)
                                                    {{ trim($line) }}<br>
                                                @endforeach
                                            </p>
                                        </div>
                                        <div class="col-md-4">
                                            <h6>Shipping Address:</h6>
                                            <p class="mb-1">
                                                @foreach (explode(',', $order->shipping_address) as $line)
                                                    {{ trim($line) }}<br>
                                                @endforeach
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-4 bg-white rounded table-responsive">
                        <table class="table align-middle table-bordered">
                            <thead class="border-2 bg-light border-bottom">
                                <tr>
                                    <th class="text-center">Product</th>
                                    <th class="text-center">Quantity</th>
                                    <th class="text-center">Sample Qty</th>
                                    <th class="text-center">Price</th>
                                    <th class="text-center">Discount</th>
                                    <th class="text-center">Total Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($order->orderDetails as $detail)
                                    <tr>
                                        <td class="text-center">
                                            @if ($detail->product_id == 1)
                                                {{ $detail->manual_product_name }}
                                            @else
                                                {{ $detail->product->product_name }}
                                            @endif
                                        </td>
                                        <td class="text-center">{{ $detail->quantity }}</td>
                                        <td class="text-center">{{ $detail->sample_quantity }}</td>
                                        <td class="text-center">{{ $currencySymbol }}
                                            {{ number_format($detail->unit_price, 2) }}
                                        </td>
                                        <td class="text-center text-danger">
                                            @if ($detail->discount > 0)
                                                - {{ $currencySymbol }} {{ number_format($detail->discount, 2) }}
                                            @else
                                                {{ $currencySymbol }} 0.00
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            {{ $currencySymbol }}
                                            {{ number_format(intval($detail->quantity) * floatval($detail->unit_price) - floatval($detail->discount), 2) }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>


                    <div class="row">
                        <!-- Left Side: Product Section -->
                        <div class="col-md-6">
                            <div class="mt-8">
                                <div class="gap-3 d-flex align-items-center">
                                    <div class="flex-grow-1">
                                        <label for="actual_freight" class="form-label">Actual Freight</label>
                                        <input type="number" step="0.01" wire:model="actual_freight"
                                            id="actual_freight" class="shadow-sm form-control">
                                    </div>
                                    <div>
                                        <button wire:click="updateActualFreight" class="mt-6 btn btn-primary">
                                            Update
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Right Side: Card Section -->
                        <div class="col-md-6">
                            <div class="border shadow-sm card rounded-3">
                                <div class="p-4 card-body">
                                    <div class="mb-2 d-flex justify-content-between align-items-center">
                                        <span class="text-muted">Subtotal:</span>
                                        <span>{{ $currencySymbol }} {{ number_format($order->subtotal, 2) }}</span>
                                    </div>
                                    <div class="mb-2 d-flex justify-content-between align-items-center">
                                        <span class="text-muted">Total Discount:</span>
                                        <span class="text-danger">- {{ $currencySymbol }}
                                            {{ number_format($order->discount, 2) }}</span>
                                    </div>
                                    <div class="mb-2 d-flex justify-content-between align-items-center">
                                        <span class="text-muted">Freight:</span>
                                        <span class="text-success">+ {{ $currencySymbol }}
                                            {{ number_format($order->freight, 2) }}</span>
                                    </div>
                                    <div class="mb-2 d-flex justify-content-between align-items-center">
                                        <span class="text-muted">Tax:</span>
                                        <span class="text-success">+ {{ $currencySymbol }}
                                            {{ number_format($order->tax, 2) }}</span>
                                    </div>
                                    <hr class="my-3">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="mb-0 h6">Total:</span>
                                        <span class="mb-0 h5 fw-semibold">
                                            {{ $order->currency?->code ?? '' }}
                                            {{ $currencySymbol }} {{ number_format($order->total, 2) }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @livewire('admin.orders.order-delivery', ['order_id' => $order_id])
                    @php
                        $invoicesToDisplay = $showSplitInvoices ? $invoices->skip(1) : $invoices;
                    @endphp
                    @if ($invoicesToDisplay->where('invoice_category', 'regular')->count() > 0)
                        <div class="mt-4 card">
                            <div class="card-header">
                                <h5 class="card-title">Invoice Details</h5>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table align-middle table-bordered">
                                        <thead class="border-2 bg-light border-bottom">
                                            <tr>
                                                <th class="text-center">Invoice Number</th>
                                                <th class="text-center">Invoice Date</th>
                                                <th class="text-center">Quantity</th>
                                                <th class="text-center">Remarks</th>
                                                <th class="text-center">Total</th>
                                                <th class="text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($invoicesToDisplay->where('invoice_category', 'regular') as $invoice)
                                                <tr>
                                                    <td class="text-center">{{ $invoice->invoice_number }}</td>
                                                    <td class="text-center">
                                                        {{ date('M d, Y', strtotime($invoice->invoice_date ?? $invoice->created_at)) }}
                                                        <i class="ml-1 cursor-pointer fas fa-edit text-primary"
                                                            wire:click="editInvoiceDate('{{ $invoice->id }}')"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#editInvoiceDateModal">
                                                        </i>
                                                    </td>
                                                    <td class="text-center">
                                                        {{ $invoice->invoiceDetails->sum('quantity') }}
                                                    </td>
                                                    <td class="text-center">{{ $invoice->remarks }}</td>
                                                    <td class="text-center">{{ $currencySymbol }}
                                                        {{ number_format($invoice->total, 2) }}
                                                    </td>
                                                    <td class="text-center">
                                                        @if ($invoice->invoiceDetails->count() > 0)
                                                            <button class="btn btn-success"
                                                                wire:click="downloadInvoice('{{ $invoice->invoiceDetails->first()->id }}', '{{ $invoice->order_id }}')">
                                                                <i class="fas fa-download"></i>
                                                            </button>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @endif
                    @livewire('admin.payment.manage-payment', ['order_id' => $order_id])

                    <div class="mt-4 card">
                        <div class="card-header">
                            <h5 class="card-title">Delivery Order Details</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table align-middle table-bordered">
                                    <thead class="border-2 bg-light border-bottom">
                                        <tr>
                                            <th class="text-center">Delivery Order Number</th>
                                            <th class="text-center">Delivery Date</th>
                                            <th class="text-center">Warehouse Name</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center">Quantity</th>
                                            <th class="text-center">Remarks</th>
                                            <th class="text-center">Tracking Number</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($deliveryOrders as $group)
                                            <tr>
                                                <td class="text-center">{{ $group['delivery_number'] }}</td>
                                                <td class="text-center">
                                                    {{ date('M d, Y', strtotime($group['delivery_date'])) }}
                                                </td>
                                                <td class="text-center">{{ $group['warehouse_name'] }}</td>
                                                <td class="text-center">
                                                    @if ($editingDeliveryId === $group['id'])
                                                        <div class="gap-2 d-flex flex-column">
                                                            <select class="form-select form-select-sm"
                                                                wire:model="editingStatus">
                                                                <option value="Pending">Pending</option>
                                                                <option value="Shipped">Shipped</option>
                                                                <option value="Delivered">Delivered</option>
                                                                <option value="Cancelled">Cancelled</option>
                                                            </select>

                                                            <input type="text" class="form-control form-control-sm"
                                                                wire:model="editingTrackingNumber"
                                                                placeholder="Tracking Number">

                                                            <input type="text" class="form-control form-control-sm"
                                                                wire:model="editingTrackingUrl"
                                                                placeholder="Tracking URL">

                                                            <div class="btn-group">
                                                                <button class="btn btn-primary btn-sm"
                                                                    wire:click="updateDelivery">
                                                                    Save
                                                                </button>
                                                                <button class="btn btn-secondary btn-sm"
                                                                    wire:click="cancelEdit">
                                                                    Cancel
                                                                </button>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <span
                                                            class="badge bg-{{ $group['status'] === 'Delivered' ? 'success' : 'warning' }}">
                                                            {{ $group['status'] }}
                                                        </span>
                                                        <button class="btn btn-sm btn-link"
                                                            wire:click="editDelivery({{ $group['id'] }})">
                                                            Edit
                                                        </button>
                                                    @endif
                                                </td>
                                                <td class="text-center">{{ $group['quantity'] ?? 0 }}</td>
                                                <td class="text-center">{{ $group['remarks'] }}</td>
                                                <td class="text-center">{{ $group['tracking_number'] }}</td>
                                                <td class="text-center">
                                                    <button class="btn btn-primary"
                                                        wire:click="downloadDeliveryOrder({{ $group['id'] }})">
                                                        <i class="fas fa-download"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                            {{-- @foreach ($group['products'] as $product)
                                            <tr>
                                                <td class="text-center">{{ $product['product']->product_name }}
                                                </td>
                                                <td class="text-center">{{ $product['quantity'] }}</td>
                                                <td class="text-center">{{ $product['unit_price'] }}</td>
                                                <td class="text-center">{{ $product['total'] }}</td>
                                            </tr>
                                            @endforeach --}}
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="mt-4 card" @if (!$showSplitInvoices) style="display: none;" @endif>
                        <div class="card-header">
                            <h5 class="card-title">Generate Split Invoices</h5>
                        </div>
                        <div class="card-body">
                            <form wire:submit.prevent="generateInvoices">
                                <div class="row">
                                    @foreach ($order->orderDetails as $index => $detail)
                                        @if ($detail->product->id != 1)
                                            <div class="mb-3 col-md-4">
                                                <label for="quantitySplit_{{ $index }}" class="form-label">
                                                    {{ $detail->product->product_name }} (Remaining Qty:
                                                    {{ $detail->invoice_rem }})
                                                </label>
                                                <input type="number" id="quantitySplit_{{ $index }}"
                                                    wire:model="quantitySplits.{{ $index }}"
                                                    class="form-control" min="0"
                                                    max="{{ $detail->invoice_rem }}" step="1"
                                                    placeholder="Invoice Quantity" />
                                            </div>
                                            <div class="mb-3 col-md-4">
                                                <label for="sampleQuantity_{{ $index }}" class="form-label">
                                                    Sample Quantity
                                                    (Remaining Sample: {{ $detail->invoice_rem_sample }})
                                                </label>
                                                <input type="number" id="sampleQuantity_{{ $index }}"
                                                    wire:model="sampleQuantities.{{ $index }}"
                                                    class="form-control" min="0"
                                                    max="{{ $detail->invoice_rem_sample }}" step="1"
                                                    placeholder="Sample Quantity" />
                                            </div>
                                            <div class="mb-3 col-md-4">
                                                <label for="customPrice_{{ $index }}" class="form-label">
                                                    Price Per Box
                                                </label>
                                                <input type="number" id="customPrice_{{ $index }}"
                                                    wire:model="customUnitPrices.{{ $index }}"
                                                    class="form-control" min="0" step="0.01"
                                                    placeholder="Enter Price per box (optional)" />
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                                <button type="submit" class="btn btn-primary">Generate Invoices</button>
                            </form>
                        </div>
                    </div>
                    @if ($invoicesToDisplay->where('invoice_category', 'shipping')->count() > 0)
                        <div class="mt-4 card">
                            <div class="card-header">
                                <h5 class="card-title">Shipping Invoices  </h5>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table align-middle table-bordered">
                                        <thead class="border-2 bg-light border-bottom">
                                            <tr>
                                                <th class="text-center">Invoice Number</th>
                                                <th class="text-center">Invoice Date</th>
                                                <th class="text-center">Quantity</th>
                                                <th class="text-center">Remarks</th>
                                                <th class="text-center">Total</th>
                                                <th class="text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($invoicesToDisplay->where('invoice_category', 'shipping') as $invoice)
                                                @php
                                                    $shippingTotal = $invoice->invoiceDetails->sum('quantity') * 5;
                                                @endphp
                                                <tr>
                                                    <td class="text-center">{{ $invoice->invoice_number }}</td>
                                                    <td class="text-center">
                                                        {{ date('M d, Y', strtotime($invoice->invoice_date ?? $invoice->created_at)) }}
                                                        <i class="ml-1 cursor-pointer fas fa-edit text-primary"
                                                            wire:click="editInvoiceDate('{{ $invoice->id }}')"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#editInvoiceDateModal">
                                                        </i>
                                                    </td>
                                                    <td class="text-center">
                                                        {{ $invoice->invoiceDetails->sum('quantity') }}
                                                    </td>
                                                    <td class="text-center">{{ $invoice->remarks }}</td>
                                                    <td class="text-center">{{ $currencySymbol }}
                                                        {{ number_format($shippingTotal, 2) }}
                                                    </td>
                                                    <td class="text-center">
                                                        @if ($invoice->invoiceDetails->count() > 0)
                                                            <button class="btn btn-primary"
                                                                wire:click="downloadShippingInvoice('{{ $invoice->invoiceDetails->first()->id }}', '{{ $invoice->order_id }}')">
                                                                <i class="fas fa-download"></i>
                                                            </button>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <!-- Order Date Edit Modal -->
        <div class="modal fade" id="editOrderDateModal" wire:ignore.self tabindex="-1"
            aria-labelledby="editOrderDateModalLabel">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editOrderDateModalLabel">Edit Order Date</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="editedOrderDate">Order Date</label>
                            <input type="date" class="form-control" id="editedOrderDate"
                                wire:model.defer="editedOrderDate">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary" wire:click="updateOrderDate">Save
                            Changes</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Invoice Date Edit Modal -->
        <div class="modal fade" id="editInvoiceDateModal" wire:ignore.self tabindex="-1"
            aria-labelledby="editInvoiceDateModalLabel">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editInvoiceDateModalLabel">Edit Invoice Date</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="editedInvoiceDate">Invoice Date</label>
                            <input type="date" class="form-control" id="editedInvoiceDate"
                                wire:model.defer="editedInvoiceDate">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary" wire:click="updateInvoiceDate">Save
                            Changes</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
