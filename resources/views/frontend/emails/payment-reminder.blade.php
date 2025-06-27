<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Complete Your Payment</title>
</head>

<body
    style="font-family: Helvetica, Arial, sans-serif; font-size: 14px; color: #222; margin: 0; padding: 20px; background-color: #fff; line-height: 1.6;">
    <div class="container" style="max-width: 800px; margin: 0 auto; padding: 15px;">

        <!-- Logo Section -->
        <div style="text-align: center; margin-bottom: 30px;">
            <img src="{{ asset('admin/assets/img/branding/cropped-celergen-logo.png') }}" alt="Celergen Swiss Logo"
                style="display: block; margin: 0 auto; max-width: 200px; width: 80%;">
        </div>

        <!-- Header Section -->
        <div class="header" style="text-align: left; font-size: 14px; line-height: 1.8;">
            <span>Dear {{ $billingAddress['name'] }},</span><br>
            <span style="display: inline-block; margin-top: 6px;">
                Thank you for visiting <a href="https://celergenswiss.com"
                    target="_blank">https://celergenswiss.com</a>.<br>
                We noticed you searched for our products but left before completing the purchase.<br>
                We value your time and have provided a link below for you to complete your purchase at your convenience.
            </span>

        </div>

        <!-- Payment Button -->
        @if ($paymentLink)
            <div style="text-align: center; margin: 30px 0;">
                <a href="{{ $paymentLink }}"
                    style="display: inline-block; background-color: #001d35; color: white; padding: 3px 20px; text-decoration: none; border-radius: 5px; font-weight: bold; font-size: 16px;">
                    Make Payment
                </a>
            </div>
        @endif

        <!-- Address Section -->
        <div style="display: flex; flex-wrap: wrap; justify-content: space-between; margin-bottom: 10px;">
            <div style="width: 48%; min-width: 250px;">
                <div style="white-space: pre-line;">
                    <strong>Billing Address:</strong><br>
                    {{ $billingAddress['name'] }}
                    @if ($billingAddress['company'])
                        {{ $billingAddress['company'] }}
                    @endif
                    {{ $billingAddress['address'] }}
                    @if ($billingAddress['address2'])
                        {{ $billingAddress['address2'] }}
                    @endif
                    {{ $billingAddress['city'] }}, {{ $billingAddress['state'] }} - {{ $billingAddress['postal_code'] }}
                    {{ $billingAddress['country'] }}
                    Phone: {{ $billingAddress['phone'] }}
                </div>
            </div>
            <div style="width: 48%; min-width: 250px;">
                <div style="margin: 0; white-space: pre-line;">
                    <strong>Shipping Address:</strong><br>
                    @if ($order->use_billing_as_shipping)
                        {{ $billingAddress['name'] }}
                        @if ($billingAddress['company'])
                            {{ $billingAddress['company'] }}
                        @endif
                        {{ $billingAddress['address'] }}
                        @if ($billingAddress['address2'])
                            {{ $billingAddress['address2'] }}
                        @endif
                        {{ $billingAddress['city'] }}, {{ $billingAddress['state'] }} -
                        {{ $billingAddress['postal_code'] }}
                        {{ $billingAddress['country'] }}
                    @else
                        {{ $shippingAddress['address'] }}
                    @endif
                </div>
            </div>
        </div>

        <!-- Order Info -->
        <div style="font-size: 14px; margin-bottom: 10px;">
            <strong>Order Date:</strong> {{ \Carbon\Carbon::parse($order->order_date)->format('F d, Y') }}<br>
            <strong>Order No:</strong> #{{ $order->order_number }}
        </div>

        <!-- Order Table -->
        <div style="overflow-x: auto; margin-bottom: 25px;">
            <table style="width: 100%; border-collapse: collapse; margin-bottom: 30px;">
                <thead>
                    <tr>
                        <th
                            style="font-family: Helvetica, Arial, sans-serif; padding: 12px; text-align: left; border-bottom: 1px solid #eee; background-color: #e2e2e2; font-weight: bold; color: #333;">
                            Item Name</th>
                        <th
                            style="font-family: Helvetica, Arial, sans-serif; padding: 12px; text-align: center; border-bottom: 1px solid #eee; background-color: #e2e2e2; font-weight: bold; color: #333;">
                            Qty</th>
                        <th
                            style="font-family: Helvetica, Arial, sans-serif; padding: 12px; text-align: right; border-bottom: 1px solid #eee; background-color: #e2e2e2; font-weight: bold; color: #333;">
                            Price (USD)</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orderDetails as $detail)
                        <tr>
                            <td
                                style="font-family: Helvetica, Arial, sans-serif; padding: 12px; text-align: left; border-bottom: 1px solid #eee;">
                                {{ $detail->product_name ?? 'Product' }}</td>
                            <td
                                style="font-family: Helvetica, Arial, sans-serif; padding: 12px; text-align: center; border-bottom: 1px solid #eee;">
                                {{ $detail->quantity }}</td>
                            <td
                                style="font-family: Helvetica, Arial, sans-serif; padding: 12px; text-align: right; border-bottom: 1px solid #eee;">
                                ${{ number_format($detail->total, 2) }}</td>
                        </tr>
                    @endforeach
                    <tr>
                        <td style="font-family: Helvetica, Arial, sans-serif; padding: 12px; border-bottom: none;"></td>
                        <td
                            style="font-family: Helvetica, Arial, sans-serif; padding: 12px; text-align: right; border-bottom: 1px solid #eee;">
                            <strong>Sub Total</strong>
                        </td>
                        <td
                            style="font-family: Helvetica, Arial, sans-serif; padding: 12px; text-align: right; border-bottom: 1px solid #eee;">
                            ${{ number_format($order->subtotal, 2) }}</td>
                    </tr>
                    <tr>
                        <td style="font-family: Helvetica, Arial, sans-serif; padding: 12px; border-bottom: none;"></td>
                        <td
                            style="font-family: Helvetica, Arial, sans-serif; padding: 12px; text-align: right; border-bottom: 1px solid #eee;">
                            <strong>Freight</strong>
                        </td>
                        <td
                            style="font-family: Helvetica, Arial, sans-serif; padding: 12px; text-align: right; border-bottom: 1px solid #eee;">
                            {{ ($order->freight ?? 0) > 0 ? '$' . number_format($order->freight, 2) : 'Free' }}</td>
                    </tr>
                    <tr>
                        <td style="font-family: Helvetica, Arial, sans-serif; padding: 12px; border-bottom: none;"></td>
                        <td
                            style="font-family: Helvetica, Arial, sans-serif; padding: 12px; text-align: right; border-bottom: 1px solid #eee;">
                            <strong>Net Total</strong>
                        </td>
                        <td
                            style="font-family: Helvetica, Arial, sans-serif; padding: 12px; text-align: right; border-bottom: 1px solid #eee; font-weight: bold; font-size: 16px;">
                            ${{ number_format($order->total, 2) }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        {{--         <!-- Second Payment Button -->
        @if ($paymentLink)
        <div style="text-align: center; margin: 30px 0;">
            <a href="{{ $paymentLink }}" 
               style="display: inline-block; background-color: #28a745; color: white; padding: 15px 30px; text-decoration: none; border-radius: 5px; font-weight: bold; font-size: 16px;">
                Make Payment
            </a>
        </div>
        @endif --}}

        <!-- Footer -->
        <div class="footer" style="margin-top: 25px; text-align: left; font-size: 0.9em; color: #666;">
            <p>If you have any queries, please feel free to contact us at
                <a href="mailto:marketing@celergenswiss.com"
                    style="color: #666; word-break: break-all;">marketing@celergenswiss.com</a>.
            </p>
        </div>

        <!-- Signature -->
        <div class="signature" style="margin-top: 30px; font-weight: bold;">
            Yours sincerely,<br>
            <strong>Karen Koenig</strong><br>
            <em>Celergen Switzerland</em><br>
            Customer Experience Manager
        </div>

        <!-- Banner -->
        <div style="margin-top: 30px; text-align: center; width: 100%;">
            <img src="{{ asset('frontend/images/email_banner.png') }}" alt="Celergen Banner"
                style="max-width: 100%; width: 100%; height: auto; display: block;">
        </div>
    </div>
</body>

</html>
