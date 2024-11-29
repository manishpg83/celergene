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
                                            @if($detail->product_id == 1)
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
                        <div class="col-md-6 ms-auto">
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
                </div>
            </div>
        </div>
    </div>
</div>
