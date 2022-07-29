<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Vendor</title>

    <style>
        .text-center {
            text-align: center;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }
        td {
            word-break: break-word;
        }

    </style>
</head>
<body>
    <h1>Vendor</h1>
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
            @foreach ($vendors as $vendor)
                <tr>
                    <td>{{$vendor->name}}</td>
                    <td>{{$vendor->tin_number}}</td>
                    <td>{{$vendor->address}}</td>
                    <td>{{$vendor->city}}</td>
                    <td>{{$vendor->country}}</td>
                    <td>{{$vendor->mobile_number}}</td>
                    <td>{{$vendor->telephone_one}}</td>
                    <td>{{$vendor->website}}</td>
                    <td>{{$vendor->email}}</td>
                    <td>{{$vendor->contact_person}}</td>
                    <td>{{$vendor->label}}</td>
                    <td>{{$vendor->is_active}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>