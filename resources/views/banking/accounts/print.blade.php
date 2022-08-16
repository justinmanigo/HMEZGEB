<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Bank Account</title>

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
    <h3>Bank Account</h3>
    <table class="text-center">
        <thead>
            <tr>
                <th>Name</th>
                <th>Value</th>
            </tr>
        </thead>
        <tbody>
                <tr>
                    <td>Account Name</td>
                    <td>{{ $account->chartOfAccount->account_name }}</td>
                </tr>
                <tr>
                    <td>Account Number</td>
                    <td>{{ $account->bank_account_number }}</td>
                </tr>
                <tr>
                    <td>Bank Branch</td>
                    <td>{{ $account->bank_branch }}</td>
                </tr>
                <tr>
                    <td>Account Type</td>
                    <td>{{ $account->bank_account_type }}</td>
                </tr>
                <tr>
                    <td>Status</td>
                    <td>{{ $account->chartOfAccount->status }}</td>
                </tr>
                <tr>
                    <td>Account Balance</td>
                    <td>{{ $account->chartOfAccount->current_balance }}</td>
                </tr>
        </tbody>
    </table>
</body>
</html>