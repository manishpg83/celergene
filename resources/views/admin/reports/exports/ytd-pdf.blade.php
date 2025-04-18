<!DOCTYPE html>
<html>
<head>
    <title>YTD Report - {{ $year }}</title>
    <style>
        body { font-family: Arial, sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .total-row { font-weight: bold; background-color: #f9f9f9; }
        .header { margin-bottom: 30px; text-align: center; }
        .section { margin-bottom: 40px; }
        .section-title { background-color: #e9ecef; padding: 10px; margin-bottom: 15px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Year-To-Date Sales Report</h1>
        <h3>Year: {{ $year }}</h3>
    </div>

    <div class="section">
        <div class="section-title">
            <h2>YTD SALES BY CUSTOMER TYPE</h2>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Type</th>
                    <th># of boxes</th>
                    <th>Total Amount (USD)</th>
                </tr>
            </thead>
            <tbody>
                @foreach($customerTypes as $type)
                    <tr @if($type['type'] === 'Grand Total') class="total-row" @endif>
                        <td>{{ $type['type'] }}</td>
                        <td>{{ number_format($type['boxes'], 2) }}</td>
                        <td>${{ number_format($type['amount'], 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="section">
        <div class="section-title">
            <h2>YTD SALES BY COUNTRY (ONLINE)</h2>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Country</th>
                    <th># of boxes</th>
                    <th>Total Amount (USD)</th>
                </tr>
            </thead>
            <tbody>
                @foreach($onlineCountries as $country)
                    <tr>
                        <td>{{ $country['country'] }}</td>
                        <td>{{ number_format($country['boxes'], 2) }}</td>
                        <td>${{ number_format($country['amount'], 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="section">
        <div class="section-title">
            <h2>YTD SALES BY COUNTRY (CORPORATE CLIENTS)</h2>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Country</th>
                    <th># of boxes</th>
                    <th>Total Amount (USD)</th>
                </tr>
            </thead>
            <tbody>
                @foreach($corporateCountries as $country)
                    <tr>
                        <td>{{ $country['country'] }}</td>
                        <td>{{ number_format($country['boxes'], 2) }}</td>
                        <td>${{ number_format($country['amount'], 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>