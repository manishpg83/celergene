<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice #{{ $invoice->invoice_number }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #333;
            margin: 0;
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
            margin-bottom: 20px;
        }
        .logo-container img {
            height: 40px;
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
            border: 2px solid #000;
            min-height: 100px;
        }
        .billing-address,
        .shipping-address,
        .invoice-details {
            width: 31.5%;
            float: left;
            padding: 8px;
            box-sizing: border-box;
        }
        .billing-address strong,
        .shipping-address strong {
            display: inline-block;
            margin-bottom: 2px;
        }
        .shipping-address {
            text-align: left;
        }
        .invoice-details {
            text-align: left;
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
            border: 2px solid #000;
            margin-bottom: 0px;
        }
        td {
            border-left: 2px solid #000;
            border-right: 2px solid #000;
            padding: 3px 10px;
            text-align: left;
        }
        th {
            background-color: #A6A6A6;
            padding: 12px 10px;
            text-align: left;
        }
        .item-table {
            margin-top: -2px;
        }
        table tr th:last-child, table tr td:last-child {
            text-align: right;
        }
        .summary-section {
            width: 100%;
            display: table;
            margin-top: -2px;
        }
        .summary-section .left,
        .summary-section .right {
            display: table-cell;
            vertical-align: top;
        }
        .left {
            width: 50%;
            padding-right: 20px;
        }
        .right {
            width: 50%;
        }
        .totals table {
            width: 100%;
            border-collapse: collapse;
        }
        .totals td {
            padding: 15px 10px;
            border: 2px solid #000000;
            text-align: left;
        }
        .totals tr:last-child td {
            font-weight: bold;
        }
        .bank-details p strong.bank-name {
            margin-top: 5px;
            display: inline-block;
        }
        .totals tr td:first-child {
            width: 60%;
        }
        .totals tr td:last-child {
            width: 40%;
        }
        .bank-details p strong.bank-name-text {
            margin-top: 10px;
            display: inline-block;
        }
        .line {
            background: #000000;
            width: 100%;
        }
        .blankspace td {
            padding: 10px;
            height: 150px;
        }
    </style>
</head>
<body>
    <div class="logo-container">
        <img src="{{ public_path('admin/assets/img/branding/Celergen-Logo.png') }}" alt="Company Logo">
    </div>
    <div class="header">
        <div class="company-name">{{ $invoice->company_name }}</div>
        <div class="invoice-text">INVOICE #{{ $invoice->invoice_number }}</div>
    </div>
    <div>
        <div class="company-address">{{ $invoice->company_address }}</div>
    </div>
    <div class="addresses">
        <div class="billing-address">
            <strong>Billing Address</strong><br>
            {{ $customer->first_name }} {{ $customer->last_name }}<br>
            {{ $customer->billing_address }}<br>
            VAT No: {{ $customer->vat_number }}
        </div>
        <div class="shipping-address">
            <strong>Shipping Address</strong><br>
            {{ $invoice->shipping_address }}
        </div>
        <div class="invoice-details">
            <strong>INVOICE NO:</strong> {{ $invoice->invoice_number }}<br>
            <strong>INVOICE DATE:</strong> {{ date('d/m/Y', strtotime($invoice->created_at)) }}<br>
            <hr class="line">
            <strong>TERMS:</strong> {{ $invoice->payment_terms ?? 'N/A' }}
        </div>
    </div>
    <table class="item-table">
        <thead>
            <tr>
                <th style="width: 50%;">DESCRIPTION</th>
                <th style="width: 15%;">QUANTITY</th>
                <th style="width: 15%;">UNIT PRICE</th>
                <th style="width: 20%;">TOTAL AMOUNT</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($invoice->invoiceDetails as $invoiceDetail)
                <tr>
                    <td style="width: 50%;">{{ $invoiceDetail->product->product_name }}</td>
                    <td style="width: 15%;">{{ $invoiceDetail->quantity }}</td>
                    <td style="width: 15%;">${{ number_format($invoiceDetail->unit_price, 2) }}</td>
                    <td style="width: 20%;">${{ number_format($invoiceDetail->total, 2) }}</td>
                </tr>
            @endforeach
            <tr class="blankspace">
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        </tbody>
    </table>
    <div class="summary-section">
        <div class="left bank-details">
            {{-- <p><strong>DIRECT ALL INQUIRIES TO: </strong> info@example.com</p>
            <p><strong>Bank Charges must be borne by payer</strong></p>
            <p>For payment by Telegraphic Transfer:<br>
                <strong class="bank-name-text">Account No:</strong> {{ $invoice->company_bank_account_number }}<br>
                <strong class="bank-name">Bank Name:</strong> {{ $invoice->company_bank_name }}<br>
                <strong class="bank-name">SWIFT:</strong> {{ $invoice->company_bank_swift_code }}
            </p> --}}
        </div>
        <div class="right totals">
            <table>
                <tr>
                    <td>SUBTOTAL</td>
                    <td>${{ number_format($invoice->subtotal, 2) }}</td>
                </tr>
                <tr>
                    <td>FREIGHT</td>
                    <td style="color: green"><span>${{ number_format($invoice->freight, 2) }}</span></td>
                </tr>
                <tr>
                    <td>TAX</td>
                    <td style="color: green"><span>${{ number_format($invoice->tax, 2) }}</span></td>
                </tr>
                <tr>
                    <td><strong>TOTAL</strong></td>
                    <td><strong>${{ number_format($invoice->total, 2) }}</strong></td>
                </tr>
            </table>
        </div>
    </div>
</body>
</html>