@extends('reports.template')
@section('page_title', 'Bills')
@section('content')

@php
    $total_tax = 0;
    $total_discount = 0;
    $total_withholding = 0;
    $total_grand = 0;
    $total_received = 0;
@endphp

<table class="table table-bordered">
    <thead>
        <th class="text-start">Date</th>
        <th class="text-start">Reference</th>
        <th class="text-start">Vendor</th>
        <th class="text-start">Remark</th>
        <th class="text-end">Tax</th>
        <th class="text-end">Discount</th>
        <th class="text-end">Withholding</th>
        <th class="text-end">Total Amount</th>
        <th class="text-end">Amount Received</th>
    </thead>
    @foreach($results as $bill)
        <tbody>
            <tr>
                <td class="text-start">{{ $bill->date }}</td>
                <td class="text-start">{{ $bill->id }}</td>
                <td class="text-start">{{ $bill->vendor_name }}</td>
                <td class="text-start">{{ $bill->remark }}</td>
                <td class="text-end">{{ number_format($bill->tax, 2) }}</td>
                <td class="text-end">{{ number_format($bill->discount, 2) }}</td>
                <td class="text-end">{{ number_format($bill->withholding, 2) }}</td>
                <td class="text-end">{{ number_format($bill->grand_total, 2) }}</td>
                <td class="text-end">{{ number_format($bill->amount_received, 2) }}</td>
            </tr>
            @php
                $total_tax += $bill->tax;
                $total_discount += $bill->discount;
                $total_withholding += $bill->withholding;
                $total_grand += $bill->grand_total;
                $total_received += $bill->amount_received;
            @endphp
        </tbody>
    @endforeach

    <tfoot>
        <th class="text-start" colspan="4">Grand Total</th>
        <th class="text-end" style="color:darkgreen">
            {{ number_format($total_tax, 2) }}
        </th>
        <th class="text-end" style="color:darkgreen">
            {{ number_format($total_discount, 2) }}
        </th>
        <th class="text-end" style="color:darkgreen">
            {{ number_format($total_withholding, 2) }}
        </th>
        <th class="text-end" style="color:darkgreen">
            {{ number_format($total_grand, 2) }}
        </th>
        <th class="text-end" style="color:darkgreen">
            {{ number_format($total_received, 2) }}
        </th>
    </tfoot>
</table>
@endsection