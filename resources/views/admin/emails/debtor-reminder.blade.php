<!DOCTYPE html>
<html>
<head>
    <title>Debtors Reminder</title>
</head>
<body>
    <h1>Unpaid Invoices</h1>
    <p>Here is a list of invoices that are overdue by more than 3 weeks:</p>

    <table border="1">
        <thead>
            <tr>
                <th>Invoice ID</th>
                <th>Invoice Date</th>
                <th>Name</th>
                <th>Company Name</th>
                <th>Country</th>
                <th>Net Amount</th>
                <th>Overdue by (Days)</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($debtors as $debtor)
                <tr>
                    <td>{{ $debtor->invoice_number }}</td>
                    <td>{{ $debtor->invoice_date ?? $debtor->created_at->format('Y-m-d') }}</td>
                    <td>{{ $debtor->customer->first_name }} {{ $debtor->customer->last_name }}</td>
                    <td>{{ $debtor->customer->company_name }}</td>
                    <td>{{ $debtor->customer->billing_country }}</td>
                    <td>{{ number_format($debtor->total, 2) }}</td>
                    <td>{{ $debtor->overdue_days }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>