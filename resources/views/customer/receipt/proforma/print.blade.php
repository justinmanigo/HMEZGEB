<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Proforma</title>

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
    <h1>Proforma</h1>
    <table class="text-center">
        <thead>
            <tr>
                <th>Due Date</th>
                <th>Amount</th>
                <th>Tax</th>
                <th>Remark</th>
            </tr>
        </thead>
        <tbody>
                <tr>
                    <td>{{$proforma->due_date}}</td>
                    <td>{{$proforma->amount}}</td>
                    <td>{{$proforma->tax}}</td>
                    <td>{{$proforma->remark}}</td>
                </tr>
        </tbody>
    </table>
</body>
</html>