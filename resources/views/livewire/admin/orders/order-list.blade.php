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
            <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 gap-2">
                <div class="d-flex flex-wrap gap-2">
                    <!-- Per Page Select -->
                    <select wire:model.live="perPage" class="form-select form-select-sm" style="width: auto; cursor: pointer;">
                        @foreach ($perpagerecords as $pagekey => $pagevalue)
                            <option value="{{ $pagekey }}">{{ $pagevalue }}</option>
                        @endforeach
                    </select>
            
                    <!-- Status Filter -->
                    <select wire:model.live="statusFilter" class="form-select form-select-sm" style="width: auto; min-width: 130px;">
                        <option value="">All Status</option>
                        <option value="Paid">Paid</option>
                        <option value="Pending">Pending</option>
                        <option value="Cancelled">Cancelled</option>
                    </select>
            
                    <!-- Order Type Filter -->
                    <select wire:model.live="orderTypeFilter" class="form-select form-select-sm" style="width: auto;">
                        <option value="">All Order Types</option>
                        <option value="Online">🌐 Online</option>
                        <option value="Offline">🏬 Offline</option>
                    </select>
            
                    <!-- Payment Mode Filter -->
                    <select wire:model.live="paymentModeFilter" class="form-select form-select-sm" style="width: auto;">
                        <option value="">All Payment Modes</option>
                        <option value="Credit Card">💳 Credit Card</option>
                        <option value="Bank Transfer">🏦 Bank Transfer</option>
                        <option value="Cash">💵 Cash</option>
                    </select>
            
                    <!-- Date Range Picker -->
                    <div class="d-flex gap-2">
                        <div id="reportrange"
                            style="background: #fff; cursor: pointer; border-radius: 6px; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
                            <i class="fa-regular fa-calendar"></i>&nbsp;
                            <span>{{ $dateStart && $dateEnd ? \Carbon\Carbon::parse($dateStart)->format('M d, Y') . ' - ' . \Carbon\Carbon::parse($dateEnd)->format('M d, Y') : 'Select Date Range' }}</span>
                            <i class="fa fa-caret-down"></i>
                        </div>

                        <button id="clearDateRange" class="btn p-0 border-0 bg-transparent" title="Clear Date Range"
                            style="box-shadow: none;">
                            <i class="fa fa-times text-danger"></i>
                        </button>
                    </div>
                </div>
            
                <!-- Search Box -->
                <div>
                    <input type="text" wire:model.live="search" class="form-control form-control-sm" placeholder="Search Orders..." style="width: 150px;">
                </div>
            </div>
            

            @if (session()->has('message'))
                <div class="alert alert-success">{{ session('message') }}</div>
            @endif

            <div class="table-responsive">
                <table class="table text-center">
                    <thead>
                        <tr>
                            <th wire:click="sortBy('order_id')" style="cursor: pointer;"
                                class="{{ $sortField === 'order_id' ? ($sortDirection === 'asc' ? 'text-primary' : 'text-secondary') : '' }}">
                                Order ID
                                @if ($sortField === 'order_id')
                                    <span class="text-mute">{{ $sortDirection === 'asc' ? '▲' : '▼' }}</span>
                                @endif
                            </th>
                            <th wire:click="sortBy('order_type')" style="cursor: pointer;"
                                class="{{ $sortField === 'order_type' ? ($sortDirection === 'asc' ? 'text-primary' : 'text-secondary') : '' }}">
                                Order Type
                                @if ($sortField === 'order_type')
                                    <span class="text-mute">{{ $sortDirection === 'asc' ? '▲' : '▼' }}</span>
                                @endif
                            </th>
                            <th>Customer</th>
                            <th wire:click="sortBy('order_date')" style="cursor: pointer;"
                                class="{{ $sortField === 'order_date' ? ($sortDirection === 'asc' ? 'text-primary' : 'text-secondary') : '' }}">
                                Date
                                @if ($sortField === 'order_date')
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
                            <th wire:click="sortBy('order_status')" style="cursor: pointer;"
                                class="{{ $sortField === 'order_status' ? ($sortDirection === 'asc' ? 'text-primary' : 'text-secondary') : '' }}">
                                Status
                                @if ($sortField === 'order_status')
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
                                @if ($order->parent_order_id === null)
                                    <tr>
                                        <td>#{{ $order->order_id }}</td>
                                        <td class="text-sm fw-medium align-middle">
                                            @if ($order->order_type == 'Online')
                                                <span class="badge bg-primary text-white px-2 py-1 rounded">
                                                    {{ $order->order_type }}
                                                </span>
                                            @else
                                                <span class="badge bg-secondary text-white px-2 py-1 rounded">
                                                    {{ $order->order_type }}
                                                </span>
                                            @endif
                                        </td>                                        
                                        <td>{{ $order->customer->first_name }} {{ $order->customer->last_name }}</td>
                                        <td>{{ \Carbon\Carbon::parse($order->order_date)->format('M d, Y') }}</td>
                                        <td>{{ $order->currency->symbol ?? '$' }} {{ number_format($order->total, 2) }}</td>
                                        <td
                                            class="
                                        text-sm 
                                        font-medium 
                                        items-center 
                                    ">
                                            @if ($order->payment_mode == 'Credit Card')
                                                <span
                                                    class="
                                                bg-orange-50 
                                                text-orange-800 
                                                px-2 
                                                py-1 
                                                rounded-md 
                                            ">
                                                    <span class="mr-1">💳</span> {{ $order->payment_mode }}
                                                </span>
                                            @elseif ($order->payment_mode == 'Bank Transfer')
                                                <span
                                                    class="
                                                bg-green-50 
                                                text-green-800 
                                                px-2 
                                                py-1 
                                                rounded-md
                                            ">
                                                    <span class="mr-1">🏦</span> {{ $order->payment_mode }}
                                                </span>
                                            @elseif ($order->payment_mode == 'Cash')
                                                <span
                                                    class="
                                                bg-blue-50 
                                                text-blue-800 
                                                px-2 
                                                py-1 
                                                rounded-md
                                            ">
                                                    <span class="mr-1">💵</span> {{ $order->payment_mode }}
                                                </span>
                                            @else
                                                <span>{{ $order->payment_mode }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            <select wire:model="orderStatus.{{ $order->order_id }}"
                                                wire:change="updateStatus({{ $order->order_id }})"
                                                @if ($processingStatus === $order->order_id) disabled @endif
                                                class="form-select form-select-sm"
                                                style="color: white; background-color: 
                                            @if ($orderStatus[$order->order_id] === 'Paid') #28c76f 
                                            @elseif ($orderStatus[$order->order_id] === 'Pending') #FF9F43 
                                            @elseif ($orderStatus[$order->order_id] === 'Cancelled') #FF4C51 
                                            @else white; @endif;">
                                                <option value="Paid" style="background-color: white; color: black;">
                                                    @if ($processingStatus === $order->order_id)
                                                        Processing...
                                                    @else
                                                        Paid
                                                    @endif
                                                </option>
                                                <option value="Pending" style="background-color: white; color: black;">
                                                    Pending</option>
                                                <option value="Cancelled"
                                                    style="background-color: white; color: black;">Cancelled</option>
                                            </select>
                                        </td>
                                        <td class="text-center">
                                            <div class="d-flex align-items-center justify-content-center">
                                                {{-- @if ($order->is_generated)
                                                    <button wire:click="downloadInvoice('{{ $order->order_id }}')"
                                                        class="btn btn-sm btn-primary ml-2" data-bs-toggle="tooltip"
                                                        title="Download Invoice">
                                                        <i class="fas fa-download mx-1 px-0 py-0"></i>
                                                    </button>
                                                @else
                                                    <button wire:click="generateInvoice('{{ $order->order_id }}')"
                                                        class="btn btn-sm btn-success ml-2" data-bs-toggle="tooltip"
                                                        title="Generate Invoice">
                                                        <i class="bi bi-file-earmark-plus mx-1"></i> Generate
                                                    </button>
                                                @endif --}}

                                                <a href="{{ route('admin.orders.details', $order->order_id) }}"
                                                    class="text-black ml-1 mr-1 mt-1" data-bs-toggle="tooltip"
                                                    title="View Order" target="_blank">
                                                    <i class="fa fa-eye mx-1"
                                                        style="font-size: 20px; color: rgb(94, 59, 190);"></i>
                                                </a>

                                                {{-- <a href="{{ route('admin.orders.delivery', $order->order_id) }}"
                                                    class="btn btn-sm btn-warning mr-1" data-bs-toggle="tooltip"
                                                    title="Manage DO">
                                                    <i class="bi bi-truck" style="font-size: 14px;"></i>
                                                </a> --}}
                                            </div>
                                        </td>
                                    </tr>
                                @endif
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
</div>

<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function() {
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });

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
