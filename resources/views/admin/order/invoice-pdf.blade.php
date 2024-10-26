<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Order Details #{{ $order->invoice_id }}</title>
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

        .additional-info {
            margin-top: 30px;
        }
    </style>
</head>
<body>
    <div class="invoice-header">
        <h2>Invoice #{{ $order->invoice_id }}</h2>
    </div>

    <div class="customer-details">
        <h4>Customer Details:</h4>
        <p>Name: {{ $order->customer->first_name }} {{ $order->customer->last_name }}</p>
        <p>Email: {{ $order->customer->email }}</p>
        <p>Phone: {{ $order->customer->phone }}</p>
    </div>

    <div class="order-details">
        <h4>Order Information:</h4>
        <p>Order Date: {{ date('M d, Y', strtotime($order->invoice_date)) }}</p>
        <p>Payment Mode: {{ $order->payment_mode }}</p>
        <p>Status: {{ $order->invoice_status }}</p>
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

        <div class="additional-info">
            <h4>Additional Information:</h4>
            <p><strong>Remarks:</strong> {{ $order->remarks }}</p>
            <p><strong>Payment Terms:</strong> {{ $order->payment_terms }}</p>
            <p><strong>Delivery Status:</strong> {{ $order->delivery_status }}</p>
        </div>
    </div>

</body>
</html>
