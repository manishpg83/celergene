<!DOCTYPE html>
<html>
<head>
    <title>Order Status Updated</title>
</head>
<body style="font-family: Arial, sans-serif; color: #333; background-color: #f9f9f9; margin: 0; padding: 20px; line-height: 1.6;">
    <div style="max-width: 600px; margin: 0 auto; background-color: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
        <h2 style="color: #4CAF50; text-align: center;">Order Status Update</h2>
        
        <p style="font-size: 16px;">Dear <strong>{{ $order->customer->first_name }} {{ $order->customer->last_name }}</strong>,</p>
        
        <p style="font-size: 16px;">Your order <strong>#{{ $order->order_id }}</strong> status has been updated.</p>
        
        <p style="font-size: 16px;"><strong>New Status:</strong> <span style="color: #ff5722;">{{ $newStatus }}</span></p>
        
        <h3 style="color: #333; border-bottom: 2px solid #4CAF50; padding-bottom: 5px;">Order Details:</h3>
        <ul style="list-style: none; padding: 0; font-size: 16px;">
            <li style="margin-bottom: 8px;"><strong>Order Date:</strong> {{ date('M d, Y', strtotime($order->order_date)) }}</li>
            <li style="margin-bottom: 8px;"><strong>Total Amount:</strong> ${{ number_format($order->total, 2) }}</li>
            <li style="margin-bottom: 8px;"><strong>Payment Mode:</strong> {{ $order->payment_mode }}</li>
        </ul>
        
        <p style="font-size: 16px;">Thank you for your business!</p>
        
        <p style="font-size: 16px; color: #666;">Best regards,<br><strong>Celergen</strong></p>
    </div>
</body>
</html>
