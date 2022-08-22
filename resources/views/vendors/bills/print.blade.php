<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Bill</title>

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
    <h3>Bill: {{$bill_items[0]->paymentReference->vendor->name}}</h3>
    <table class="text-center">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Quantity</th>
                <th class="text-right">Price</th>
                <th class="text-right">Total Price</th>
            </tr>
        </thead>
        <tbody>
                @foreach($bill_items as $item)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$item->inventory->item_name}}</td>
                        <td>{{$item->quantity}}</td>
                        <td class="text-right">{{number_format($item->price,2)}}</td>
                        <td class="text-right">{{number_format($item->total_price,2)}}</td>
                    </tr>
                @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td class="text-right" colspan="4"><b>Total :</b></td>
                <td class="text-right">{{number_format($item->paymentReference->bills->sub_total,2)}}</td>
            </tr>
            <tr>
                <td class="text-right" colspan="4"><b>Tax :</b></td>
                <td class="text-right">{{number_format($item->paymentReference->bills->tax,2)}}</td>
            </tr>
            <tr>
                <td class="text-right" colspan="4"><b>Withholding :</b></td>
                <td class="text-right">{{number_format($item->paymentReference->bills->withholding, 2)}}</td>
            </tr>
            <tr>
                <td class="text-right" colspan="4"><b>Grand Total :</b></td>
                <td class="text-right">{{number_format($item->paymentReference->bills->grand_total, 2)}}</td>
            </tr>
        </tfoot>
    </table>
</body>
</html>