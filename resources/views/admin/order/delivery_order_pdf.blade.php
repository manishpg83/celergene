<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Delivery Order #{{ $deliveryOrder->delivery_number }}</title>
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

        .logo-container {
            text-align: center;
            margin-bottom: 40px;
        }

        .logo-container img {
            height: 60px;
            width: auto;
            object-fit: contain;
        }

        .company-address {
            margin-bottom: 15px;
        }

        .header .company-name {
            float: left;
            font-size: 18px;
            font-weight: bold;
        }

        .header .delivery-text {
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

        .customer-details,
        .warehouse-details,
        .delivery-details {
            width: 30%;
            float: left;
            padding: 10px;
            box-sizing: border-box;
        }

        .warehouse-details {
            text-align: center;
        }

        .delivery-details {
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

        .contact-details p {
            margin: 5px 0;
        }
    </style>
</head>

<body>
    <div class="logo-container">
        <img src="{{ public_path('storage/logo.png') }}" alt="Company Logo">
    </div>

    <div class="header">
        <div class="company-name">{{ $entity->company_name ?? 'Your Company Name' }}</div>
        <div class="delivery-text">DELIVERY ORDER</div>
    </div>

    <div>
        <div class="company-address">{{ $entity->address ?? 'Company Address' }}</div>
    </div>

    <div class="addresses">
        <div class="customer-details">
            <strong>Customer Details</strong><br>
            {{ $customer->first_name }} {{ $customer->last_name }}<br>
            {{ $customer->billing_address }}<br>
            VAT No: {{ $customer->vat_number }}
        </div>
        <div class="warehouse-details">
            <strong>Warehouse Details</strong><br>
            {{ $deliveryOrder->warehouse->warehouse_name }}<br>
            {{ $deliveryOrder->warehouse->address }}
        </div>
        <div class="delivery-details">
            <strong>DELIVERY ORDER NO:</strong> {{ $deliveryOrder->delivery_number }}<br>
            <strong>DELIVERY DATE:</strong> {{ date('d/m/Y', strtotime($deliveryOrder->delivery_date)) }}<br>
            <strong>REFERENCE:</strong> {{ $deliveryOrder->reference_number ?? 'N/A' }}
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>PRODUCT NAME</th>
                <th>QUANTITY</th>
                <th>SAMPLE QTY</th>
                <th>UNIT PRICE</th>
                <th>TOTAL AMOUNT</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($allDetails as $detail)
                <tr>
                    <td>{{ $detail->product->product_name }}</td>
                    <td>{{ $detail->quantity }}</td>
                    <td>{{ $detail->sample_quantity }}</td>
                    <td>{{ number_format($detail->unit_price, 2) }}</td>
                    <td>{{ number_format($detail->total, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="summary-section">
        <div class="left contact-details">
            <p><strong>DIRECT ALL INQUIRIES TO:</strong> info@example.com</p>
            <p><strong>Note:</strong> This is a delivery order, not a tax invoice</p>
        </div>

        <div class="right totals">
            <table>
                <tr>
                    <td>SUBTOTAL</td>
                    <td>{{ number_format($allDetails->sum('total'), 2) }}</td>
                </tr>
            </table>
        </div>
    </div>
</body>

</html>
