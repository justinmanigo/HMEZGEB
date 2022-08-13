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
    <h3>Vendor Purchase Order</h3>
    <table class="text-center">
        <thead>
            <tr>
                <th>Due Date</th>
                <th>Sub Total</th>
                <th>Tax</th>
                <th>Grand Total</th>
            </tr>
        </thead>
        <tbody>
                <tr>
                    <td>{{ $purchaseOrders->due_date }}</td>
                    <td>{{ $purchaseOrders->sub_total }}</td>
                    <td>{{ $purchaseOrders->tax }}</td>
                    <td>{{ $purchaseOrders->grand_total }}</td>
                </tr>
        </tbody>
    </table>
</body>
</html>