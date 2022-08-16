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
    <h3>Bill</h3>
    <table class="text-center">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Total Price</th>
            </tr>
        </thead>
        <tbody>
                @foreach($bill_items as $item)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$item->inventory->item_name}}</td>
                        <td>{{$item->quantity}}</td>
                        <td>{{$item->price}}</td>
                        <td>{{$item->total_price}}</td>
                    </tr>
                @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td class="text-right" colspan="4"><b>Total :</b></td>
                <td>{{$item->paymentReference->bills->sub_total}}</td>
            </tr>
            <tr>
                <td class="text-right" colspan="4"><b>Tax :</b></td>
                <td>{{$item->paymentReference->bills->tax}}</td>
            </tr>
            <tr>
                <td class="text-right" colspan="4"><b>Withholding :</b></td>
                <td>{{$item->paymentReference->bills->withholding}}</td>
            </tr>
            <tr>
                <td class="text-right" colspan="4"><b>Grand Total :</b></td>
                <td>{{$item->paymentReference->bills->grand_total}}</td>
            </tr>
        </tfoot>
    </table>
</body>
</html>