<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Expense</title>

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
    <h3>Expense PR# {{$expense->paymentReference->id}}</h3>
    <table class="text-center">
        <thead>
            <tr>
                <th>#</th>
                <th>Chat of Account</th>
                <th class="text-right">Total Price</th>
            </tr>
        </thead>
        <tbody>
                @foreach($expense->expenseItems as $item)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$item->chartOfAccount->chart_of_account_no}} - {{$item->chartOfAccount->account_name}}</td>
                        <td class="text-right">{{number_format($item->price_amount,2)}}</td>
                    </tr>
                @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td class="text-right" colspan="2"><b>Total :</b></td>
                <td class="text-right">{{number_format($expense->sub_total,2)}}</td>
            </tr>
            <tr>
                <td class="text-right" colspan="2"><b>Tax :</b></td>
                <td class="text-right">{{number_format($expense->tax,2)}}</td>
            </tr>
            <tr>
                <td class="text-right" colspan="2"><b>Withholding :</b></td>
                <td class="text-right">{{number_format($expense->withholding, 2)}}</td>
            </tr>
            <tr>
                <td class="text-right" colspan="2"><b>Grand Total :</b></td>
                <td class="text-right">{{number_format($expense->grand_total, 2)}}</td>
            </tr>
        </tfoot>
    </table>
</body>
</html>
