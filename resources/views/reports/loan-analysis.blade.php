<!DOCTYPE html>
<html>
<head>
    <title>Loan Analysis Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>Loan Analysis Report</h1>
    <table>
        <thead>
            <tr>
                <th>Loan Officer</th>
                <th>NOL</th>
                <th>Principal</th>
                <th>Interest</th>
                <th>On Time</th>
                <th>Overdue 1-30</th>
                <th>#</th>
                <th>Overdue 31-60</th>
                <th>#</th>
                <th>Overdue 61-90</th>
                <th>#</th>
                <th>Overdue 91-180</th>
                <th>#</th>
                <th>Overdue 180+</th>
                <th>#</th>
            </tr>
        </thead>
        <tbody>
            @foreach($report['report'] as $data)
            <tr>
                <td>{{ $data['loan_officer'] }}</td>
                <td>{{ $data['nol'] }}</td>
                <td>{{ $data['principal'] }}</td>
                <td>{{ $data['interest'] }}</td>
                <td>{{ $data['ontime']['amount'] }} ({{ $data['ontime']['percentage'] }}%)</td>
                <td>{{ $data['overdue_1_30']['amount'] }} ({{ $data['overdue_1_30']['percentage'] }}%)</td>
                <td>{{ $data['overdue_1_30']['count'] }}</td>
                <td>{{ $data['overdue_31_60']['amount'] }} ({{ $data['overdue_31_60']['percentage'] }}%)</td>
                <td>{{ $data['overdue_31_60']['count'] }}</td>
                <td>{{ $data['overdue_61_90']['amount'] }} ({{ $data['overdue_61_90']['percentage'] }}%)</td>
                <td>{{ $data['overdue_61_90']['count'] }}</td>
                <td>{{ $data['overdue_91_180']['amount'] }} ({{ $data['overdue_91_180']['percentage'] }}%)</td>
                <td>{{ $data['overdue_91_180']['count'] }}</td>
                <td>{{ $data['overdue_180_plus']['amount'] }} ({{ $data['overdue_180_plus']['percentage'] }}%)</td>
                <td>{{ $data['overdue_180_plus']['count'] }}</td>
            </tr>
            @endforeach
        </tbody>
        <tbody>
            <tr>
                <td>principal: {{ $report['item']['principal'] }}</td>
                <td>interest: {{ $report['item']['interest'] }}</td>
                <td>ontime: {{ $report['item']['ontime'] }}</td>
                <td>overdue_1_30: {{ $report['item']['overdue_1_30'] }}</td>
                <td>overdue_31_60: {{ $report['item']['overdue_31_60'] }}</td>
                <td>overdue_61_90: {{ $report['item']['overdue_61_90'] }}</td>
                <td>overdue_91_180: {{ $report['item']['overdue_91_180'] }}</td>
                <td>overdue_180_plus: {{ $report['item']['overdue_180_plus'] }}</td>
                <td>ontime_count: {{ $report['item']['ontime_count'] }}</td>
                <td>overdue_1_30_count: {{ $report['item']['overdue_1_30_count'] }}</td>
                <td>overdue_31_60_count: {{ $report['item']['overdue_31_60_count'] }}</td>
                <td>overdue_61_90_count: {{ $report['item']['overdue_61_90_count'] }}</td>
                <td>overdue_91_180_count: {{ $report['item']['overdue_91_180_count'] }}</td>
                <td>overdue_180_plus_count: {{ $report['item']['overdue_180_plus_count'] }}</td>
            </tr>
        </tbody>
    </table>
</body>
</html>
