<!DOCTYPE html>
<html>

<head>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 5px;
            text-align: left;
        }

        th {
            background-color: #f5f5f5;
        }

        .text-right {
            text-align: right;
        }

        .total-row {
            font-weight: bold;
            background-color: #f5f5f5;
        }
    </style>
    <title>Client Statement</title>
</head>

<body>
    <h2>Client Statement</h2>
    <p><strong>Borrower:</strong> {{ $loan->client->name }} (ID: {{ $loan->id_no }})</p>
    <p><strong>Loan Officer:</strong> {{ $loan->officer->name }}</p>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Date</th>
                <th>Type</th>
                <th>Loan Ref</th>
                <th>Details</th>
                <th>Reference</th>
                <th>Debit</th>
                <th>Credit</th>
                <th>Balance</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($combinedStatement as $entry)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $entry['date'] ?? 'N/A' }}</td>
                    <td>{{ $entry['type'] ?? 'N/A' }}</td>
                    <td>{{ $entry['loan_ref'] ?? 'N/A' }}</td>
                    <td>{{ $entry['details'] ?? 'N/A' }}</td>
                    <td>{{ $entry['reference'] ?? 'N/A' }}</td>
                    <td>{{ $entry['debit'] ?? '0.00' }}</td>
                    <td>{{ $entry['credit'] ?? '0.00' }}</td>
                    <td>{{ $entry['balance'] ?? '0.00' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>


</body>

</html>
