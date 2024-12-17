<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-12 mb-4">
            <div class="card mt-4">
                <div
                    class="card-header sticky-element bg-label-secondary d-flex justify-content-between align-items-center flex-column flex-sm-row">
                    <h5 class="card-title mb-sm-0 me-2">Order Details</h5>
                    <div class="action-btns">
                        <button wire:click="back" class="btn btn-label-primary me-4">
                            <span class="align-middle"> Back</span>
                        </button>
                    </div>
                </div>
                <div class="card-header pr-6 py-0 pt-4 ml-3">
                    <h5 class="card-title">Order ID #{{ $order->order_id }}</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-12 mb-4">
                            <div class="card mb-4">
                                <div class="card-body">
                                    <h6 class="mb-2">Entity Details:</h6>
                                    <p class="mb-1"><strong>Company:</strong>
                                        {{ $order->entity->company_name }}</p>
                                    <p class="mb-1"><strong>Address:</strong>
                                        {{ $order->entity->address }}</p>
                                    <p class="mb-1"><strong>Country:</strong>
                                        {{ $order->entity->country }}
                                        {{ $order->entity->postal_code }}</p>
                                    <p class="mb-1"><strong>Reg. No:</strong>
                                        {{ $order->entity->business_reg_number }}</p>
                                    <p class="mb-1"><strong>VAT No:</strong>
                                        {{ $order->entity->vat_number }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <h6 class="mb-2">Customer Details:</h6>
                            <p class="mb-1">Name: {{ $order->customer->first_name }}
                                {{ $order->customer->last_name }}</p>
                            <p class="mb-1">Email: {{ $order->customer->email }}</p>
                            <p class="mb-1">Shipping Address: {{ $order->shipping_address }}</p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="mb-2">Order Information:</h6>
                            <p class="mb-1">Order Date:
                                {{ date('M d, Y', strtotime($order->order_date)) }}</p>
                            <p class="mb-1">Payment Mode: {{ $order->payment_mode }}</p>
                            <p class="mb-1">Status:
                                <span
                                    class="badge bg-{{ $order->order_status === 'Paid' ? 'success' : ($order->order_status === 'Pending' ? 'warning' : 'danger') }}">
                                    {{ $order->order_status }}
                                </span>
                            </p>
                            <p class="mb-1">Remarks: {{ $order->remarks }}</p>
                            <p class="mb-1">Payment Terms: {{ $order->payment_terms }}</p>
                            <p class="mb-1">Delivery Status:
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

                    <div class="table-responsive mb-4 bg-white rounded">
                        <table class="table table-bordered align-middle">
                            <thead class="bg-light border-bottom border-2">
                                <tr>
                                    <th class="text-center">Product</th>
                                    <th class="text-center">Quantity</th>
                                    <th class="text-center">Price</th>
                                    <th class="text-center">Discount</th>
                                    <th class="text-center">Total Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($order->orderDetails as $detail)
                                    <tr>
                                        <td>
                                            @if ($detail->product_id == 1)
                                                {{ $detail->manual_product_name }}
                                            @else
                                                {{ $detail->product->product_name }}
                                            @endif
                                        </td>
                                        <td class="text-center">{{ $detail->quantity }}</td>
                                        <td class="text-center">${{ number_format($detail->unit_price, 2) }}</td>
                                        <td class="text-danger text-center">
                                            @if ($detail->discount > 0)
                                                -${{ number_format($detail->discount, 2) }}
                                            @else
                                                $0.00
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            ${{ number_format($detail->quantity * $detail->unit_price - $detail->discount, 2) }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="row">
                        <!-- Left Side: Product Section -->
                        <div class="col-md-6">
                            <div class="mt-32">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="flex-grow-1">
                                        <label for="actual_freight" class="form-label">Actual Freight</label>
                                        <input 
                                            type="number" 
                                            step="0.01" 
                                            wire:model="actual_freight" 
                                            id="actual_freight"
                                            class="form-control shadow-sm"
                                        >
                                    </div>
                                    <div>
                                        <button 
                                            wire:click="updateActualFreight" 
                                            class="btn btn-primary mt-6"
                                        >
                                            Update
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    
                        <!-- Right Side: Card Section -->
                        <div class="col-md-6">
                            <div class="card rounded-3 shadow-sm border">
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span class="text-muted">Subtotal:</span>
                                        <span>${{ number_format($order->subtotal, 2) }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span class="text-muted">Total Discount:</span>
                                        <span class="text-danger">-${{ number_format($order->discount, 2) }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span class="text-muted">Freight:</span>
                                        <span class="text-success">+${{ number_format($order->freight, 2) }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span class="text-muted">Tax:</span>
                                        <span class="text-success">+${{ number_format($order->tax, 2) }}</span>
                                    </div>
                                    <hr class="my-3">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="h6 mb-0">Total:</span>
                                        <span class="h5 mb-0 fw-semibold">${{ number_format($order->total, 2) }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card mt-4">
                        <div class="card-header">
                            <h5 class="card-title">Invoice Details</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered align-middle">
                                    <thead class="bg-light border-bottom border-2">
                                        <tr>
                                            <th class="text-center">Invoice Number</th>
                                            <th class="text-center">Invoice Date</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center">Remarks</th>
                                            <th class="text-center">Total</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($invoices as $invoice)
                                            <tr>
                                                <td class="text-center">{{ $invoice->invoice_number }}</td>
                                                <td class="text-center">
                                                    {{ date('M d, Y', strtotime($invoice->created_at)) }}
                                                </td>
                                                <td class="text-center">
                                                    <span class="badge bg-{{ $invoice->status === 'Confirmed' ? 'success' : ($invoice->status === 'Draft' ? 'warning' : 'danger') }}">
                                                        {{ $invoice->status }}
                                                    </span>
                                                </td>
                                                <td class="text-center">{{ $invoice->remarks }}</td>
                                                <td class="text-center">${{ number_format($invoice->total, 2) }}</td>
                                                <td class="text-center">
                                                    @if ($invoice->invoiceDetails->count() > 0)
                                                        <button class="btn btn-success" wire:click="downloadInvoice({{ $invoice->invoiceDetails->first()->id }})">
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

                    <div class="card mt-4">
                        <div class="card-header">
                            <h5 class="card-title">Delivery Details</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered align-middle">
                                    <thead class="bg-light border-bottom border-2">
                                        <tr>
                                            <th class="text-center">Delivery Order Number</th>
                                            <th class="text-center">Delivery Date</th>
                                            <th class="text-center">Warehouse Name</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center">Quantity</th>
                                            <th class="text-center">Remarks</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($deliveryOrders as $deliveryOrder)
                                            <tr>
                                                <td class="text-center">{{ $deliveryOrder->delivery_number }}</td>
                                                <td class="text-center">
                                                    {{ date('M d, Y', strtotime($deliveryOrder->delivery_date)) }}
                                                </td>
                                                <td class="text-center">{{ $deliveryOrder->warehouse->warehouse_name }}</td>
                                                <td class="text-center">
                                                    <span class="badge bg-{{ $deliveryOrder->status === 'Delivered' ? 'success' : 'warning' }}">
                                                        {{ $deliveryOrder->status }}
                                                    </span>
                                                </td>
                                                <td class="text-center">
                                                    {{ $deliveryOrder->details->sum('quantity') ?? 0 }}
                                                </td>
                                                <td class="text-center">{{ $deliveryOrder->remarks }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card mt-4">
                        <div class="card-header">
                            <h5 class="card-title">Generate Split Invoices</h5>
                        </div>
                        <div class="card-body">
                            <form wire:submit.prevent="generateInvoices">
                                @foreach ($order->orderDetails as $index => $detail)
                                    <div class="mb-3">
                                        <label for="quantitySplit_{{ $index }}" class="form-label">
                                            {{ $detail->product->product_name }} (Remaining Qty:
                                            {{ $detail->invoice_rem }})
                                        </label>
                                        <input type="number" id="quantitySplit_{{ $index }}"
                                            wire:model="quantitySplits.{{ $index }}" class="form-control"
                                            min="0" max="{{ $detail->invoice_rem }}" step="1" />

                                    </div>
                                @endforeach
                                <button type="submit" class="btn btn-primary">Generate Invoices</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
