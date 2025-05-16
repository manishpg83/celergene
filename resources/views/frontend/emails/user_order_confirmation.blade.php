<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation</title>
</head>

<body style="font-family: Arial, sans-serif; font-size: 14px; color: #333; margin: 0; padding: 20px; background-color: #fff; line-height: 1.6;">
    <div class="container" style="max-width: 600px; margin: 0 auto; padding: 15px;">

        <div style="text-align: center; margin-bottom: 30px;">
            <img src="{{ asset('admin/assets/img/caviarlieri-logo.png') }}"
                alt="Caviarlieri Logo" style="display: block; margin: 0 auto; max-width: 200px; width: 80%;">
        </div>

        <div class="header" style="text-align: left; margin-bottom: 30px;">
            <p>Dear {{ $user->first_name }} {{ $user->last_name }},</p>
            <p>Thank you for your payment.</p>
            <p>Your order details are attached below.</p>
        </div>

        <div class="address-section" style="margin-bottom: 25px;">
            <div class="address-block" style="width: 100%; margin-bottom: 15px;">
                <p style="margin: 0; white-space: pre-line;">
                    <strong>Billing Address:</strong><br>
                    {!! nl2br(implode('<br>', array_map('trim', explode(',', $billingAddress)))) !!}<br>
                </p>                
            </div>
            <div class="address-block" style="width: 100%;">
                <p style="margin: 0; white-space: pre-line;">
                    <strong>Shipping Address:</strong><br>
                    {!! nl2br(implode('<br>', array_map('trim', explode(',', $shippingAddress)))) !!}<br>
                </p> 
            </div>
        </div>

        <p><strong>Order Date:</strong> {{ date('F d, Y') }}</p>
        <p><strong>Order No:</strong> #{{ $orderNumber }}</p>

        <div style="overflow-x: auto; margin-bottom: 25px;">
            <table style="width: 100%; border-collapse: collapse; border: 1px solid #ddd; box-shadow: 0 0 5px rgba(0,0,0,0.1);">
                <thead>
                    <tr style="background-color: #2c3e50; color: white;">
                        <th style="padding: 12px 8px; text-align: left; border: 1px solid #1a2836; font-weight: bold;">Item Name</th>
                        <th style="padding: 12px 8px; text-align: center; border: 1px solid #1a2836; font-weight: bold;">Qty</th>
                        <th style="padding: 12px 8px; text-align: right; border: 1px solid #1a2836; font-weight: bold;">Price (USD)</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $orderDetails = \App\Models\OrderDetails::where('order_id', $orderId)->get();
                        $orderMaster = \App\Models\OrderMaster::where('order_id', $orderId)->first();
                    @endphp
                    @foreach ($orderDetails as $index => $detail)
                        <tr style="background-color: {{ $index % 2 == 0 ? '#ffffff' : '#f9f9f9' }};">
                            <td style="padding: 10px 8px; text-align: left; border: 1px solid #eee; word-break: break-word;">{{ $detail->product->product_name ?? 'Unnamed Product' }}</td>
                            <td style="padding: 10px 8px; text-align: center; border: 1px solid #eee;">{{ $detail->quantity }}</td>
                            <td style="padding: 10px 8px; text-align: right; border: 1px solid #eee;">${{ number_format($detail->unit_price, 2) }}</td>
                        </tr>
                    @endforeach
                    <tr style="background-color: #f8f9fa; border-top: 2px solid #dee2e6;">
                        <td style="padding: 10px 8px; text-align: right; border: 1px solid #eee;" colspan="2"><strong>Sub Total</strong></td>
                        <td style="padding: 10px 8px; text-align: right; border: 1px solid #eee;">${{ number_format($orderMaster->subtotal, 2) }}</td>
                    </tr>
                    <tr style="background-color: #f8f9fa;">
                        <td style="padding: 10px 8px; text-align: right; border: 1px solid #eee;" colspan="2"><strong>Freight</strong></td>
                        <td style="padding: 10px 8px; text-align: right; border: 1px solid #eee;">{{ $orderMaster->freight == 0 ? 'Free' : '$'.number_format($orderMaster->freight, 2) }}</td>
                    </tr>
                    <tr style="background-color: #e9f0f8; font-weight: bold;">
                        <td style="padding: 12px 8px; text-align: right; border: 1px solid #d0e0f3;" colspan="2"><strong>Net Total</strong></td>
                        <td style="padding: 12px 8px; text-align: right; border: 1px solid #d0e0f3; font-size: 16px; color: #2c3e50;"><strong>${{ number_format($orderMaster->total, 2) }}</strong></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="footer" style="margin-top: 25px; text-align: left; font-size: 0.9em; color: #666;">
            <p>If you have any queries, please feel free to contact us at
                <a href="mailto:marketing@swisscaviarlieri.com" style="color: #666; word-break: break-all;">marketing@swisscaviarlieri.com</a>
            </p>
        </div>

        <div class="signature" style="margin-top: 30px; font-weight: bold;">
            Yours sincerely,<br>
            <strong>Karen Koenig</strong><br>
            <em>Celergen Switzerland</em><br>
            Customer Experience Manager
        </div>

        <div style="margin-top: 30px; text-align: center; width: 100%;">
            <img src="{{ asset('frontend/images/email_banner.png') }}" alt="Caviarlieri Banner"
                style="max-width: 100%; width: 100%; height: auto; display: block;">
        </div>
    </div>
</body>

</html>