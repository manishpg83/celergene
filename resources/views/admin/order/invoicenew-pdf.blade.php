<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Invoice #{{ $order->customer->first_name }} {{ $order->customer->last_name }}</title>
       <!-- Icons -->
       <link rel="stylesheet" href="{{ asset('/admin/assets/vendor/fonts/fontawesome.css') }}" />
       <link rel="stylesheet" href="{{ asset('/admin/assets/vendor/fonts/tabler-icons.css') }}" />
       <link rel="stylesheet" href="{{ asset('/admin/assets/vendor/fonts/flag-icons.css') }}" />
    <style>
        body {
            font-family:  Arial, sans-serif,'DejaVu Sans';
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
            margin-bottom: 30px;
        }

        .logo-container img {
            height: 40px;
            width: auto;
            object-fit: contain;
        }

        .company-address {
            margin-bottom: 20px;
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
            margin-bottom: 0px;
            border: 2px solid #000;
            min-height: 100px;
        }

        .billing-address strong,
        .shipping-address strong {
            display: inline-block;
            margin-bottom: 2px;
        }

        .billing-address,
        .shipping-address,
        .invoice-details {
            width: 31.5%;
            float: left;
            padding: 8px;
            box-sizing: border-box;
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
            margin-top: -2px;
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

        table tr th:last-child,
        table tr td:last-child {
            text-align: right;
        }

        .summary-section {
            width: 100%;
            display: table;
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
            width: 60%;
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

        .totals tr td:first-child {
            width: 66%;
        }

        .totals tr td:last-child {
            width: 34%;
        }

        .bank-details .bank-name {
            margin-top: 2px;
        }

        .bank-name strong,
        .bank-name span {
            display: inline-block;
        }

        .bank-details p {
            margin: 0px;
        }

        .payment-text {
            display: inline-block;
            padding-bottom: 5px;
        }

        .line {
            background: #000000;
            width: 100%;
        }

        .blankspace td {
            padding: 10px;
            height: 150px;
        }

        .footer {
            position: fixed;
            top: 99%;
            left: 0;
            width: 100%;
            text-align: center;
            font-size: 12px;
            padding: 10px 0 0 0;
        }
    </style>
</head>

<body>
    <div class="logo-container">
        <img src="{{ public_path('admin/assets/img/branding/Celergen-Logo.png') }}" alt="Company Logo">
    </div>

    <div class="header">
        <div class="company-name">{{ $order->entity->company_name }}</div>
        <div class="invoice-text">INVOICE </div>
    </div>
    <div>
        <div class="company-address" style="width: 50%; float: left;">{{ $order->entity->address }}</div>
        <div style="width: 50%; float: right; text-align: right;"><strong>Order #:</strong> {{ $order->order_number }}</div>
        <div style="clear: both;"></div>
    </div>

    <div class="addresses">
        <div class="billing-address">
            <strong>Billing Address</strong><br>
            {{ $order->customer->first_name }} {{ $order->customer->last_name }}<br>
            {{ $order->customer->billing_address }}<br>
            VAT No: {{ $order->customer->vat_number }}<br><br>
            {{ $order->customer->billing_country }}<br>
            PHONE : {{ $order->customer->mobile_number }}<br>
        </div>
        <div class="shipping-address">
            <strong>Shipping Address</strong><br>
            @php
                $addressParts = explode(',', $order->shipping_address);
        
                $addressParts = array_map('trim', $addressParts);
        
                $phoneNumber = array_pop($addressParts);
            @endphp
        
            {!! nl2br(e(str_replace(',', "\n", implode(', ', $addressParts)))) !!}
        
            @if($phoneNumber)
                <br>PHONE : {{ $phoneNumber }}
            @endif
        </div>
        
               
        <div class="invoice-details">
            <strong>INVOICE NO:</strong> {{ $invoice->invoice_number }}<br>
            <strong>INVOICE DATE:</strong> {{ \Carbon\Carbon::parse($invoice->invoice_date)->format('d-m-Y') }}<br>
            <hr class="line">
            <strong>TERMS:</strong> <br>{{ $order->payment_terms }}
        </div>
    </div>
    <table class="item-tabel">
        <thead>
            <tr>
                <th style="width: 42%;">DESCRIPTION</th>
                <th style="width: 12%;">QUANTITY</th>
                <th style="width: 12%;">SAMPLE QTY</th>
                <th style="width: 10%;">UNIT PRICE ({{ $order->currency->code ?? 'USD' }})</th>
                <th style="width: 14%;">AMOUNT ({{ $order->currency->code ?? 'USD' }})</th>
            </tr>
        </thead>
        <tbody>
            @php
                $totalRows = 18;
                $productCount = count($orderInvoiceDetails);
                $blankRows = max($totalRows - $productCount, 0);
            @endphp
    
            @foreach ($orderInvoiceDetails as $detail)
                <tr>
                    <td style="width: 42%;">{{ $detail->getDisplayDescription() }}</td>
                    <td style="width: 12%;">{{ $detail->quantity }}</td>
                    <td style="width: 12%;">{{ $detail->sample_quantity ?? 0 }}</td>
                    <td style="width: 10%;">{{ $order->currency->symbol ?? '$' }} {{ number_format($detail->unit_price, 2) }}</td>
                    <td style="width: 14%;">{{ $order->currency->symbol ?? '$' }} {{ number_format($detail->total, 2) }}</td>                    
                </tr>
            @endforeach
    
            @for ($i = 0; $i < $blankRows; $i++)
                <tr class="blank-row">
                    <td style="width: 42%;">&nbsp;</td>
                    <td style="width: 12%;">&nbsp;</td>
                    <td style="width: 12%;">&nbsp;</td>
                    <td style="width: 14%;">&nbsp;</td>
                    <td style="width: 10%;">&nbsp;</td>
                </tr>
            @endfor
    
            <tr>
                <td style="width: 42%; font-weight: bold;">
                    Country Of Origin: Switzerland <br>
                    Manufactured by: SWISSCAPS/SWITZERLAND
                </td>
                <td style="width: 12%;">&nbsp;</td>
                <td style="width: 12%;">&nbsp;</td>
                <td style="width: 14%;">&nbsp;</td>
                <td style="width: 10%;">&nbsp;</td>
            </tr>
        </tbody>
    </table>
    

    <div class="summary-section">
        <div class="left bank-details"><br>
            <p><strong>DIRECT ALL INQUIRIES TO: </strong></p>
            <a href="mailto:marketing@celergenswiss.com">marketing@celergenswiss.com</a><br><br>

            <p><strong>Bank Charges must be borne by payer</strong></p><br>

            <p><strong class="payment-text">For payment by Telegraphic Transfer:</strong></p>
            <p class="bank-name"><strong style="width: 30%;">Account
                    No:</strong><span>{{ $order->entity->bank_account_number }}</span></p>
            <p class="bank-name"><strong style="width: 30%;">Account
                    Name:</strong><span>{{ $order->entity->bank_account_name }}</span></p>
            <p class="bank-name"><strong style="width: 30%;">Bank
                    Name:</strong><span>{{ $order->entity->bank_name }}</span></p>
            <p class="bank-name"><strong style="width: 30%;">Bank
                    Address:</strong><span>{{ $order->entity->bank_address }}</span></p>
            <p class="bank-name"><strong
                    style="width: 30%;">SWIFT:</strong><span>{{ $order->entity->bank_swift_code }}</span></p>
        </div>

        <div class="right totals">
            <table>
                <tr>
                    <td>SUBTOTAL</td>
                    <td>{{ $order->currency->symbol ?? '$'}} {{ number_format($invoice->subtotal, 2) }}</td>
                </tr>
                {{-- <tr>
                    <td>TOTAL DISCOUNT</td>
                    <td><span style="color: red;">-{{ $currencySymbol }}{{ number_format($order->discount, 2) }}</span></td>
                </tr> --}}
                <tr>
                    <td>FREIGHT</td>
                    <td><span style="color: green">{{ $order->currency->symbol ?? '$' }} {{ number_format($invoice->freight, 2) }}</span></td>
                </tr>
                <tr>
                    <td>TAX</td>
                    <td><span style="color: green">{{ $order->currency->symbol ?? '$' }} {{ number_format($invoice->tax, 2) }}</span></td>
                </tr>
                <tr>
                    <td><strong>TOTAL</strong></td>
                    <td><strong>{{ $order->currency->code ?? 'USD'}} {{ $order->currency->symbol ?? '$'}} {{ number_format($invoice->total, 2) }}</strong></td>
                </tr>
            </table>
        </div>
        
    </div>
    <div class="footer">
        <p>Electronic Invoice. No Signature required</p>
    </div>
</body>

</html>
