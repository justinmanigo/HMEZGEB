@extends('reports.template')
@section('page_title', 'General Journal')
@section('content')

@php
    $total_debit = 0;
    $total_credit = 0;
@endphp

<table class="table table-bordered">
    <thead>
        <th class="text-start">Date</th>
        <th class="text-start">Account</th>
        <th class="text-end">Debit</th>
        <th class="text-end">Credit</th>
    </thead>
    <tbody>
    @foreach($results as $gj)
        @if($gj->debit > 0 || $gj->credit > 0)
            <tr>
                <td class="text-start">{{ $gj->date }}</td>
                <td class="text-start">{{ $gj->account_no }} - {{ $gj->account_name }}</td>
                <td class="text-end">@if(!$gj->debit <= 0) {{ number_format($gj->debit, 2) }} @endif</td>
                <td class="text-end">@if(!$gj->credit <= 0) {{ number_format($gj->credit, 2) }} @endif</td>
            </tr>
            @php
                $total_debit += $gj->debit;
                $total_credit += $gj->credit;
            @endphp
        @endif
    @endforeach
    </tbody>

    <tfoot>
        <th class="text-start" colspan="2">Grand Total</th>
        <th class="text-end" style="color:darkgreen">
            {{ number_format($total_debit, 2) }}
        </th>
        <th class="text-end" style="color:darkgreen">
            {{ number_format($total_credit, 2) }}
        </th>
    </tfoot>
</table>
@endsection