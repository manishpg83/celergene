<!DOCTYPE html>
<html lang="en">
 
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation</title>
</head>

<body
    style="font-family: Helvetica, Arial, sans-serif; font-size: 14px; color: #222; margin: 0; padding: 20px; background-color: #fff; line-height: 1.6;">
    <div class="container" style="max-width: 800px; margin: 0 auto; padding: 15px;">

        <div style="text-align: center; margin-bottom: 30px;">
            <img src="{{ asset('admin/assets/img/branding/cropped-celergen-logo.png') }}" alt="Celergen Swiss Logo"
                style="display: block; margin: 0 auto; max-width: 200px; width: 80%;">
        </div>

        <div class="header" style="text-align: left; font-size: 14px; line-height: 1.8;">
            <span>Dear {{ $user->first_name }} {{ $user->last_name }},</span><br>
            <span style="display: inline-block; margin-top: 6px;">
                Thank you for your payment.<br>
                Your order details are attached below.
            </span>
        </div>        

        <div style="display: flex; flex-wrap: wrap; justify-content: space-between; margin-bottom: 10px;">
            <div style="width: 48%; min-width: 250px;">
                <div style="white-space: pre-line;">
                    <strong>Billing Address:</strong><br>
                    {{ $billingName }}
                    {!! implode('<br>', array_filter(array_map('trim', explode(',', $billingAddress)))) !!}
                    {{ $billingCompany }}
                </div>
            </div>
            <div style="width: 48%; min-width: 250px;">
                <div style="margin: 0; white-space: pre-line;">
                    <strong>Shipping Address:</strong><br>
                    {{ $shippingName }}
                    {!! implode('<br>', array_filter(array_map('trim', explode(',', $shippingAddress)))) !!}
                    {{ $shippingCompany }}
                    {{ $shippingPhone }}
                </div>
            </div>       
        </div>

        <div style="font-size: 14px; margin-bottom: 10px;">
            <strong>Order Date:</strong> {{ date('F d, Y') }}<br>
            <strong>Order No:</strong> #{{ $orderNumber }}
        </div>

        <div style="overflow-x: auto; margin-bottom: 25px;">
            <table style="width: 100%; border-collapse: collapse; margin-bottom: 30px;">
                <thead>
                    <tr>
                        <th style="font-family: Helvetica, Arial, sans-serif; padding: 12px; text-align: left; border-bottom: 1px solid #eee; background-color: #e2e2e2; font-weight: bold; color: #333;">Item Name</th>
                        <th style="font-family: Helvetica, Arial, sans-serif; padding: 12px; text-align: center; border-bottom: 1px solid #eee; background-color: #e2e2e2; font-weight: bold; color: #333;">Qty</th>
                        <th style="font-family: Helvetica, Arial, sans-serif; padding: 12px; text-align: right; border-bottom: 1px solid #eee; background-color: #e2e2e2; font-weight: bold; color: #333;">Price (USD)</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $orderDetails = \App\Models\OrderDetails::where('order_id', $orderId)->get();
                        $orderMaster = \App\Models\OrderMaster::where('order_id', $orderId)->first();
                    @endphp
                    @foreach ($orderDetails as $detail)
                    <tr>
                        <td style="font-family: Helvetica, Arial, sans-serif; padding: 12px; text-align: left; border-bottom: 1px solid #eee;">{{ $detail->product->product_name ?? 'Unnamed Product' }}</td>
                        <td style="font-family: Helvetica, Arial, sans-serif; padding: 12px; text-align: center; border-bottom: 1px solid #eee;">{{ $detail->quantity }}</td>
                        <td style="font-family: Helvetica, Arial, sans-serif; padding: 12px; text-align: right; border-bottom: 1px solid #eee;">${{ number_format($detail->unit_price, 2) }}</td>
                    </tr>
                    @endforeach
                    <tr>
                        <td style="font-family: Helvetica, Arial, sans-serif; padding: 12px; border-bottom: none;"></td>
                        <td style="font-family: Helvetica, Arial, sans-serif; padding: 12px; text-align: right; border-bottom: 1px solid #eee;"><strong>Sub Total</strong></td>
                        <td style="font-family: Helvetica, Arial, sans-serif; padding: 12px; text-align: right; border-bottom: 1px solid #eee;">${{ number_format($orderMaster->subtotal, 2) }}</td>
                    </tr>
                    <tr>
                        <td style="font-family: Helvetica, Arial, sans-serif; padding: 12px; border-bottom: none;"></td>
                        <td style="font-family: Helvetica, Arial, sans-serif; padding: 12px; text-align: right; border-bottom: 1px solid #eee;"><strong>Freight</strong></td>
                        <td style="font-family: Helvetica, Arial, sans-serif; padding: 12px; text-align: right; border-bottom: 1px solid #eee;">{{ $orderMaster->freight == 0 ? 'Free' : '$' . number_format($orderMaster->freight, 2) }}</td>
                    </tr>
                    <tr>
                        <td style="font-family: Helvetica, Arial, sans-serif; padding: 12px; border-bottom: none;"></td>
                        <td style="font-family: Helvetica, Arial, sans-serif; padding: 12px; text-align: right; border-bottom: 1px solid #eee;"><strong>Net Total</strong></td>
                        <td style="font-family: Helvetica, Arial, sans-serif; padding: 12px; text-align: right; border-bottom: 1px solid #eee; font-weight: bold; font-size: 16px;">${{ number_format($orderMaster->total, 2) }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="footer" style="margin-top: 25px; text-align: left; font-size: 0.9em; color: #666;">
            <p>If you have any queries, please feel free to contact us at
                <a href="mailto:marketing@celergenswiss.com"
                    style="color: #666; word-break: break-all;">marketing@celergenswiss.com</a>.
            </p>
        </div>

        <div class="signature" style="margin-top: 30px; font-weight: bold;">
            Yours sincerely,<br>
            <strong>Karen Koenig</strong><br>
            <em>Celergen Switzerland</em><br>
            Customer Experience Manager
        </div>

        <div style="margin-top: 30px; text-align: center; width: 100%;">
            <img src="{{ asset('frontend/images/email_banner.png') }}" alt="Celergen Banner"
                style="max-width: 100%; width: 100%; height: auto; display: block;">
        </div>
    </div>
</body>

</html>
