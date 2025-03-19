<div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 row-gap-4">
        <div class="d-flex flex-column justify-content-center">
            <h4 class="mb-1 text-2xl ml-2">Consignment Order List</h4>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 gap-2">
                <div class="d-flex flex-wrap gap-2">
                    <select wire:model.live="perPage" class="form-select form-select-sm" style="width: auto; cursor: pointer;">
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                </div>
                
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
                            <th>Sr No</th>
                            <th>Order Number</th>
                            <th>Order Date</th>
                            <th>Customer Name</th>
                            <th>Company Name</th>
                            <th>Payment Mode</th>
                            <th>Total Amount</th>
                            <th>Order Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($consignmentOrders as $index => $order)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $order->order_number }}</td>
                                <td>{{ $order->order_date ? \Carbon\Carbon::parse($order->order_date)->format('Y-m-d') : 'N/A' }}</td>
                                <td>
                                    @if($order->customer)
                                        {{ $order->customer->first_name }} {{ $order->customer->last_name }}
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td>{{ $order->customer->company_name ?? 'N/A' }}</td>
                                <td>{{ $order->payment_mode }}</td>
                                <td>{{ number_format($order->total, 2) }}</td>
                                <td>{{ $order->order_status }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center">No consignment orders found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $consignmentOrders->links() }}
            </div>
        </div>
    </div>
</div>