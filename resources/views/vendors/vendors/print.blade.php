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

        .text-right {
            text-align: right;
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
    <h3>Vendor Statement: {{$payment_references[0]->vendor->name}}</h3>
    <table class="text-center">
        <thead>
            <tr>
                <th>Date</th>
                <th>Due Date</th>
                <th class="text-right">Grand Total</th>
                <th class="text-right">Payment</th>
                <th class="text-right">Balance</th>
            </tr>
        </thead>
        <tbody>
            @foreach($payment_references as $payment_reference)
                <tr>
                    <td>{{$payment_reference->date}}</td>
                    <td>{{$payment_reference->bills->due_date}}</td>
                    <td class="text-right">{{$payment_reference->bills->grand_total}}</td>
                    <td class="text-right">{{$payment_reference->bills->amount_received}}</td>
                    <td class="text-right">{{$payment_reference->bills->grand_total-$payment_reference->bills->amount_received}}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th class="text-right" colspan="4">Total Balance:</th>
                <td class="text-right">{{$total_balance}}</td>
            </tr>
        </tfoot>
    </table>
</body>
</html>