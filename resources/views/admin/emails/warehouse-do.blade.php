<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Order Update Notification</title>
</head>

<body style="font-family: Arial, sans-serif; font-size: 14px; color: #333; margin: 0; padding: 40px; background-color: #fff; line-height: 1.6;">
    <div class="container" style="max-width: 800px; margin: 0 auto; padding: 20px;">
        <div style="text-align: center; margin-bottom: 30px; width: 100%; display: block;">
            <img src="https://cdn2-bread6hkcwg3dyar.z01.azurefd.net/celergenswiss/images/common/cropped-celergen-logo.png" 
                 alt="Celergen Logo" 
                 style="max-height: 60px; width: auto; display: inline-block; margin: 0 auto;">
        </div>

        <div class="greeting" style="margin-bottom: 30px; line-height: 1.6;">
            <p>Dear {{ $warehouseName }} team,</p>
            
            <p style="font-weight: bold; margin-top: 20px;">Shipping Details:</p>
            
            <p>
                <strong>Address:</strong><br>
                {!! nl2br(implode('<br>', array_map('trim', explode(',', $shippingAddress)))) !!}<br>
                <strong>Phone:</strong> {{ $customerMobile ?? 'N/A' }}
            </p>
        </div>

        <div>
            <p><strong>Order Date :</strong> {{ \Carbon\Carbon::parse($order->order_date)->format('F d, Y') }}</p>
            <p><strong>Order No :</strong> #{{ $order->order_number }}</p>
        </div>

        <table style="width: 100%; border-collapse: collapse; margin-bottom: 30px;">
            <thead>
                <tr>
                    <th style="padding: 12px; text-align: left; border-bottom: 1px solid #eee; background-color: #f8f9fa; font-weight: bold; color: #333;">Item Name</th>
                    <th style="padding: 12px; text-align: right; border-bottom: 1px solid #eee; background-color: #f8f9fa; font-weight: bold; color: #333;">Total Quantity</th>
                </tr>
            </thead>
            <tbody>
                @foreach($productDetails as $detail)
                <tr>
                    <td style="padding: 12px; text-align: left; border-bottom: 1px solid #eee;">{{ $detail['product_name'] }}</td>
                    <td style="padding: 12px; text-align: right; border-bottom: 1px solid #eee;">{{ $detail['quantity'] }}</td>
                </tr>
                @endforeach
            </tbody> 
        </table>
        <p>Please update the status of the delivery order and add a tracking number.</p>

        <p>
            <a href="{{ $updateLink }}" class="link">Click here to update delivery status</a>
        </p>
        <div class="footer" style="text-align: center; margin-top: 40px; padding-top: 20px; border-top: 1px solid #eee; color: #666;">
            <p>Thank you for your business!</p>
            <p>If you have any queries, please feel free to contact us at <a href="mailto:marketing@celergenswiss.com" style="color: #007bff; text-decoration: none;">marketing@celergenswiss.com</a></p>
        </div>
    </div>
</body>

</html>