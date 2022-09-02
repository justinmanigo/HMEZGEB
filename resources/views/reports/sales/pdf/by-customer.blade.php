@extends('reports.template')
@section('page_title', 'Sales by Customer')
@section('content')

@php
    $grand_total_transactions = 0;
    $grand_total_amount = 0;
@endphp

<table class="table table-bordered">
    <thead>
        <th class="text-start">Customer</th>
        <th class="text-end">Total Transactions</th>
        <th class="text-end">Total Amount</th>
    </thead>
    <tbody>
    @foreach($results as $row)
        <tr>
            <td class="text-start">{{ $row->customer }}</td>
            <td class="text-end">{{ number_format($row->total_transactions) }}</td>
            <td class="text-end">{{ number_format($row->total_amount, 2) }}</td>
        </tr>
        @php
            $grand_total_transactions += $row->total_transactions;
            $grand_total_amount += $row->total_amount;
        @endphp
    @endforeach
    </tbody>

    <tfoot>
        <th class="text-start" colspan="1">Grand Total</th>
        <th class="text-end" style="color:darkgreen">
            {{ number_format($grand_total_transactions) }}
        </th>
        <th class="text-end" style="color:darkgreen">
            {{ number_format($grand_total_amount, 2) }}
        </th>
    </tfoot>
</table>
@endsection