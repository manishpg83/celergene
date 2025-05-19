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
                </div>
            </div>            
        </div>

        <div style="font-size: 14px; margin-bottom: 10px;">
            <strong>Order Date:</strong> {{ date('F d, Y') }}<br>
            <strong>Order No:</strong> {{ $orderNumber }}
        </div>

        <div style="overflow-x: auto; margin-bottom: 25px;">
            <table
                style="width: 100%; border-collapse: collapse; border: 1px solid #ddd; box-shadow: 0 0 5px rgba(0,0,0,0.1);">
                <thead>
                    <tr style="background-color: #2c3e50; color: white;">
                        <th style="padding: 12px 8px; text-align: left; border: 1px solid #1a2836; font-weight: bold;">
                            Item Name</th>
                        <th
                            style="padding: 12px 8px; text-align: center; border: 1px solid #1a2836; font-weight: bold;">
                            Qty</th>
                        <th style="padding: 12px 8px; text-align: right; border: 1px solid #1a2836; font-weight: bold;">
                            Price (USD)</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $orderDetails = \App\Models\OrderDetails::where('order_id', $orderId)->get();
                        $orderMaster = \App\Models\OrderMaster::where('order_id', $orderId)->first();
                    @endphp
                    @foreach ($orderDetails as $index => $detail)
                        <tr style="background-color: {{ $index % 2 == 0 ? '#ffffff' : '#f9f9f9' }};">
                            <td
                                style="padding: 10px 8px; text-align: left; border: 1px solid #eee; word-break: break-word;">
                                {{ $detail->product->product_name ?? 'Unnamed Product' }}</td>
                            <td style="padding: 10px 8px; text-align: center; border: 1px solid #eee;">
                                {{ $detail->quantity }}</td>
                            <td style="padding: 10px 8px; text-align: right; border: 1px solid #eee;">
                                ${{ number_format($detail->unit_price, 2) }}</td>
                        </tr>
                    @endforeach
                    <tr style="background-color: #f8f9fa; border-top: 2px solid #dee2e6;">
                        <td style="padding: 10px 8px; text-align: right; border: 1px solid #eee;" colspan="2">
                            <strong>Sub Total</strong></td>
                        <td style="padding: 10px 8px; text-align: right; border: 1px solid #eee;">
                            ${{ number_format($orderMaster->subtotal, 2) }}</td>
                    </tr>
                    <tr style="background-color: #f8f9fa;">
                        <td style="padding: 10px 8px; text-align: right; border: 1px solid #eee;" colspan="2">
                            <strong>Freight</strong></td>
                        <td style="padding: 10px 8px; text-align: right; border: 1px solid #eee;">
                            {{ $orderMaster->freight == 0 ? 'Free' : '$' . number_format($orderMaster->freight, 2) }}
                        </td>
                    </tr>
                    <tr style="background-color: #e9f0f8; font-weight: bold;">
                        <td style="padding: 12px 8px; text-align: right; border: 1px solid #d0e0f3;" colspan="2">
                            <strong>Net Total</strong></td>
                        <td
                            style="padding: 12px 8px; text-align: right; border: 1px solid #d0e0f3; font-size: 16px; color: #2c3e50;">
                            <strong>${{ number_format($orderMaster->total, 2) }}</strong></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="footer" style="margin-top: 25px; text-align: left; font-size: 0.9em; color: #666;">
            <p>If you have any queries, please feel free to contact us at
                <a href="mailto:marketing@celergenswiss.com"
                    style="color: #666; word-break: break-all;">marketing@celergenswiss.com</a>
            </p>
        </div>

        <div class="signature" style="margin-top: 30px; font-weight: bold;">
            Yours sincerely,<br>
            <strong>Karen Koenig</strong><br>
            <em>Celergen Switzerland</em><br>
            Customer Experience Manager
        </div>

        <div style="margin-top: 30px; text-align: center; width: 100%;">
            <img src="http://13.49.251.219/frontend/images/email_banner.png" alt="Celergen Banner"
                style="max-width: 100%; width: 100%; height: auto; display: block;">
        </div>
    </div>
</body>

</html>
