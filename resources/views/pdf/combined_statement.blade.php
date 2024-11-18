
<!-- resources/views/reports/combined-report.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #ddd; padding: 5px; text-align: left; }
        th { background-color: #f5f5f5; }
        .text-right { text-align: right; }
        .total-row { font-weight: bold; background-color: #f5f5f5; }
    </style>

    <title>{{ $type }} - {{ $loan->reference }}</title>
</head>
<body>
    <table class="table table-bordered table-striped">
        <thead>
            <tr class="company">
                <th>
                        <img src="{{ env('APP_URL') . '/' . $company->logo }}" width="80px" height="90px">
                </th>
                <th colspan="5">
                    <b>{{ $company->name }}</b><br>
                    <b>{{ $company->address }}</b><br>
                    <b> Email:{{ $company->email }} </b><br>
                    <b> Website:{{ $company->website }} </b>
                </th>

            </tr>
        </thead>
    </table>


    <h2>{{ ($type) }} Report</h2>
    <p>Loan Reference: {{ $loan->reference }}</p>
    @if ($type === 'Combined' || $type === 'Payment')
    <h3>Payment Schedule</h3>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Date</th>
                <th class="text-right">Principal B/F</th>
                <th class="text-right">Interest</th>
                <th class="text-right">Principal</th>
                <th class="text-right">Total</th>
                <th class="text-right">Principal C/F</th>
                <th class="text-right">Balance C/F</th>
            </tr>
        </thead>
        <tbody>
            @foreach($schedule as $index => $item)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $item['date'] }}</td>
                <td class="text-right">{{ number_format($item['principal_bf'], 2) }}</td>
                <td class="text-right">{{ number_format($item['interest'], 2) }}</td>
                <td class="text-right">{{ number_format($item['principal'], 2) }}</td>
                <td class="text-right">{{ number_format($item['total'], 2) }}</td>
                <td class="text-right">{{ number_format($item['principal_cf'], 2) }}</td>
                <td class="text-right">{{ number_format($item['balance_cf'], 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endIf

    @if ($type === 'Combined' || $type === 'Client')

    <h3>Payment Transactions</h3>
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


            @foreach($payments as $index => $payment)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $payment['date'] }}</td>
                <td>{{ $payment['type'] }}</td>
                <td>{{ $payment['loan_ref'] }}</td>
                <td>{{ $payment['details'] }}</td>
                <td>{{ $payment['reference'] }}</td>
                <td class="text-right">{{ number_format($payment['debit'], 2) }}</td>
                <td class="text-right">{{ number_format($payment['credit'], 2) }}</td>
                <td class="text-right">{{ number_format($payment['balance'], 2) }}</td>
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

    @endif
</body>
</html>
