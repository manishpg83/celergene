<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Order Confirmation</title>
</head>

<body style="font-family: Arial, sans-serif; font-size: 14px; color: #333; margin: 0; padding: 40px; background-color: #fff; line-height: 1.6;">
    <div class="container" style="max-width: 800px; margin: 0 auto; padding: 20px;">

        <img src="https://cdn2-bread6hkcwg3dyar.z01.azurefd.net/celergenswiss/images/common/cropped-celergen-logo.png"
            alt="Celergen Swiss Logo" style="display: block; margin: 0 auto; max-width: 250px; margin-bottom: 50px;">

        <div class="header" style="text-align: left; margin-bottom: 40px;">
            <p>Dear {{ $user->first_name }} {{ $user->last_name }},</p>
            <p>Thank you for your payment.</p>
            <p>Your order details are attached below.</p>
        </div>

        <div class="address-section" style="display: flex; justify-content: space-between; margin-bottom: 30px;">
            <div class="address-block" style="width: 48%;">
                <p style="margin: 0; white-space: pre-line;">
                    <strong>Billing Address:</strong><br>
                    {!! nl2br(implode('<br>', array_map('trim', explode(',', $billingAddress)))) !!}<br>
                </p>                
            </div>
            <div class="address-block" style="width: 48%;">
                <p style="margin: 0; white-space: pre-line;">
                    <strong>Shipping Address:</strong><br>
                    {!! nl2br(implode('<br>', array_map('trim', explode(',', $shippingAddress)))) !!}<br>
                </p> 
            </div>
        </div>

        <p><strong>Order Date:</strong> {{ date('F d, Y') }}</p>
        <p><strong>Order No:</strong> #{{ $orderNumber }}</p>

        <table style="width: 100%; border-collapse: collapse; margin-bottom: 30px; border: 1px solid #ddd;">
            <thead>
                <tr style="background-color: silver;">
                    <th style="padding: 12px; text-align: right; border: 1px solid #000000; font-weight: bold;">Item Name</th>
                    <th style="padding: 12px; text-align: right; border: 1px solid #000000; font-weight: bold;">Total Quantity</th>
                    <th style="padding: 12px; text-align: right; border: 1px solid #000000; font-weight: bold;">Price (USD)</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $orderDetails = \App\Models\OrderDetails::where('order_id', $orderId)->get();
                    $orderMaster = \App\Models\OrderMaster::where('order_id', $orderId)->first();
                @endphp
                @foreach ($orderDetails as $detail)
                    <tr>
                        <td style="padding: 12px; text-align: right; border: 1px solid #ddd;">{{ $detail->product->product_name ?? 'Unnamed Product' }}</td>
                        <td style="padding: 12px; text-align: right; border: 1px solid #ddd;">{{ $detail->quantity }}</td>
                        <td style="padding: 12px; text-align: right; border: 1px solid #ddd;">{{ number_format($detail->unit_price, 2) }}</td>
                    </tr>
                @endforeach
                <tr style="background-color: #f2f2f2; border: 1px solid #7c7979;">
                    <td style="padding: 12px; text-align: right; border: 1px solid #ddd;" colspan="2"><strong>Sub Total</strong></td>
                    <td style="padding: 12px; text-align: right; border: 1px solid #ddd;">{{ number_format($orderMaster->subtotal, 2) }}</td>
                </tr>
                <tr style="background-color: #f2f2f2; border: 1px solid #7c7979;">
                    <td style="padding: 12px; text-align: right; border: 1px solid #ddd;" colspan="2"><strong>Freight</strong></td>
                    <td style="padding: 12px; text-align: right; border: 1px solid #ddd;">{{ $orderMaster->freight == 0 ? 'Free' : number_format($orderMaster->freight, 2) }}</td>
                </tr>
                <tr style="background-color: #f2f2f2; border: 1px solid #7c7979;">
                    <td style="padding: 12px; text-align: right; border: 1px solid #ddd;" colspan="2"><strong>Net Total</strong></td>
                    <td style="padding: 12px; text-align: right; border: 1px solid #ddd;"><strong>{{ number_format($orderMaster->total, 2) }}</strong></td>
                </tr>
            </tbody>
        </table>

        <div class="footer" style="margin-top: 30px; text-align: left; font-size: 0.9em; color: #666;">
            <p>If you have any queries, please feel free to contact us at
                <a href="mailto:marketing@celergenswiss.com" style="color: #666;">marketing@celergenswiss.com</a>
            </p>
        </div>

        <div class="signature" style="margin-top: 50px; font-weight: bold;">
            Yours sincerely,<br>
            <strong>Karen Koenig</strong><br>
            <em>Celergen Switzerland</em><br>
            Customer Experience Manager
        </div>

        <img src="http://13.49.251.219/frontend/images/email_banner.png" alt="Celergen Banner"
            style="width: 100%; margin-top: 40px;">
    </div>
</body>

</html>
