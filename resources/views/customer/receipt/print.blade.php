<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Receipt</title>

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
    <h1>Customer Receipt</h1>
    <h2>{{$receipt_items[0]->receiptReference->customer->name}}</h2>
    <table class="text-center">
        <thead>
            <tr>
                <th>#</th>
                <th>Item Name</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Total Price</th>
            </tr>
        </thead>
        <tbody>
                @foreach($receipt_items as $item)
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
                <td>{{$item->receiptReference->receipt->sub_total}}</td>
            </tr>
            <tr>
                <td class="text-right" colspan="4"><b>Tax :</b></td>
                <td>{{$item->receiptReference->receipt->tax}}</td>
            </tr>
            <tr>
                <td class="text-right" colspan="4"><b>Withholding :</b></td>
                <td>{{$item->receiptReference->receipt->withholding}}</td>
            </tr>
            <tr>
                <td class="text-right" colspan="4"><b>Grand Total :</b></td>
                <td>{{$item->receiptReference->receipt->grand_total}}</td>
            </tr>
        </tfoot>
    </table>
</body>
</html>