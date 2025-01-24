<section class="col-xl-9 account-wrapper">
    <div class="account-card order-details">
        <div class="order-head">
            <div>
                <svg xmlns="http://www.w3.org/2000/svg" xml:space="preserve" width="64" height="64"
                    style="shape-rendering:geometricPrecision;text-rendering:geometricPrecision;image-rendering:optimizeQuality;fill-rule:evenodd;clip-rule:evenodd"
                    viewBox="0 0 6.827 6.827">
                    <defs>
                        <style>
                            .fil2 {
                                fill: #fffffe;
                                fill-rule: nonzero
                            }
                        </style>
                    </defs>
                    <g id="Layer_x0020_1">
                        <rect width="6.827" height="6.827" rx=".853" ry=".853" style="fill:#66bb6a" />
                        <g id="_486076848">
                            <path id="_512193792"
                                d="M1.608 2.024h4.333l-.048.14L5.32 3.85l-.024.073H1.978l-.021-.08-.452-1.685-.036-.134h.14zm.684 1.283h2.673l-.074.213H2.35l-.058-.213zm-.115-.425h2.935l-.074.213H2.234l-.057-.213zm-.116-.429h3.198v.006l-.072.208H2.118l-.057-.214z"
                                style="fill:#fffffe" />
                            <path id="_512193264" class="fil2"
                                d="M.886 1.514H1.553l.021.079.687 2.562h2.956l-.072.213H2.097l-.021-.08-.686-2.561H.886z" />
                            <path id="_512193216" class="fil2"
                                d="M2.423 4.514a.398.398 0 0 1 .282.682.398.398 0 0 1-.682-.282.398.398 0 0 1 .4-.4zm.131.268a.185.185 0 0 0-.317.132.185.185 0 0 0 .317.131.185.185 0 0 0 0-.263z" />
                            <path id="_491182512" class="fil2"
                                d="M5.02 4.514a.398.398 0 0 1 .282.682.398.398 0 0 1-.682-.282.398.398 0 0 1 .4-.4zm.131.268a.185.185 0 0 0-.318.132.186.186 0 0 0 .318.131.185.185 0 0 0 0-.263z" />
                        </g>
                    </g>
                </svg>
            </div>


            <div class="clearfix m-l20">
                <div class="badge-{{ strtolower($order->order_status) }}" style="max-width: 50%;">{{ ucfirst($order->order_status) }}</div>
                <h4 class="mb-0">Order #{{ $formatted_order_number }}</h4>
            </div>
        </div>
        <div class="row mb-sm-4 mb-2">
            <div class="col-sm-12">
                <div class="shiping-tracker-detail">
                    <span>Order Date</span>
                    <h6 class="title">{{ $order->created_at->format('d F Y') }}</h6>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="shiping-tracker-detail">
                    <span>Billing Address</span>
                    <h6 class="title">{{ $order->customer->billing_address ?? 'N/A' }}</h6>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="shiping-tracker-detail">
                    <span>Shipping Address</span>
                    <h6 class="title">{{ $order->shipping_address ?? 'N/A' }}</h6>
                </div>
            </div>
        </div>

        <div class="clearfix">
            <div class="tab-content">
                <div class="tab-pane fade show active">
                    <h5>Item Details</h5>
                    @foreach ($order->items as $item)
                        <div class="tracking-item">
                            <div class="tracking-product">
                                <img src="{{ asset($item->product->product_img ?? 'images/shop/small/pic1.png') }}"
                                    alt="">
                            </div>
                            <div class="tracking-product-content">
                                <h6 class="title">
                                    {{ $item->manual_product_name ?? ($item->product->product_name ?? 'N/A') }}</h6>
                                <small class="d-block"><strong>Price</strong>:
                                    ${{ number_format($item->unit_price, 2) }}</small>
                                <small class="d-block"><strong>Quantity</strong>: {{ $item->quantity }}</small>
                            </div>
                        </div>
                    @endforeach

                    <div class="tracking-item-content">
                        <span>Total Price</span>
                        <h6>+ ${{ number_format($order->subtotal, 2) }}</h6>
                    </div>
                    <div class="tracking-item-content">
                        <span>Order Total</span>
                        <h6>${{ number_format($order->total, 2) }}</h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
