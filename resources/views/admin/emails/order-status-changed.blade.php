<!DOCTYPE html>
<html>
<head>
    <title>Payment Receipt</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
            color: #000;
            margin: 0;
            padding: 30px;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
        }
        .section {
            margin-bottom: 12px;
        }
        p {
            margin: 2px 0;
        }
        .billing-address {
            margin-top: 10px;
        }
        .billing-address strong {
            font-weight: bold;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            font-size: 14px;
        }
        table thead th {
            padding: 8px 4px;
            border-bottom: 1px solid #000;
            text-align: left;
        }
        table tbody td {
            padding: 6px 4px;
            border-bottom: 1px solid #000;
        }
        .totals {
            width: 250px;
            float: right;
            margin-top: 15px;
            font-size: 14px;
        }
        .totals td {
            padding: 6px 4px;
        }
        .totals tr:last-child td {
            font-weight: bold;
        }
        .text-right {
            text-align: right;
        }
    </style>
</head>
<body>
<div class="container">

    <div class="section">
        <p>Payment Received : USD{{ number_format($order->total, 2) }}</p>
        <p>Received Date: {{ date('d-m-Y', strtotime($payment->payment_date ?? now())) }}</p>
        <p>Reference : {{ $payment->payment_reference ?? 'N/A' }}</p>
        <p>From : {{ $order->customer->first_name }} {{ $order->customer->last_name }}</p>
        <p>Updated by : {{ $order->modifier->name ?? 'SYSTEM' }}</p>
    </div>

    <div class="billing-address">
        <p><strong>Billing Address:</strong></p>
        <p>{{ env('APP_NAME', 'Celergen') }} Inc</p>
        <p>{{ $order->customer->first_name }} {{ $order->customer->last_name }}</p>
        <p>{{ $order->customer->billing_address }}</p>
        <p>{{ $order->customer->billing_city }}, {{ $order->customer->billing_state }}, {{ $order->customer->billing_postal_code }}</p>
        <p>{{ $order->customer->billing_country }}</p>
        <p>Phone : {{ $order->customer->billing_phone ?? $order->customer->mobile_number ?? 'N/A' }}</p>
    </div>

    <div class="section">
        <p>Order Date : {{ date('F d, Y', strtotime($order->order_date)) }}</p>
        <p>Order No : {{ $order->order_number }}</p>
    </div>

    <table>
        <thead>
        <tr>
            <th>Item Name</th>
            <th>Total Quantity</th>
            <th>Price (USD)</th>
        </tr>
        </thead>
        <tbody>
        @foreach($order->orderDetails as $detail)
            <tr>
                <td>{{ $detail->product->product_name ?? $detail->manual_product_name }}</td>
                <td>{{ $detail->quantity }}</td>
                <td>{{ number_format($detail->unit_price * $detail->quantity, 2) }}</td>
            </tr>
        @endforeach
        @if($order->discount > 0)
            <tr>
                <td>Others</td>
                <td>1</td>
                <td>-{{ number_format($order->discount, 2) }}</td>
            </tr>
        @endif
        </tbody>
    </table>

    <table class="totals">
        <tr>
            <td>Sub Total</td>
            <td class="text-right">{{ number_format($order->subtotal, 2) }}</td>
        </tr>
        <tr>
            <td>Freight</td>
            <td class="text-right">{{ $order->freight > 0 ? number_format($order->freight, 2) : 'Free' }}</td>
        </tr>
        <tr>
            <td>Net Total</td>
            <td class="text-right">{{ number_format($order->total, 2) }}</td>
        </tr>
    </table>

</div>
</body>
</html>
