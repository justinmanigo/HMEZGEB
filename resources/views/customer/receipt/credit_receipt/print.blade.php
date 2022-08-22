<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Credit Receipt</title>

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

        table, th, td {
            border: 1px solid lightgray;
        }

    </style>
</head>
<body>
    <h1>Credit Receipt</h1>
    <h2>{{$credit_receipt->receiptReference->customer->name}}</h2>
    <table class="text-center">
        <thead>
            <tr>
                <th>Date</th>
                <th>Total Amount Received</th>
                <th>Remark</th>
            </tr>
        </thead>
        <tbody>
                <tr>
                    <td>{{$credit_receipt->receiptReference->date}}</td>
                    <td>{{$credit_receipt->total_amount_received}}</td>
                    <td>{{$credit_receipt->remark}}</td>
                </tr>
        </tbody>
    </table>
</body>
</html>