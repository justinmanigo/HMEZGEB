@extends('reports.template')
@section('page_title', 'Sales')
@section('content')

@php
    $grand_total_amount = 0;
@endphp

<table class="table table-bordered">
    <thead>
        <th class="text-start">Date</th>
        <th class="text-start">Reference</th>
        <th class="text-start">Customer</th>
        <th class="text-start">Commission Agent</th>
        <th class="text-start">Item</th>
        <th class="text-end">Quantity</th>
        <th class="text-end">Total Amount</th>
    </thead>
    <tbody>
    @foreach($results as $row)
        <tr>
            <td class="text-start">{{ $row->date }}</td>
            <td class="text-start">{{ $row->reference }}</td>
            <td class="text-start">{{ $row->customer }}</td>
            <td class="text-start"></td> {{-- TODO: To add commission agent --}}
            <td class="text-start">{{ $row->inventory_id . ' - ' . $row->item_name }}</td>
            <td class="text-end">{{ $row->quantity }}</td>
            <td class="text-end">{{ number_format($row->total_price, 2) }}</td>
        </tr>
        @php
            $grand_total_amount += $row->total_price;
        @endphp
    @endforeach
    </tbody>

    <tfoot>
        <th class="text-start" colspan="6">Grand Total</th>
        <th class="text-end" style="color:darkgreen">
            {{ number_format($grand_total_amount, 2) }}
        </th>
    </tfoot>
</table>
@endsection