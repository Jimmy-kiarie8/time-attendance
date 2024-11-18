<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ env('APP_NAME') }} Report</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 3px;
            text-align: left;
            font-size: 12px;
        }

        th {
            background-color: #f2f2f2;
        }

        .company th {
            font-size: 17px;
            border: none !important;
        }
    </style>
</head>

<body>
    <table class="table table-bordered table-striped">
        <thead>
            <tr class="company">
                <th>
                    @if ($filetype === 'pdf')
                        <img src="{{ env('APP_URL') . '/' . $company->logo }}" width="190px" height="90px">
                    @else
                        <img src="{{ env('APP_URL') . '/' . $company->logo }}" width="150px" height="90px"><br>
                    @endif
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
    <h1>{{ ucfirst($report_type) }} Report</h1>
    <table>
        <thead>
            <tr>
                @foreach ($headers as $header)
                    <th>{{ $header['title'] }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $row)
                <tr>
                    @foreach ($headers as $header)
                    <td>{{ $row[$header['key']] }}</td>  <!-- Accessing array data -->

                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>

    @if ($report_type === 'Transactions')
        <p><strong>Total: {{ number_format($total, 2) }}</strong></p>
    @endif
</body>

</html>
