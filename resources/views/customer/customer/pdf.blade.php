<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Customers</title>

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
                <td>name</td>
                <td>tin_number</td>
                <td>address</td>
                <td>city</td>
                <td>country</td>
                <td>mobile_number</td>
                <td>telephone_one</td>
                <td>website</td>
                <td>email</td>
                <td>contact_person</td>
                <td>label</td>
                <td>is_active</td>
            </tr>
        </thead>
        <tbody>
            @foreach ($customers as $customer)
                <tr>
                    <td>{{$customer->name}}</td>
                    <td>{{$customer->tin_number}}</td>
                    <td>{{$customer->address}}</td>
                    <td>{{$customer->city}}</td>
                    <td>{{$customer->country}}</td>
                    <td>{{$customer->mobile_number}}</td>
                    <td>{{$customer->telephone_one}}</td>
                    <td>{{$customer->website}}</td>
                    <td>{{$customer->email}}</td>
                    <td>{{$customer->contact_person}}</td>
                    <td>{{$customer->label}}</td>
                    <td>{{$customer->is_active}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>