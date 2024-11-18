<!-- resources/views/reports/repayment-schedule.blade.php -->
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
    <title>Client Statment</title>
    </head>
<body>
    <h2>Loan Repayment Schedule</h2>
    <p>Loan Reference: {{ $loan->reference }}</p>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Date</th>
                <th>Type</th>
                <th>Loan Ref</th>
                <th>Details</th>
                <th>Reference</th>
                <th class="text-right">Debit</th>
                <th class="text-right">Credit</th>
                <th class="text-right">Balance</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transactions as $index => $transaction)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $transaction['date'] }}</td>
                <td>{{ $transaction['type'] }}</td>
                <td>{{ $transaction['loan_ref'] }}</td>
                <td>{{ $transaction['details'] }}</td>
                <td>{{ $transaction['reference'] }}</td>
                <td class="text-right">{{ number_format($transaction['debit'], 2) }}</td>
                <td class="text-right">{{ number_format($transaction['credit'], 2) }}</td>
                <td class="text-right">{{ number_format($transaction['balance'], 2) }}</td>
            </tr>
            @endforeach
            <tr class="total-row">
                <td colspan="6">Total</td>
                <td class="text-right">{{ number_format($totals['debit'], 2) }}</td>
                <td class="text-right">{{ number_format($totals['credit'], 2) }}</td>
                <td class="text-right">{{ number_format($totals['balance'], 2) }}</td>
            </tr>
        </tbody>
    </table>
</body>
</html>
