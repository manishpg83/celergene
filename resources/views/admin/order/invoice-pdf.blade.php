<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Invoice #{{ $order->invoice_id }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #333;
            margin: 0;
            padding: 20px;
        }

        .header {
            overflow: hidden;
            margin-bottom: 8px;
            padding: 10px;
            background-color: #808080;
            color: white;
        }

        .company-address {
            margin-bottom: 15px;
        }

        .header .company-name {
            float: left;
            font-size: 18px;
            font-weight: bold;
        }

        .header .invoice-text {
            float: right;
            font-size: 18px;
            font-weight: bold;
        }

        .header::after {
            content: "";
            display: table;
            clear: both;
        }

        .addresses {
            overflow: hidden;
            margin-bottom: 20px;
            border: 1px solid #000;

        }

        .billing-address,
        .shipping-address,
        .invoice-details {
            width: 30%;
            float: left;
            padding: 10px;
            box-sizing: border-box;
        }

        .shipping-address {
            text-align: center;
        }

        .invoice-details {
            text-align: right;
        }

        .addresses::after {
            content: "";
            display: table;
            clear: both;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 8px;
            text-align: center;
        }

        th {
            background-color: #f0f0f0;
        }

        .summary-section {
            width: 100%;
            margin-top: 30px;
            display: table;
        }

        .summary-section .left,
        .summary-section .right {
            display: table-cell;
            vertical-align: top;
        }

        .left {
            width: 60%;
            padding-right: 20px;
        }

        .right {
            width: 35%;
        }

        .totals table {
            width: 100%;
            border-collapse: collapse;
        }

        .totals td {
            padding: 5px;
            border: 1px solid #ddd;
            text-align: right;
        }

        .totals tr:last-child td {
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="header">
        <div class="company-name">{{ $order->entity->company_name }}</div>
        <div class="invoice-text">INVOICE</div>
    </div>
    <div>
        <div class="company-address">{{ $order->entity->address }}</div>
    </div>

    <div class="addresses">
        <div class="billing-address">
            <strong>Billing Address</strong><br>
            {{ $order->customer->first_name }} {{ $order->customer->last_name }}<br>
            {{ $order->customer->billing_address }}<br>
            VAT No: {{ $order->customer->vat_number }}
        </div>
        <div class="shipping-address">
            <strong>Shipping Address</strong><br>
            {{ $order->shipping_address }}
        </div>
        <div class="invoice-details">
            <strong>INVOICE NO:</strong> {{ $order->invoice_id }}<br>
            <strong>INVOICE DATE:</strong> {{ date('d/m/Y', strtotime($order->invoice_date)) }}<br>
            <strong>TERMS:</strong> {{ $order->payment_terms }}
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>DESCRIPTION</th>
                <th>QUANTITY</th>
                <th>UNIT PRICE</th>
                <th>DISCOUNT</th>
                <th>TOTAL AMOUNT</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($order->orderDetails as $detail)
                <tr>
                    <td>{{ $detail->product->product_name }}</td>
                    <td>{{ $detail->quantity }}</td>
                    <td>{{ number_format($detail->unit_price, 2) }}</td>
                    <td>${{ number_format($detail->discount, 2) }}</td>
                    <td>{{ number_format($detail->total, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="summary-section">
        <div class="left bank-details">
            <p><strong>DIRECT ALL INQUIRIES TO: </strong> info@example.com</p>

            <p><strong>Bank Charges must be borne by payer</strong></p>

            <p>For payment by Telegraphic Transfer:<br>
                <strong>Account No:</strong> {{ $order->entity->bank_account_number }}<br>
                <strong>Bank Name:</strong> {{ $order->entity->bank_account_name }}<br>
                <strong>SWIFT:</strong> {{ $order->entity->bank_swift_code }}
            </p>
        </div>

        <div class="right totals">
            <table>
                <tr>
                    <td>SUBTOTAL</td>
                    <td>{{ number_format($order->subtotal, 2) }}</td>
                </tr>
                <tr>
                    <td>TOTAL DISCOUNT</td>
                    <td><span style="color: red;">-{{ number_format($order->discount, 2) }}</span></td>
                </tr>
                <tr>
                    <td>TAX</td>
                    <td><span style="color: green;">+{{ number_format($order->tax, 2) }}</span></td>
                </tr>
                <tr>
                    <td><strong>TOTAL</strong></td>
                    <td><strong>{{ number_format($order->total, 2) }}</strong></td>
                </tr>
            </table>
        </div>
    </div>
</body>

</html>
