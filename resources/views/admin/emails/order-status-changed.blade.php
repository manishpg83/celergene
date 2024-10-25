<!DOCTYPE html>
<html>
<head>
    <title>Order Status Updated</title>
</head>
<body>
    <h2>Order Status Update</h2>
    
    <p>Dear {{ $order->customer->first_name }} {{ $order->customer->last_name }},</p>
    
    <p>Your order #{{ $order->invoice_id }} status has been updated.</p>
    
    <p><strong>New Status:</strong> {{ $newStatus }}</p>
    
    <h3>Order Details:</h3>
    <ul>
        <li>Order Date: {{ date('M d, Y', strtotime($order->invoice_date)) }}</li>
        <li>Total Amount: ${{ number_format($order->total, 2) }}</li>
        <li>Payment Mode: {{ $order->payment_mode }}</li>
    </ul>
    
    <p>Thank you for your business!</p>
    
    <p>Best regards,<br>Celergen</p>
</body>
</html>