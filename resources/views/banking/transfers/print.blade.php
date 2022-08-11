<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Bank Transfer</title>

    <style>
        .page-break {
            page-break-after: always;
        }

        .text-center {
            text-align: center;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

    </style>
</head>
<body>
    <h3>Bank Transfer</h3>
    <table class="text-center">
        <thead>
            <tr>
                <th>From Account</th>
                <th>To Account</th>
                <th>Amount</th>
                <th>Date</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
                <tr>
                    <td>{{ $transfers->fromAccount->chartOfAccount->account_name }}</td>
                    <td>{{ $transfers->toAccount->chartOfAccount->account_name }}</td>
                    <td>{{ $transfers->amount }}</td>
                    <td>{{ date_format($transfers->created_at, "Y-m-d") }}</td>
                    <td>{{ $transfers->status }}</td>
                </tr>
        </tbody>
    </table>
</body>
</html>