<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Vendor Bill</title>

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
    <h3>Vendor Bill</h3>
    <table class="text-center">
        <thead>
            <tr>
                <th>Due Date</th>
                <th>Sub Total</th>
                <th>Discount</th>
                <th>Tax</th>
                <th>Grand Total</th>
                <th>Total Amount Received</th>
                <th>Withholding</th>
                <th>Withholding Status</th>
                <th>Payment Method</th>
            </tr>
        </thead>
        <tbody>
                <tr>
                    <td>{{$bills->due_date}}</td>
                    <td>{{$bills->sub_total}}</td>
                    <td>{{$bills->discount}}</td>
                    <td>{{$bills->tax}}</td>
                    <td>{{$bills->grand_total}}</td>
                    <td>{{$bills->amount_received}}</td>
                    <td>{{$bills->withholding}}</td>
                    <td>{{$bills->withholding_status}}</td>
                    <td>{{$bills->payment_method}}</td>
                </tr>
        </tbody>
    </table>
</body>
</html>