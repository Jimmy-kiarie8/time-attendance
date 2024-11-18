<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f5f5f5; }
        .text-right { text-align: right; }
        .total-row { font-weight: bold; background-color: #f5f5f5; }
    </style>
    <title>Repayment Statment</title>
</head>
<body>
    <h2>Repayment Statement</h2>
    <p><strong>Borrower:</strong> {{ $loan->client->name }} (ID: {{ $loan->id_no }})</p>
    <p><strong>Loan Officer:</strong> {{ $loan->officer->name }}</p>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Date</th>
                <th>Principal</th>
                <th>Interest</th>
                <th>Total Payment</th>
                <th>Balance</th>
            </tr>
        </thead>
        <tbody>
            @foreach($repaymentSchedule as $schedule)
                <tr>
                    <td>{{ $schedule['installment_number'] }}</td>
                    <td>{{ $schedule['date'] }}</td>
                    <td>{{ $schedule['principal'] }}</td>
                    <td>{{ $schedule['interest'] }}</td>
                    <td>{{ $schedule['total_payment'] }}</td>
                    <td>{{ $schedule['balance'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
