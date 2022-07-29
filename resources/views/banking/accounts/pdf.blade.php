<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Bank Accounts</title>

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
    <h1>Bank Accounts</h1>
    <table class="text-center">
        <thead>
            <tr>
                <td>id</td>
                <td>Account Name</td>
                <td>Bank Branch</td>
                <td>Account Number</td>
                <td>Account Type</td>
            </tr>
        </thead>
        <tbody>
            @foreach ($accounts as $account)
                <tr>
                    <td>{{ $account->id }}</td>
                    <td>{{ $account->chartOfAccount->account_name }}</td>
                    <td>{{ $account->bank_branch }}</td>
                    <td>{{ $account->bank_account_number }}</td>
                    <td>{{ $account->bank_account_type }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>