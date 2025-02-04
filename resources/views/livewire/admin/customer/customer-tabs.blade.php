<div>
    <!-- Top Navigation -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="d-flex align-items-center top-navigation">
            <button wire:click="setTab('overview')" 
                class="btn {{ $activeTab === 'overview' ? 'btn-primary' : 'btn-link text-dark' }}">
                Overview
            </button>
            <button wire:click="setTab('address')"
                class="btn {{ $activeTab === 'address' ? 'btn-primary' : 'btn-link text-dark' }}">
                Address & Billing
            </button>
        </div>
    </div>

    <!-- Tab Contents -->
    @if($activeTab === 'overview')
    <div class="tab-content p-0">
        <div class="card shadow-sm p-3 mb-4">
            <div class="table-responsive">
                <h4 class="fw-bold fs-5 mb-4 ml-2">Orders Placed</h4>
                <table class="table">
                    <thead>
                        <tr class="text-center">
                            <th>Order ID</th>
                            <th>Order Date</th>
                            <th>Total</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $order)
                            <tr class="text-center">
                                <td>{{ $order->order_id }}</td>
                                <td>{{ \Carbon\Carbon::parse($order->order_date)->format('Y-m-d') }}</td>
                                <td>${{ number_format($order->total, 2) }}</td>
                                <td>
                                    <span class="badge bg-label-{{ $order->order_status === 'Paid' ? 'success' : ($order->order_status === 'Pending' ? 'warning' : 'danger') }}">
                                        {{ ucfirst($order->order_status) }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
        
                <div class="d-flex justify-content-end mt-3">
                    {{ $orders->links() }}
                </div>
            </div>
        </div>
    </div>
    @endif

    @if($activeTab === 'address')
    <div class="tab-content p-0">
        <div class="card shadow-sm p-3 mb-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="ml-6 mb-0 fs-5">Address Book</h5>
                {{-- <button class="btn btn-outline-primary btn-sm">Add new address</button> --}}
            </div>
            <div class="list-group list-group-flush">
                <!-- Billing Address -->
                <div class="list-group-item d-flex justify-content-between align-items-center">
                    <div>
                        <p class="mb-0"><strong>Billing Address</strong> <span class="badge bg-label-success ms-2">Default Address</span></p>
                        <p class="text-muted mb-0">{{ $customer->billing_address }}</p>
                        <p class="text-muted mb-0">{{ $customer->billing_country }}, {{ $customer->billing_postal_code }}</p>
                    </div>
                    <div>
                        <a href="{{ url('/admin/customer/add?id=' . $customer->id) }}" class="btn btn-link p-0 me-2">
                            <i class="fas fa-edit"></i>
                        </a>
                        {{-- <button class="btn btn-link p-0"><i class="fas fa-trash-alt"></i></button> --}}
                    </div>
                </div>
                <!-- Shipping Addresses -->
                @if($customer->shipping_address_1)
                <div class="list-group-item d-flex justify-content-between align-items-center">
                    <div>
                        <p class="mb-0"><strong>Shipping Address 1</strong></p>
                        <p class="text-muted mb-0">{{ $customer->shipping_address_1 }}</p>
                        <p class="text-muted mb-0">{{ $customer->shipping_country_1 }}, {{ $customer->shipping_postal_code_1 }}</p>
                    </div>
                    <div>
                        <a href="{{ url('/admin/customer/add?id=' . $customer->id) }}" class="btn btn-link p-0 me-2">
                            <i class="fas fa-edit"></i>
                        </a>
                        {{-- <button class="btn btn-link p-0"><i class="fas fa-trash-alt"></i></button> --}}
                    </div>
                </div>
                @endif
                
                @if($customer->shipping_address_2)
                <div class="list-group-item d-flex justify-content-between align-items-center">
                    <div>
                        <p class="mb-0"><strong>Shipping Address 2</strong></p>
                        <p class="text-muted mb-0">{{ $customer->shipping_address_2 }}</p>
                        <p class="text-muted mb-0">{{ $customer->shipping_country_2 }}, {{ $customer->shipping_postal_code_2 }}</p>
                    </div>
                    <div>
                        <a href="{{ url('/admin/customer/add?id=' . $customer->id) }}" class="btn btn-link p-0 me-2">
                            <i class="fas fa-edit"></i>
                        </a>
                        {{-- <button class="btn btn-link p-0"><i class="fas fa-trash-alt"></i></button> --}}
                    </div>
                </div>
                @endif
                @if($customer->shipping_address_3)
                <div class="list-group-item d-flex justify-content-between align-items-center">
                    <div>
                        <p class="mb-0"><strong>Shipping Address 3</strong></p>
                        <p class="text-muted mb-0">{{ $customer->shipping_address_3 }}</p>
                        <p class="text-muted mb-0">{{ $customer->shipping_country_3 }}, {{ $customer->shipping_postal_code_3 }}</p>
                    </div>
                    <div>
                        <a href="{{ url('/admin/customer/add?id=' . $customer->id) }}" class="btn btn-link p-0 me-2">
                            <i class="fas fa-edit"></i>
                        </a>
                        {{-- <button class="btn btn-link p-0"><i class="fas fa-trash-alt"></i></button> --}}
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
    @endif
</div>
