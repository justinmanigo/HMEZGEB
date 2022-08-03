<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Withholding</title>

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
    <h1>Withholding</h1>
    <table class="text-center">
        <thead>
            <tr>
                <th>id</th>
                <th>accounting system id</th>
                <th>name</th>
                <th>percentage</th>
                <th>created at</th>
                <th>updated at</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($withholdings as $withholding)
                <tr>
                    <td>{{ $withholding->id }}</td>
                    <td>{{ $withholding->accounting_system_id }}</td>
                    <td>{{ $withholding->name }}</td>
                    <td>{{ $withholding->percentage }}</td>
                    <td>{{ $withholding->created_at }}</td>
                    <td>{{ $withholding->updated_at }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>