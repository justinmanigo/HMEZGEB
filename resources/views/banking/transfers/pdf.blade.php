<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Bank Transfer</title>

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
    <h1>Bank Transfer</h1>
    <table class="text-center">
        <thead>
            <tr>
                <th>id</th>
                <td>accounting_system_id</td>
                <td>from_account</td>
                <td>to_account</td>
                <td>amount</td>
                <td>reason</td>
                <td>status</td> 
                
            </tr>
        </thead>
        <tbody>
            @foreach ($transfers as $transfer)
                <tr>
                    <td>{{ $transfer->id }}</td>
                    <td>{{ $transfer->accounting_system_id }}</td>
                    <td>{{ $transfer->fromAccount->bank_branch }}</td>
                    <td>{{ $transfer->toAccount->bank_branch }}</td>
                    <td>{{ $transfer->amount }}</td>
                    <td>{{ $transfer->reason }}</td>
                    <td>{{ $transfer->status }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>