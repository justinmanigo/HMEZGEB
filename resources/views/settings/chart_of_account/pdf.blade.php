<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Chart Of Account</title>

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
    <h1>Chart Of Account</h1>
    <table class="text-center">
        <thead>
            <tr>
                <th>id</th>
                <th>Chart Of Account Category</th>
                <th>Chart Of Account No</th>
                <th>Account Name</th>
                <th>Current Balance</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($coas as $coa)
                <tr>
                    <td>{{ $coa->id }}</td>
                    <td>{{ $coa->category->category }}</td>
                    <td>{{ $coa->chart_of_account_no }}</td>
                    <td>{{ $coa->account_name }}</td>
                    <td>{{ $coa->current_balance }}</td>
                    <td>{{ $coa->status }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>