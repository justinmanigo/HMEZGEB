<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Customers</title>

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
    <h1>Customers</h1>
    <table class="text-center">
        <thead>
            <tr>
                <td>Date</td>
                <td>Due Date</td>
                <td>Amount</td>
                <td>Payment</td>
                <td>Balance</td>
            </tr>
        </thead>
        <tbody>
                <tr>
                    <td>{{$customers->receiptReference->date}}</td>
                    <td>{{$customers->receiptReference->receipt->due_date}}</td>
                    <td>{{$customers->receiptReference->receipt->grand_total}}</td>
                    <td>{{$customers->receiptReference->receipt->total_amount_received}}</td>
                    <td>{{$customers->receiptReference->receipt->grand_total - $customers->receiptReference->receipt->total_amount_received}}</td>
                </tr>
        </tbody>
    </table>
</body>
</html>