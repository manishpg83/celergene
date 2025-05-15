<!DOCTYPE html>
<html>

<head>
    <title>Debtors List</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            font-size: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #888;
            padding: 6px 4px;
            text-align: left;
            vertical-align: middle;
            font-size: 10px;
        }

        th {
            background-color: #e0e0e0;
            font-weight: bold;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .amount {
            text-align: right;
        }

        .center {
            text-align: center;
        }

        h2 {
            text-align: center;
            font-size: 16px;
            margin-bottom: 10px;
        }
    </style>
</head>

<body>
    <h2>Debtors List</h2>

    <table>
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Invoice ID</th>
                <th>Invoice Date</th>
                <th>Name</th>
                <th>Company Name</th>
                <th>Country</th>
                <th>Net Amount</th>
                <th>Paid Amount</th>
                <th>Balance</th>
                <th>Over due by (Days)</th>
                <th>Created By</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($debtors as $debtor)
                <tr>
                    <td>{{ $debtor->order_id }}</td>
                    <td>{{ $debtor->invoice_number }}</td>
                    <td>{{ $debtor->invoice_date ?? $debtor->created_at->format('Y-m-d') }}</td>
                    <td>{{ $debtor->customer->first_name }} {{ $debtor->customer->last_name }}</td>
                    <td>{{ $debtor->customer->company_name }}</td>
                    <td>{{ $debtor->customer->billing_country }}</td>
                    <td class="amount">
                        {{ number_format($debtor->order->total ?? 0, 2) }}
                    </td class="amount">
                    <td>{{ $debtor->currencySymbol }}{{ number_format($debtor->totalPaid, 2) }}</td>
                    <td> {{ number_format($debtor->total, 2) }}<br>
                    </td>
                    <td class="center">{{ $debtor->overdue_days }}</td>
                    <td>{{ $debtor->createdBy->name }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" style="text-align: center;">No debtors found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>

</html>
