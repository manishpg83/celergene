<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Update Notification</title>
    <style>
        body, * {
            font-family: Helvetica, Arial, sans-serif !important;
        }
    </style>
</head>

<body style="font-family: Helvetica, Arial, sans-serif !important; font-size: 14px; color: #222; margin: 0; padding: 20px; background-color: #fff; line-height: 1.6;">
    <div class="container" style="font-family: Helvetica, Arial, sans-serif; max-width: 800px; margin: 0 auto; padding: 20px;">
        <div style="text-align: center; margin-bottom: 30px; width: 100%; display: block;">
            <img src="{{ asset('admin/assets/img/branding/cropped-celergen-logo.png') }}"
                 alt="Celergen Logo"
                 style="max-height: 60px; width: auto; display: inline-block; margin: 0 auto;">
        </div>

        <div class="greeting" style="font-family: Helvetica, Arial, sans-serif; margin-bottom: 30px; line-height: 1.6;">
            <p style="font-family: Helvetica, Arial, sans-serif;">Dear {{ $warehouseName }} team,</p>

            <p style="font-family: Helvetica, Arial, sans-serif; font-weight: bold; margin-top: 20px;">Shipping Details:</p>

            <div class="address-container" style="font-family: Helvetica, Arial, sans-serif; margin-bottom: 15px;">
                <div style="font-family: Helvetica, Arial, sans-serif; margin-bottom: 10px;">
                    <strong>Address:</strong><br>
                    {!! implode('<br>', array_filter(array_map('trim', explode(',', $shippingAddress)))) !!}
                </div>
                <div style="font-family: Helvetica, Arial, sans-serif;">
                    <strong>Phone:</strong> {{ $customerMobile ?? 'N/A' }}
                </div>
            </div>
        </div>

        <div style="font-family: Helvetica, Arial, sans-serif; font-size: 14px; margin-bottom: 10px;">
            <strong>Order Date:</strong> {{ \Carbon\Carbon::parse($order->order_date)->format('F d, Y') }}<br>
            <strong>Order No:</strong> #{{ $order->order_id }}
        </div>

        <table style="font-family: Helvetica, Arial, sans-serif; width: 100%; border-collapse: collapse; margin-bottom: 30px;">
            <thead>
                <tr>
                    <th style="font-family: Helvetica, Arial, sans-serif; padding: 12px; text-align: left; border-bottom: 1px solid #eee; background-color: #f8f9fa; font-weight: bold; color: #333;">Item Name</th>
                    <th style="font-family: Helvetica, Arial, sans-serif; padding: 12px; text-align: right; border-bottom: 1px solid #eee; background-color: #f8f9fa; font-weight: bold; color: #333;">Total Quantity</th>
                </tr>
            </thead>
            <tbody>
                @foreach($productDetails as $detail)
                <tr>
                    <td style="font-family: Helvetica, Arial, sans-serif; padding: 12px; text-align: left; border-bottom: 1px solid #eee;">{{ $detail['product_name'] }}</td>
                    <td style="font-family: Helvetica, Arial, sans-serif; padding: 12px; text-align: right; border-bottom: 1px solid #eee;">{{ $detail['quantity'] }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        
        <p style="font-family: Helvetica, Arial, sans-serif;">Please update the status of the delivery order and add a tracking number.</p>

        <p style="font-family: Helvetica, Arial, sans-serif;">
            <a href="{{ $updateLink }}" class="link" style="font-family: Helvetica, Arial, sans-serif;">Click here to update delivery status</a>
        </p>
        
        <div class="footer" style="font-family: Helvetica, Arial, sans-serif; text-align: center; margin-top: 40px; padding-top: 20px; border-top: 1px solid #eee; color: #666;">
            <p style="font-family: Helvetica, Arial, sans-serif;">If you have any queries, please feel free to contact us at <a href="mailto:marketing@celergenswiss.com" style="font-family: Helvetica, Arial, sans-serif; color: #007bff; text-decoration: none;">marketing@celergenswiss.com</a></p>
        </div>

        <div style="margin-top: 30px; text-align: center; width: 100%;">
            <img src="http://13.49.251.219/frontend/images/email_banner.png" alt="Celergen Banner"
                style="max-width: 100%; width: 100%; height: auto; display: block;">
        </div>
    </div>
</body>
</html>