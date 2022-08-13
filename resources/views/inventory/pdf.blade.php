<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Inventory</title>

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
    <h1>Inventory</h1>
    <table class="text-center">
        <thead>
            <tr>
                <th>Item Code</th>
                <th>Item Name</th>
                <th>Sale Price</th>
                <th>Purchase Price</th>
                <th>Quantity</th>
                <th>Critical Quantity</th>
                <th>Tax</th>
                <th>Inventory Type</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($inventories as $item)
                <tr>
                    <td>{{ $item->item_code }}</td>
                    <td>{{ $item->item_name }}</td>
                    <td>{{ $item->sale_price }}</td>
                    <td>{{ $item->purchase_price }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ $item->critical_quantity }}</td>
                    <td>{{ $item->tax }}</td>
                    <td>{{ $item->inventory_type }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>