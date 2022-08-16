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

    </style>
</head>
<body>
    <h3>Vendor Purchase Order</h3>
    <table class="text-center">
        <thead>
            <tr>
                <th>Name</th>
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
                    <td>{{$purchase_order->sub_total}}</td>
                </tr>
                <tr>
                    <td>Tax</td>
                    <td>{{$purchase_order->tax}}</td>
                </tr>
                <tr>
                    <td>Grand Total</td>
                    <td>{{$purchase_order->grand_total}}</td>
                </tr>
        </tbody>
    </table>
</body>
</html>