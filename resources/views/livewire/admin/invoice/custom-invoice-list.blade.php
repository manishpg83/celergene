<div class="container-xxl flex-grow-1 container-p-y">
    <div
        class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 row-gap-4">
        <div class="d-flex flex-column justify-content-center">
            <h4 class="mb-1 text-2xl ml-2">Invoice List</h4>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="d-flex gap-2">
                    <select wire:model.live="perPage" class="form-select" style="width: auto;">
                        @foreach ($perpagerecords as $pagekey => $pagevalue)
                            <option value="{{ $pagekey }}">{{ $pagevalue }}</option>
                        @endforeach
                    </select>

                    <div id="reportrange"
                        style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
                        <i class="fa fa-calendar"></i>&nbsp;
                        <span>Select Date Range</span> <i class="fa fa-caret-down"></i>
                    </div>
                </div>

                <div class="d-flex align-items-center">
                    <input type="text" wire:model.live="search" placeholder="Search Invoice..." class="form-control"
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
                            <th wire:click="sortBy('order_id')" style="cursor: pointer;"
                                class="{{ $sortField === 'order_id' ? ($sortDirection === 'asc' ? 'text-primary' : 'text-secondary') : '' }}">
                                Invoice Number
                                @if ($sortField === 'order_id')
                                    <span class="text-muted">{{ $sortDirection === 'asc' ? '▲' : '▼' }}</span>
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
                                    <td>{{ $order->order_number }}</td>
                                    <td>{{ $order->customer->first_name }} {{ $order->customer->last_name }}</td>
                                    <td>{{ \Carbon\Carbon::parse($order->order_date)->format('M d, Y') }}</td>
                                    <td>${{ number_format($order->total, 2) }}</td>
                                    <td>{{ $order->payment_mode }}</td>
                                    <td>
                                        <span style="color:                                                   
                                                    @if ($orderStatus[$order->order_id] === 'Paid') #28c76f 
                                                    @elseif ($orderStatus[$order->order_id] === 'Pending') #FF9F43 
                                                    @elseif ($orderStatus[$order->order_id] === 'Cancelled') #FF4C51 
                                                    @else white; @endif;">
                                            {{ $orderStatus[$order->order_id] }}
                                        </span>
                                    </td>
                                    <!-- Action dropdown on the left -->
                                    <td class="text-center">
                                        <div class="d-flex align-items-center justify-content-center">
                                            <!-- <a href="{{ route('admin.orders.details', $order->order_id) }}" class="text-black ml-3" title="View Order" target="_blank">
                                                <i class="fa fa-eye" style="font-size: 20px; color: #7367f0;"></i>
                                            </a>   -->                                      
                                            @if($order->is_generated)
                                                <button wire:click="downloadInvoice('{{ $order->order_id }}')" 
                                                        class="btn btn-sm btn-primary mx-2">
                                                    <i class="bi bi-download mr-1"></i> Download
                                                </button>
                                            @else
                                                <button wire:click="generateInvoice('{{ $order->order_id }}')" 
                                                        class="btn btn-sm btn-success mx-2">
                                                    <i class="bi bi-file-earmark-plus mr-1"></i> Generate
                                                </button>
                                            @endif
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
</div>

<script type="text/javascript">
    document.addEventListener('livewire:initialized', () => {
        // Initialize with existing values if they exist, otherwise use defaults
        let start = @json($dateStart) ? moment(@json($dateStart)) : moment().subtract(29,
            'days');
        let end = @json($dateEnd) ? moment(@json($dateEnd)) : moment();

        function cb(start, end, label) {
            if (label === 'Clear') {
                $('#reportrange span').html('Select Date Range');
                @this.set('dateStart', null);
                @this.set('dateEnd', null);
                return;
            }
            $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
            @this.set('dateStart', start.format('YYYY-MM-DD'));
            @this.set('dateEnd', end.format('YYYY-MM-DD'));
        }

        $('#reportrange').daterangepicker({
            startDate: start,
            endDate: end,
            autoUpdateInput: false,
            ranges: {
                'Clear': [null, null],
                'Today': [moment(), moment()],
                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1,
                    'month').endOf('month')]
            }
        }, cb);

        // Set initial display
        if (@json($dateStart) && @json($dateEnd)) {
            $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        } else {
            $('#reportrange span').html('Select Date Range');
        }

        // Listen for Livewire updates
        Livewire.on('dateRangeUpdated', () => {
            if (@json($dateStart) && @json($dateEnd)) {
                let newStart = moment(@json($dateStart));
                let newEnd = moment(@json($dateEnd));
                $('#reportrange').data('daterangepicker').setStartDate(newStart);
                $('#reportrange').data('daterangepicker').setEndDate(newEnd);
                $('#reportrange span').html(newStart.format('MMMM D, YYYY') + ' - ' + newEnd.format(
                    'MMMM D, YYYY'));
            }
        });
    });
</script>
