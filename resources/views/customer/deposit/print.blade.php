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
    <h1>Deposits</h1>
    <table class="text-center">
        <thead>
            <tr>
                <td>Status</td>
                <td>Ticket Date</td>
                <td>Total Amount</td>
                <td>Account Name</td>
            </tr>
        </thead>
        <tbody>
                <tr>
                    <td>{{ $deposits->status }}</td>
                    <td>{{ $deposits->deposit_ticket_date }}</td>
                    <td>{{ $deposits->total_amount }}</td>
                    <td>{{ $deposits->chartOfAccount->account_name }}</td>
                </tr>
        </tbody>
    </table>
</body>
</html>