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

        table {
            border-collapse: collapse;
            width: 100%;
        }

    </style>
</head>
<body>
    <h1>Customers</h1>
    <table class="text-center">
        <thead>
            <tr>
                <td>Due Date</td>
                <td>Sub Total</td>
                <td>Discount</td>
                <td>Tax</td>
                <td>Grand Total</td>
                <td>Total Amount Received</td>
                <td>Withholding</td>
                <td>Payment Method</td>
            </tr>
        </thead>
        <tbody>
                <tr>
                    <td>{{ $receipt->due_date }}</td>
                    <td>{{ $receipt->sub_total }}</td>
                    <td>{{ $receipt->discount }}</td>
                    <td>{{ $receipt->tax }}</td>
                    <td>{{ $receipt->grand_total }}</td>
                    <td>{{ $receipt->total_amount_received }}</td>
                    <td>{{ $receipt->withholding }}</td>
                    <td>{{ $receipt->payment_method }}</td>
                </tr>
        </tbody>
    </table>
</body>
</html>