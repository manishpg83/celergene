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
        .bank-details p strong.bank-name {
            margin-top: 5px;
            display: inline-block;
        }
        
        .bank-details p strong.bank-name-text {
            margin-top: 10px;
            display: inline-block;
        }
    </style>
</head>
<body>
    <div class="logo-container">
        <img src="{{ public_path('storage/logo.png') }}" alt="Company Logo">
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
            <strong>TERMS:</strong> {{ $invoice->payment_terms ?? 'N/A' }}
        </div>
    </div>
    <table>
        <thead>
            <tr>
                <th>DESCRIPTION</th>
                <th>QUANTITY</th>
                <th>UNIT PRICE</th>
                <th>TOTAL AMOUNT</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($invoice->invoiceDetails as $invoiceDetail)
                <tr>
                    <td>{{ $invoiceDetail->product->product_name }}</td>
                    <td>{{ $invoiceDetail->quantity }}</td>
                    <td>{{ number_format($invoiceDetail->unit_price, 2) }}</td>
                    <td>{{ number_format($invoiceDetail->total, 2) }}</td>
                </tr>
            @endforeach
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
                    <td>{{ number_format($invoice->subtotal, 2) }}</td>
                </tr>
                <tr>
                    <td>FREIGHT</td>
                    <td><span style="color: green;">+{{ number_format($invoice->freight, 2) }}</span></td>
                </tr>
                <tr>
                    <td>TAX</td>
                    <td><span style="color: green;">+{{ number_format($invoice->tax, 2) }}</span></td>
                </tr>
                <tr>
                    <td><strong>TOTAL</strong></td>
                    <td><strong>{{ number_format($invoice->total, 2) }}</strong></td>
                </tr>
            </table>
        </div>
    </div>
</body>
</html>