<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Vendor Statement</title>

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
    <h1>Vendor Statementt</h1>
    <table class="text-center">
        <thead>
            <tr>
                <th>Vendor Name</th>
                <th>Date</th>
                <th>Due Date</th>
                <th>Grand Total</th>
                <th>Payment</th>
                <th>Balance</th>
            </tr>
        </thead>
        <tbody>
            @foreach($payment_reference as $payment_reference)
                <tr>
                    <td>{{$payment_reference->vendor->name}}</td>
                    <td>{{$payment_reference->date}}</td>
                    <td>{{$payment_reference->bills->due_date}}</td>
                    <td>{{$payment_reference->bills->grand_total}}</td>
                    <td>{{$payment_reference->bills->amount_received}}</td>
                    <td>{{$payment_reference->bills->grand_total-$payment_reference->bills->amount_received}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>