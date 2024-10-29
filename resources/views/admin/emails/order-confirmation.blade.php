<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Order Confirmation #{{ $order->invoice_id }}</title>
</head>

<body
    style="font-family: Arial, sans-serif; font-size: 14px; color: #333; margin: 0; padding: 40px; background-color: #fff; line-height: 1.6;">
    <div class="container" style="max-width: 800px; margin: 0 auto; padding: 20px;">
        <div class="logo" style="text-align: center; margin-bottom: 30px;">
            <img src="{{ config('app.url') }}/admin/assets/img/branding/Celergen-Logo.png" alt="Celergen Logo" style="max-height: 60px; width: auto;">        </div>

        <div class="greeting" style="margin-bottom: 30px; line-height: 1.6;">
            <p>Dear {{ $customer->salutation }} {{ $customer->first_name }},</p>
            <p>Thank you for your payment.</p>
            <p>Your order details are attached below.</p>
        </div>

        <div class="address-section clearfix" style="margin-bottom: 40px; overflow: hidden;">
            <div class="billing-address" style="float: left; width: 48%;">
                <div class="address-title"
                    style="font-weight: bold; margin-bottom: 10px; color: #333; font-size: 16px;">Billing Address:</div>
                <p>{{ $customer->first_name }} {{ $customer->last_name }}</p>
                @if ($order->billing_address)
                    <p>{{ $order->billing_address }}</p>
                @endif
                @if ($customer->mobile_number)
                    <p>Phone: {{ $customer->mobile_number }}</p>
                @endif
                @if ($customer->email)
                    <p>Email: {{ $customer->email }}</p>
                @endif
            </div>

            <div class="shipping-address" style="float: right; width: 48%;">
                <div class="address-title"
                    style="font-weight: bold; margin-bottom: 10px; color: #333; font-size: 16px;">Shipping Address:
                </div>
                <p>{{ $customer->first_name }} {{ $customer->last_name }}</p>
                @if ($customer->shipping_address_1)
                    <p>{{ $customer->shipping_address_1 }}</p>
                @endif
            </div>
        </div>

        <div>
            <p><strong>Order No:</strong> #{{ $order->invoice_id }}</p>
            <p><strong>Order Date:</strong> {{ date('d M Y', strtotime($order->invoice_date)) }}</p>
        </div>

        <table style="width: 100%; border-collapse: collapse; margin-bottom: 30px;">
            <thead>
                <tr>
                    <th
                        style="padding: 12px; text-align: left; border-bottom: 1px solid #eee; background-color: #f8f9fa; font-weight: bold; color: #333;">
                        Description</th>
                    <th
                        style="padding: 12px; text-align: right; border-bottom: 1px solid #eee; background-color: #f8f9fa; font-weight: bold; color: #333;">
                        Quantity</th>
                    <th
                        style="padding: 12px; text-align: right; border-bottom: 1px solid #eee; background-color: #f8f9fa; font-weight: bold; color: #333;">
                        Unit Price</th>
                    <th
                        style="padding: 12px; text-align: right; border-bottom: 1px solid #eee; background-color: #f8f9fa; font-weight: bold; color: #333;">
                        DISCOUNT</th>
                    <th
                        style="padding: 12px; text-align: right; border-bottom: 1px solid #eee; background-color: #f8f9fa; font-weight: bold; color: #333;">
                        Amount</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($order->orderDetails as $detail)
                    <tr>
                        <td style="padding: 12px; text-align: left; border-bottom: 1px solid #eee;">
                            {{ $detail->product->product_name ?? 'Product' }}</td>
                        <td style="padding: 12px; text-align: right; border-bottom: 1px solid #eee;">
                            {{ $detail->quantity }}</td>
                        <td style="padding: 12px; text-align: right; border-bottom: 1px solid #eee;">
                            ${{ number_format($detail->unit_price, 2) }}</td>
                        <td style="padding: 12px; text-align: right; border-bottom: 1px solid #eee;">
                            -${{ number_format($detail->discount, 2) }}</td>
                        <td style="padding: 12px; text-align: right; border-bottom: 1px solid #eee;">
                            ${{ number_format($detail->total, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <table class="totals-table"
            style="width: 300px; margin-left: auto; margin-bottom: 40px; border-collapse: collapse;">
            <tr>
                <td class="label" style="padding: 8px; text-align: left; font-weight: bold; color: #333;">Subtotal:
                </td>
                <td class="value" style="padding: 8px; text-align: right;">${{ number_format($order->subtotal, 2) }}
                </td>
            </tr>
            @if ($order->discount > 0)
                <tr>
                    <td class="label" style="padding: 8px; text-align: left; font-weight: bold; color: #333;">Total
                        Discount:</td>
                    <td class="value" style="padding: 8px; text-align: right; color: #ff0000;">
                        -${{ number_format($order->discount, 2) }}</td>
                </tr>
            @endif
            @if ($order->tax > 0)
                <tr>
                    <td class="label" style="padding: 8px; text-align: left; font-weight: bold; color: #333;">Tax:</td>
                    <td class="value" style="padding: 8px; text-align: right; color: #008000;">
                        +${{ number_format($order->tax, 2) }}</td>
                </tr>
            @endif

            <tr class="total-line">
                <td class="label"
                    style="padding: 8px; text-align: left; font-weight: bold; color: #333; border-top: 2px solid #eee;">
                    Total:</td>
                <td class="value" style="padding: 8px; text-align: right; border-top: 2px solid #eee;">
                    ${{ number_format($order->total, 2) }}</td>
            </tr>
        </table>

        <div class="footer"
            style="text-align: center; margin-top: 40px; padding-top: 20px; border-top: 1px solid #eee; color: #666;">
            <p>Thank you for your business!</p>
            <p>If you have any questions about this order, please contact us.</p>
        </div>
    </div>
</body>

</html>
