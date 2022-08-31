@extends('reports.template')
@section('page_title', 'Journal Voucher')
@section('content')

@php
    $total_debit = 0;
    $total_credit = 0;
@endphp

<table class="table table-bordered">
    <thead>
        <th class="text-start">Date</th>
        <th class="text-start">Reference</th>
        <th class="text-start">Account</th>
        <th class="text-start">Description</th>
        <th class="text-end">Debit</th>
        <th class="text-end">Credit</th>
    </thead>
    @foreach($results as $jv)
        <tbody>
            <tr>
                <td class="text-start">{{ $jv->date }}</td>
                <td class="text-start">{{ $jv->id }}</td>
                <td class="text-start">{{ $jv->account_no }} - {{ $jv->account_name }}</td>
                <td class="text-start">{{ $jv->description }}</td>
                <td class="text-end">@if(!$jv->debit <= 0) {{ number_format($jv->debit, 2) }} @endif</td>
                <td class="text-end">@if(!$jv->credit <= 0) {{ number_format($jv->credit, 2) }} @endif</td>
            </tr>
            @php
                $total_debit += $jv->debit;
                $total_credit += $jv->credit;
            @endphp
        </tbody>
    @endforeach

    <tfoot>
        <th class="text-start" colspan="4">Grand Total</th>
        <th class="text-end" style="color:darkgreen">
            {{ number_format($total_debit, 2) }}
        </th>
        <th class="text-end" style="color:darkgreen">
            {{ number_format($total_credit, 2) }}
        </th>
    </tfoot>
</table>
@endsection