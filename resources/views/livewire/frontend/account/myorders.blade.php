<section class="col-xl-9 account-wrapper">
    <div class="account-card">
        <div class="table-responsive table-style-1">
            <table class="table table-hover mb-3 text">
                <thead>
                    <tr>
                        <th>Order #</th>
                        <th>Date Purchased</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                        <tr>
                            <td><a href="#" class="fw-medium">#{{ $order->formatted_order_number }}</a></td>
                            <td>{{ $order->created_at->format('F d, Y') }}</td>
                            <td>${{ number_format($order->total, 2) }}</td>
                            <td>
                                <span
                                    class="badge-{{ strtolower($order->order_status) }}">{{ ucfirst($order->order_status) }}</span>
                            </td>
                            <td><a href="{{ route('orderview', ['order_id' => $order->order_id]) }}"
                                    class="btn-link text-underline p-0">View</a></td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">No orders found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($orders->hasPages())
            <div class="d-flex justify-content-center">
                {{ $orders->links('vendor.pagination.style-1') }}
            </div>
        @endif
    </div>
</section>
