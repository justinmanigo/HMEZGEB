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
    <h3>Bank Account</h3>
    <table class="text-center">
        <thead>
            <tr>
                <th>Bank Branch</th>
                <th>Account Number</th>
                <th>Account Name</th>
                <th>Account Type</th>
                <th>Account Balance</th>
            </tr>
        </thead>
        <tbody>
                <tr>
                    <td>{{ $accounts->bank_branch }}</td>
                    <td>{{ $accounts->bank_account_number }}</td>
                    <td>{{ $accounts->chartOfAccount->account_name }}</td>
                    <td>{{ $accounts->bank_account_type }}</td>
                    <td>{{ $accounts->chartOfAccount->current_balance }}</td>    
                </tr>
        </tbody>
    </table>
</body>
</html>