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
                <div class="d-flex gap-2">
                    <!-- Per Page Select -->
                    <select wire:model.live="perPage" class="form-select" style="cursor: pointer; width: auto;">
                        @foreach ($perpagerecords as $pagekey => $pagevalue)
                            <option value="{{ $pagekey }}">{{ $pagevalue }}</option>
                        @endforeach
                    </select>

                    <!-- Status Filter -->
                    <select wire:model.live="statusFilter" class="form-select" style="cursor: pointer; width: auto; min-width: 120px;">
                        <option value="">All Status</option>
                        <option value="Paid">Paid</option>
                        <option value="Pending">Pending</option>
                        <option value="Cancelled">Cancelled</option>
                    </select>

                    <!-- Payment Mode Filter -->
                    <select wire:model.live="paymentModeFilter" class="form-select" style="cursor: pointer; width: auto;">
                        <option value="">All Payment Modes</option>
                        <option value="Credit Card">Credit Card</option>
                        <option value="Bank Transfer">Bank Transfer</option>
                        <option value="Cash">Cash</option>
                    </select>

                    <!-- Date Range Picker -->
                    <div class="d-flex gap-2">
                        <div id="reportrange"
                            style="background: #fff; cursor: pointer; border-radius: 6px; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
                            <i class="fa-regular fa-calendar"></i>&nbsp;
                            <span>{{ $dateStart && $dateEnd ? \Carbon\Carbon::parse($dateStart)->format('M d, Y') . ' - ' . \Carbon\Carbon::parse($dateEnd)->format('M d, Y') : 'Select Date Range' }}</span>
                            <i class="fa fa-caret-down"></i>
                        </div>

                        <button id="clearDateRange" class="btn p-0 border-0 bg-transparent" title="Clear Date Range" style="box-shadow: none;">
                            <i class="fa fa-times text-danger"></i>
                        </button>
                    </div>
                </div>

                <div class="d-flex align-items-center">
                    <input type="text" wire:model.live="search" placeholder="Search Orders..." class="form-control"
                        style="width: auto;" />
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
                                    <!-- Action dropdown on the left -->
                                    <td class="text-center">
                                        <div class="d-flex align-items-center justify-content-center">
                                            @if ($order->is_generated)
                                                <button wire:click="downloadInvoice('{{ $order->invoice_id }}')"
                                                    class="btn btn-sm btn-primary mx-2">
                                                    <i class="bi bi-download mr-1"></i> Download
                                                </button>
                                            @else
                                                <button wire:click="generateInvoice('{{ $order->invoice_id }}')"
                                                    class="btn btn-sm btn-success mx-2">
                                                    <i class="bi bi-file-earmark-plus mr-1"></i> Generate
                                                </button>
                                            @endif

                                            <a href="{{ route('admin.orders.details', $order->invoice_id) }}"
                                                class="text-black ml-1 mt-1" title="View Order" target="_blank">
                                                <i class="fa fa-eye" style="font-size: 20px; color: #7367f0;"></i>
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

<script type="text/javascript">
    document.addEventListener('livewire:initialized', () => {
        // Make sure moment.js and daterangepicker are loaded
        if (typeof moment === 'undefined') {
            console.error('Moment.js is not loaded');
            return;
        }

        // Initialize the date range values
        let start = moment().subtract(29, 'days');
        let end = moment();

        // If there are existing values, use them
        if (@json($dateStart)) {
            start = moment(@json($dateStart));
        }
        if (@json($dateEnd)) {
            end = moment(@json($dateEnd));
        }

        // Callback function when dates are selected
        function updateDisplay(start, end) {
            $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
            @this.set('dateStart', start.format('YYYY-MM-DD'));
            @this.set('dateEnd', end.format('YYYY-MM-DD'));
        }

        // Initialize daterangepicker
        $('#reportrange').daterangepicker({
            startDate: start,
            endDate: end,
            ranges: {
                'Today': [moment(), moment()],
                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1,
                    'month').endOf('month')]
            }
        }, updateDisplay);

        // Show initial dates if they exist
        if (@json($dateStart) && @json($dateEnd)) {
            updateDisplay(start, end);
        }

        // Handle the apply event
        $('#reportrange').on('apply.daterangepicker', function(ev, picker) {
            updateDisplay(picker.startDate, picker.endDate);
        });

        // Handle the clear button
        $('#clearDateRange').on('click', function(e) {
            e.preventDefault();
            $('#reportrange span').html('Select Date Range');
            @this.set('dateStart', null);
            @this.set('dateEnd', null);
        });

        // Listen for Livewire updates
        Livewire.on('dateRangeUpdated', () => {
            if (@json($dateStart) && @json($dateEnd)) {
                let newStart = moment(@json($dateStart));
                let newEnd = moment(@json($dateEnd));
                $('#reportrange').data('daterangepicker').setStartDate(newStart);
                $('#reportrange').data('daterangepicker').setEndDate(newEnd);
                updateDisplay(newStart, newEnd);
            }
        });
    });
</script>
