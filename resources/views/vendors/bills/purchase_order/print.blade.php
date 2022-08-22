<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Vendor Purchase Order</title>

    <style>
        .page-break {
            page-break-after: always;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        table, th, td {
            border: 1px solid lightgray;
            text-align: left;
        }
    </style>
</head>
<body>
    <h3>Purchase Order: {{$purchase_order->paymentReference->vendor->name}}</h3>
    <table>
        <thead>
            <tr>
                <th>Item Name</th>
                <th>Value</th>
            </tr>
        </thead>
        <tbody>
                <tr>
                    <td>Due Date</td>
                    <td>{{$purchase_order->due_date}}</td>
                </tr>
                <tr>
                    <td>Sub Total</td>
                    <td>{{number_format($purchase_order->sub_total, 2)}}</td>
                </tr>
                <tr>
                    <td>Tax</td>
                    <td>{{number_format($purchase_order->tax, 2)}}</td>
                </tr>
                <tr>
                    <td>Grand Total</td>
                    <td>{{number_format($purchase_order->grand_total, 2)}}</td>
                </tr>
        </tbody>
    </table>
</body>
</html>