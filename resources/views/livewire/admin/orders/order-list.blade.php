<div class="container-xxl flex-grow-1 container-p-y">
    <div
        class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 row-gap-4">
        <div class="d-flex flex-column justify-content-center">
            <h4 class="mb-1 text-2xl ml-2">Orders List</h4>
        </div>
        <div class="d-flex align-content-center flex-wrap gap-4">
            <div class="d-flex gap-4">
                <div class="btn-group"><button
                        class="btn btn-secondary buttons-collection dropdown-toggle btn-label-secondary me-4 waves-effect waves-light"
                        tabindex="0" aria-controls="DataTables_Table_0" type="button" aria-haspopup="dialog"
                        aria-expanded="false"><span><i class="ti ti-upload me-1 ti-xs"></i>Export</span></button>
                </div>
            </div>
            <a href="{{ route('admin.orders.add') }}" class="btn btn-primary">
                <i class="ti ti-plus ti-xs me-md-2"></i>Add Order
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <select wire:model.live="perPage" class="form-select me-2" style="width: auto;">
                        @foreach ($perpagerecords as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="d-flex align-items-center">
                    <input type="text" wire:model.live="search" placeholder="Search Orders..."
                        class="form-control me-2" style="width: auto;" />
                </div>
            </div>

            @if (session()->has('message'))
                <div class="alert alert-success">{{ session('message') }}</div>
            @endif

            <div class="table-responsive">
                <table class="table text-center">
                    <thead>
                        <tr>
                            <th wire:click="sortBy('invoice_id')" style="cursor: pointer;"
                                class="{{ $sortField === 'invoice_id' ? ($sortDirection === 'asc' ? 'text-primary' : 'text-secondary') : '' }}">
                                Order ID
                                @if ($sortField === 'invoice_id')
                                    <span class="text-muted">{{ $sortDirection === 'asc' ? '▲' : '▼' }}</span>
                                @endif
                            </th>
                            <th>Customer</th>
                            <th wire:click="sortBy('invoice_date')" style="cursor: pointer;"
                                class="{{ $sortField === 'invoice_date' ? ($sortDirection === 'asc' ? 'text-primary' : 'text-secondary') : '' }}">
                                Date
                                @if ($sortField === 'invoice_date')
                                    <span class="text-muted">{{ $sortDirection === 'asc' ? '▲' : '▼' }}</span>
                                @endif
                            </th>
                            <th wire:click="sortBy('total')" style="cursor: pointer;"
                                class="{{ $sortField === 'total' ? ($sortDirection === 'asc' ? 'text-primary' : 'text-secondary') : '' }}">
                                Total
                                @if ($sortField === 'total')
                                    <span class="text-muted">{{ $sortDirection === 'asc' ? '▲' : '▼' }}</span>
                                @endif
                            </th>
                            <th wire:click="sortBy('payment_mode')" style="cursor: pointer;"
                                class="{{ $sortField === 'payment_mode' ? ($sortDirection === 'asc' ? 'text-primary' : 'text-secondary') : '' }}">
                                Payment Mode
                                @if ($sortField === 'payment_mode')
                                    <span class="text-muted">{{ $sortDirection === 'asc' ? '▲' : '▼' }}</span>
                                @endif
                            </th>
                            <th wire:click="sortBy('invoice_status')" style="cursor: pointer;"
                                class="{{ $sortField === 'invoice_status' ? ($sortDirection === 'asc' ? 'text-primary' : 'text-secondary') : '' }}">
                                Status
                                @if ($sortField === 'invoice_status')
                                    <span class="text-muted">{{ $sortDirection === 'asc' ? '▲' : '▼' }}</span>
                                @endif
                            </th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($orders->isEmpty())
                            <tr>
                                <td colspan="7" class="text-center">No orders found.</td>
                            </tr>
                        @else
                            @foreach ($orders as $order)
                                <tr>
                                    <td>#{{ $order->invoice_id }}</td>
                                    <td>{{ $order->customer->first_name }} {{ $order->customer->last_name }}</td>
                                    <td>{{ \Carbon\Carbon::parse($order->invoice_date)->format('M d, Y') }}</td>
                                    <td>${{ number_format($order->total, 2) }}</td>
                                    <td>{{ $order->payment_mode }}</td>
                                    <td>
                                        <select wire:model="orderStatus.{{ $order->invoice_id }}"
                                            wire:change="updateStatus({{ $order->invoice_id }})"
                                            @if ($processingStatus === $order->invoice_id) disabled @endif
                                            class="form-select form-select-sm"
                                            style="color: white; 
                                                       background-color: 
                                                       @if ($orderStatus[$order->invoice_id] === 'Paid') #28c76f 
                                                       @elseif ($orderStatus[$order->invoice_id] === 'Pending') #FF9F43 
                                                       @elseif ($orderStatus[$order->invoice_id] === 'Cancelled') #FF4C51 
                                                       @else white; @endif;">
                                            <option value="Paid" style="background-color: white; color: black;">
                                                @if ($processingStatus === $order->invoice_id)
                                                    Processing...
                                                @else
                                                    Paid
                                                @endif
                                            </option>
                                            <option value="Pending" style="background-color: white; color: black;">
                                                Pending</option>
                                            <option value="Cancelled" style="background-color: white; color: black;">
                                                Cancelled</option>
                                        </select>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <!-- Dropdown -->
                                            <div class="dropdown">
                                                <button class="btn btn-link text-black" type="button"
                                                    id="actionMenu{{ $order->id }}" data-bs-toggle="dropdown"
                                                    aria-expanded="false">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                        fill="currentColor" style="width: 20px; height: 20px;">
                                                        <circle cx="12" cy="12" r="2" />
                                                        <circle cx="12" cy="6" r="2" />
                                                        <circle cx="12" cy="18" r="2" />
                                                    </svg>
                                                </button>
                                                <ul class="dropdown-menu" aria-labelledby="actionMenu{{ $order->id }}">
                                                    {{-- <li>
                                                        <a class="dropdown-item"
                                                            wire:click="viewOrderDetails('{{ $order->invoice_id }}')"
                                                            href="#" style="cursor: pointer;">
                                                            View
                                                        </a>
                                                    </li> --}}
                                                    <li>
                                                        <a class="dropdown-item"
                                                            wire:click="downloadInvoice('{{ $order->invoice_id }}')"
                                                            href="#" style="cursor: pointer;">
                                                            Download Invoice
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                            <!-- View Icon in Line -->
                                            <a href="#" wire:click="viewOrderDetails('{{ $order->invoice_id }}')" style="cursor: pointer; display: flex; align-items: center; margin-left: 10px;">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" style="width: 20px; height: 20px;">
                                                    <path d="M12 4C7.03 4 3 8 3 8s4 4 9 4 9-4 9-4-4-4-9-4zm0 6c-2.21 0-4-1.79-4-4s1.79-4 4-4 4 1.79 4 4-1.79 4-4 4zm0 0"></path>
                                                </svg>
                                            </a>
                                        </div>
                                    </td>
                                    
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
                <div class="mt-3">
                    {{ $orders->links() }}
                </div>
            </div>
        </div>
    </div>

    @if ($viewOrder)
        <div class="modal-backdrop fade show"></div>
        <div class="modal fade show" id="orderDetailsModal" tabindex="-1" aria-labelledby="orderDetailsModalLabel"
            aria-hidden="true" style="display: block;">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
                <div class="modal-content rounded-3">
                    <div class="modal-header">
                        <h5 class="modal-title" id="orderDetailsModalLabel">Order Details
                            #{{ $selectedOrder->invoice_id }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" wire:click="closeModal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row mb-4">
                            <div class="col-md-12 mb-4">
                                <div class="card">
                                    <div class="card-body">
                                        <h6 class="mb-2">Entity Details:</h6>
                                        <p class="mb-1"><strong>Company:</strong>
                                            {{ $selectedOrder->entity->company_name }}</p>
                                        <p class="mb-1"><strong>Address:</strong>
                                            {{ $selectedOrder->entity->address }}</p>
                                        <p class="mb-1"><strong>Country:</strong>
                                            {{ $selectedOrder->entity->country }}
                                            {{ $selectedOrder->entity->postal_code }}</p>
                                        <p class="mb-1"><strong>Reg. No:</strong>
                                            {{ $selectedOrder->entity->business_reg_number }}</p>
                                        <p class="mb-1"><strong>VAT No:</strong>
                                            {{ $selectedOrder->entity->vat_number }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <h6 class="mb-2">Customer Details:</h6>
                                <p class="mb-1">Name: {{ $selectedOrder->customer->first_name }}
                                    {{ $selectedOrder->customer->last_name }}</p>
                                <p class="mb-1">Email: {{ $selectedOrder->customer->email }}</p>
                                <p class="mb-1">Shipping Address: {{ $selectedOrder->shipping_address }}</p>
                            </div>
                            <div class="col-md-6">
                                <h6 class="mb-2">Order Information:</h6>
                                <p class="mb-1">Order Date:
                                    {{ date('M d, Y', strtotime($selectedOrder->invoice_date)) }}</p>
                                <p class="mb-1">Payment Mode: {{ $selectedOrder->payment_mode }}</p>
                                <p class="mb-1">Status:
                                    <span
                                        class="badge bg-{{ $selectedOrder->invoice_status === 'Paid' ? 'success' : ($selectedOrder->invoice_status === 'Pending' ? 'warning' : 'danger') }}">
                                        {{ $selectedOrder->invoice_status }}
                                    </span>
                                </p>
                                <p class="mb-1">Remarks: {{ $selectedOrder->remarks }}</p>
                                <p class="mb-1">Payment Terms: {{ $selectedOrder->payment_terms }}</p>
                                <p class="mb-1">Delivery Status:
                                    <span
                                        class="badge bg-{{ $selectedOrder->delivery_status === 'Delivered'
                                            ? 'success'
                                            : ($selectedOrder->delivery_status === 'Pending'
                                                ? 'warning'
                                                : ($selectedOrder->delivery_status === 'Shipped'
                                                    ? 'info'
                                                    : 'danger')) }}">
                                        {{ $selectedOrder->delivery_status }}
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
                                    @foreach ($selectedOrder->orderDetails as $detail)
                                        <tr>
                                            <td class="text-center">{{ $detail->product->product_name }}</td>
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
                                            <span>${{ number_format($selectedOrder->subtotal, 2) }}</span>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <span class="text-muted">Total Discount:</span>
                                            <span
                                                class="text-danger">-${{ number_format($selectedOrder->discount, 2) }}</span>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <span class="text-muted">Tax:</span>
                                            <span
                                                class="text-success">+${{ number_format($selectedOrder->tax, 2) }}</span>
                                        </div>
                                        <hr class="my-3">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="h6 mb-0">Total:</span>
                                            <span
                                                class="h5 mb-0 fw-semibold">${{ number_format($selectedOrder->total, 2) }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary"
                            wire:click="downloadInvoice('{{ $selectedOrder->invoice_id }}')">
                            Download Invoice
                        </button>
                        <button type="button" class="btn btn-secondary" wire:click="closeModal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
