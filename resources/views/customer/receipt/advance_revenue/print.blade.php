<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Advance Revenue</title>

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
    <h1>Advance Revenue</h1>
    <h2>{{$advance_revenue->receiptReference->customer->name}}</h2>
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
                    <td>{{$advance_revenue->receiptReference->date}}</td>
                    <td>{{$advance_revenue->total_amount_received}}</td>
                    <td>{{$advance_revenue->remark}}</td>
                </tr>
        </tbody>
    </table>
</body>
</html>