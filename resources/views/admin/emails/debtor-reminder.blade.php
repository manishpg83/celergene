<!DOCTYPE html>
<html>
<head>
    <title>Debtors Reminder</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        th, td {
            padding: 8px 12px;
            text-align: left;
            border: 1px solid #ddd;
        }
        th {
            background-color: #f5f5f5;
            font-weight: bold;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
    </style>
</head>
<body>
    <h1>Unpaid Invoices</h1>
    <p>Here is a list of invoices that are overdue by more than 1 week:</p>

    <table>
        <thead>
            <tr>
                <th>Sr. No.</th>
                <th>Order ID</th>
                <th>Invoice Number</th>
                <th>Invoice Date</th>
                <th>Customer Name</th>
                <th>Company Name</th>
                <th>Country</th>
                <th>Total Amount</th>
                <th>Total Paid</th>
                <th>Pending Amount</th>
                <th>Overdue by (Days)</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($debtors as $index => $debtor)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $debtor->order_id }}</td>
                    <td>{{ $debtor->invoice_number }}</td>
                    <td>{{ $debtor->invoice_date ?? $debtor->created_at->format('Y-m-d') }}</td>
                    <td>{{ $debtor->customer->first_name }} {{ $debtor->customer->last_name }}</td>
                    <td>{{ $debtor->customer->company_name }}</td>
                    <td>{{ $debtor->customer->billing_country }}</td>
                    <td>{{ $debtor->currencySymbol }}{{ number_format($debtor->order->total ?? 0, 2) }}</td>
                    <td>{{ $debtor->currencySymbol }}{{ number_format($debtor->totalPaid, 2) }}</td>
                    <td>{{ $debtor->currencySymbol }}{{ number_format($debtor->pendingAmount, 2) }}</td>
                    <td>{{ $debtor->overdue_days }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="11" style="text-align: center;">No overdue invoices found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>