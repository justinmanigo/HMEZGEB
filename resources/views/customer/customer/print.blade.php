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
    <h3>Customer Statement: {{$receipt_references[0]->customer->name}}</h3>
    <table class="text-center">
        <thead>
            <tr>
                <th>Date</th>
                <th>Due Date</th>
                <th class="text-right">Amount</th>
                <th class="text-right">Payment</th>
                <th class="text-right">Balance</th>
            </tr>
        </thead>
        <tbody>
                @foreach($receipt_references as $receipt_reference)
                <tr>
                    <td>{{$receipt_reference->date}}</td>
                    <td>{{$receipt_reference->receipt->due_date}}</td>
                    <td class="text-right">{{$receipt_reference->receipt->grand_total}}</td>
                    <td class="text-right">{{$receipt_reference->receipt->total_amount_received}}</td>
                    <td class="text-right">{{$receipt_reference->receipt->grand_total - $receipt_reference->receipt->total_amount_received}}</td>
                </tr>
                @endforeach
        </tbody>
        <tfoot>
            <tr>
                {{-- total balance --}}
                <th colspan="4" class="text-right">Total Balance:</th>
                <td class="text-right">{{$total_balance}}</td>
            </tr>  
        </tfoot>
    </table>
</body>
</html>