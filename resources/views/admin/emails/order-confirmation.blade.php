<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Order Confirmation #{{ $order->id }}</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            font-size: 14px;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        .invoice-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .customer-details, .order-details {
            margin-bottom: 20px;
        }

        .container {
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 20px;
        }

        .header p {
            margin: 0;
            font-size: 14px;
        }

        .status {
            background-color: #28a745;
            color: white;
            padding: 5px 10px;
            border-radius: 15px;
            font-size: 14px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th, td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
        }

        th {
            background-color: #f1f3f4;
            text-transform: uppercase;
            font-size: 12px;
            color: #6c757d;
            border-bottom: 2px solid #dee2e6;
        }

        td {
            font-size: 14px;
        }

        .text-right {
            text-align: right;
        }

        .text-danger {
            color: #dc3545;
        }

        .text-success {
            color: #28a745;
        }

        .totals {
            width: 250px;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 15px;
            background-color: #f9f9f9;
            float: right;
        }

        .totals div {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .totals div:last-child {
            font-size: 18px;
            font-weight: bold;
        }

        .totals span {
            font-size: 14px;
        }

        .totals hr {
            border: none;
            border-top: 1px solid #ddd;
            margin: 10px 0;
        }

        h4 {
            color: #333;
            margin-bottom: 10px;
        }

        p {
            margin: 5px 0;
        }
    </style>
</head>
<body>
    <div class="invoice-header">
        <h2>Order Confirmation #{{ $order->invoice_id }}</h2>
    </div>

    <div class="customer-details">
        <h4>Customer Details:</h4>
        <p>Name: {{ $customer->first_name }} {{ $customer->last_name }}</p>
        <p>Email: {{ $customer->email }}</p>
        <p>Phone: {{ $customer->phone }}</p>
    </div>

    <div class="order-details">
        <h4>Order Information:</h4>
        <p>Order Date: {{ date('M d, Y', strtotime($order->invoice_date)) }}</p>
        <p>Payment Mode: {{ $order->payment_mode }}</p>
        <p>Status: {{ $order->invoice_status }}</p>
        <p>Shipping Address: {{ $order->shipping_address }}</p>
    </div>

    <div class="container">
        <table>
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Discount</th>
                    <th>Total Price</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($order->orderDetails as $detail)
                <tr>
                    <td>{{ $detail->product->product_name }}</td>
                    <td class="text-right">{{ $detail->quantity }}</td>
                    <td class="text-right">${{ number_format($detail->unit_price, 2) }}</td>
                    <td class="text-right text-danger">-${{ number_format($detail->discount, 2) }}</td>
                    <td class="text-right">${{ number_format($detail->total, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="totals">
            <div>
                <span>Subtotal:</span>
                <span>${{ number_format($order->subtotal, 2) }}</span>
            </div>
            <div>
                <span>Total Discount:</span>
                <span class="text-danger">-${{ number_format($order->discount, 2) }}</span>
            </div>
            <div>
                <span>Tax:</span>
                <span class="text-success">+${{ number_format($order->tax, 2) }}</span>
            </div>
            <hr>
            <div>
                <span>Total:</span>
                <span>${{ number_format($order->total, 2) }}</span>
            </div>
        </div>

        <div style="clear: both; margin-top: 40px; text-align: center; color: #666;">
            <p>Thank you for your order! If you have any questions, please don't hesitate to contact us.</p>
        </div>
    </div>
</body>
</html>