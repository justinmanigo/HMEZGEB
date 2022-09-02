@extends('reports.template')
@section('page_title', 'Sales by Item')
@section('content')

@php
    $grand_total_amount = 0;
@endphp

<table class="table table-bordered">
    <thead>
        <th class="text-start">Item ID</th>
        <th class="text-start">Item Name</th>
        <th class="text-end">Quantity</th>
        <th class="text-end">Total Amount</th>
    </thead>
    <tbody>
    @foreach($results as $row)
        <tr>
            <td class="text-start">{{ $row->inventory_id }}</td>
            <td class="text-start">{{ $row->item_name }}</td>
            <td class="text-end">{{ $row->quantity_sold }}</td>
            <td class="text-end">{{ number_format($row->total_amount, 2) }}</td>
        </tr>
        @php
            $grand_total_amount += $row->total_amount;
        @endphp
    @endforeach
    </tbody>

    <tfoot>
        <th class="text-start" colspan="3">Grand Total</th>
        <th class="text-end" style="color:darkgreen">
            {{ number_format($grand_total_amount, 2) }}
        </th>
    </tfoot>
</table>
@endsection