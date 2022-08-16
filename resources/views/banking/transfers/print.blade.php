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
                <th>Name</th>
                <th>Value</th>
            </tr>
        </thead>
        <tbody>
                <tr>
                    <td>Transfer Date</td>
                    <td>{{date_format($bank_transfer->created_at,"Y/m/d")}}</td>
                </tr>
                <tr>
                    <td>Transfer Amount</td>
                    <td>{{$bank_transfer->amount}}</td>
                </tr>
                <tr>
                    <td>Transfer Status</td>
                    <td>{{$bank_transfer->status}}</td>
                </tr>
                <tr>
                    <td>From Account</td>
                    <td>{{$bank_transfer->fromAccount->chartOfAccount->account_name}}</td>
                </tr>
                <tr>
                    <td>To Account</td>
                    <td>{{$bank_transfer->toAccount->chartOfAccount->account_name}}</td>
                </tr>
        </tbody>
    </table>
</body>
</html>