<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Receipt</title>

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
    <h1>Deposits</h1>
    <table class="text-center">
        <thead>
            <tr>
                <th>Name</th>
                <th>Value</th>
            </tr>
        </thead>
        <tbody>
                <tr>
                    <td>Status</td>
                    <td>{{ $deposits->status }}</td>
                </tr>
                <tr>
                    <td>Deposit Ticket Date</td>
                    <td>{{ $deposits->deposit_ticket_date }}</td>
                </tr>
                <tr>
                    <td>Total Amount</td>
                    <td>{{ $deposits->total_amount }}</td>
                </tr>
                <tr>
                    <td>Account Name</td>
                    <td>{{ $deposits->chartOfAccount->account_name }}</td>
                </tr>
        </tbody>
    </table>
</body>
</html>