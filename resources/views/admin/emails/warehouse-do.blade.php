<!DOCTYPE html>
<html>

<head>
    <title>Order Update Notification</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
            line-height: 1.4;
            color: #000;
            margin: 20px;
        }

        .shipping-details {
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #999;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .link {
            color: blue;
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="shipping-details">
        <p>Dear {{ $warehouseName }} team,</p>

        <p><strong>Shipping Address:</strong></p>
        <p>
            {!! nl2br(e($shippingAddress)) !!}<br>
            Phone: {{ $customerMobile ?? 'N/A' }}
        </p>

        <p>Order Date: {{ \Carbon\Carbon::parse($order->order_date)->format('F d, Y') }}<br>
            Order No: {{ $order->order_number }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Item Name</th>
                <th>Quantity To Deliver</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($productDetails as $detail)
                <tr>
                    <td>{{ $detail['product_name'] }}</td>
                    <td>{{ $detail['quantity'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
