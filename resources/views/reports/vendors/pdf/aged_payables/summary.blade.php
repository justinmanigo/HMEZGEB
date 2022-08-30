
@extends('reports.template')
@section('page_title', 'Aged Payables')
@section('content')
<table class="table table-bordered">
    <thead>
        <th class="text-start">Vendor</th>
        <th class="text-end">Current</th>
        <th class="text-end">30 Days</th>
        <th class="text-end">60 Days</th>
        <th class="text-end">90 Days</th>
        <th class="text-end">Over 90 Days</th>
        <th class="text-end">Total</th>
    </thead>
    <tbody>
        @php
            $total_current = floatval(0);
            $total_thirty_days = floatval(0);
            $total_sixty_days = floatval(0);    
            $total_ninety_days = floatval(0);
            $total_over_ninety_days = floatval(0);
            $total_grand = floatval(0);
        @endphp
        @foreach ($results as $vendor)
        <tr>
            <td class="text-start">{{ $vendor->name }}</td>
            <td class="text-end">{{ number_format($vendor->current, 2) }}</td>
            <td class="text-end">{{ number_format($vendor->thirty_days, 2) }}</td>
            <td class="text-end">{{ number_format($vendor->sixty_days, 2) }}</td>
            <td class="text-end">{{ number_format($vendor->ninety_days, 2) }}</td>
            <td class="text-end">{{ number_format($vendor->over_ninety_days, 2) }}</td>
            <td class="text-end"><strong>{{ number_format($vendor->total, 2) }}</strong></td>
        </tr>
        @php
            $total_current += $vendor->current;
            $total_thirty_days += $vendor->thirty_days;
            $total_sixty_days += $vendor->sixty_days;    
            $total_ninety_days += $vendor->ninety_days;
            $total_over_ninety_days += $vendor->over_ninety_days;
            $total_grand += $vendor->total;
        @endphp
        @endforeach
    </tbody>
    <tfoot>
        <th class="text-start">Total</th>
        <th class="text-end">{{ number_format($total_current, 2) }}</th>
        <th class="text-end">{{ number_format($total_thirty_days, 2) }}</th>
        <th class="text-end">{{ number_format($total_sixty_days, 2) }}</th>
        <th class="text-end">{{ number_format($total_ninety_days, 2) }}</th>
        <th class="text-end">{{ number_format($total_over_ninety_days, 2) }}</th>
        <th class="text-end" style="color:darkred">{{ number_format($total_grand, 2) }}</th>
    </tfoot>
</table>
@endsection