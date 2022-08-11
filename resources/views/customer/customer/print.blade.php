<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Customer Statement</title>

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
    <h3>Customer Statement: {{$receipt_reference[0]->customer->name}}</h3>
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
                @foreach($receipt_reference as $receipt_reference)
                <tr>
                    <td>{{$receipt_reference->date}}</td>
                    <td>{{$receipt_reference->receipt->due_date}}</td>
                    <td>{{$receipt_reference->receipt->grand_total}}</td>
                    <td>{{$receipt_reference->receipt->total_amount_received}}</td>
                    <td>{{$receipt_reference->receipt->grand_total - $receipt_reference->receipt->total_amount_received}}</td>
                </tr>
                @endforeach
        </tbody>
    </table>
</body>
</html>