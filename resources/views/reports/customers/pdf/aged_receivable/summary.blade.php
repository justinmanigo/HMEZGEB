
@extends('reports.template')
@section('page_title', 'Aged Receivables')
@section('content')
<table class="table table-bordered">
    <thead>
        <th class="text-start">Customer</th>
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
        @foreach ($results as $customer)
        <tr>
            <td class="text-start">{{ $customer->name }}</td>
            <td class="text-end">{{ number_format($customer->current, 2) }}</td>
            <td class="text-end">{{ number_format($customer->thirty_days, 2) }}</td>
            <td class="text-end">{{ number_format($customer->sixty_days, 2) }}</td>
            <td class="text-end">{{ number_format($customer->ninety_days, 2) }}</td>
            <td class="text-end">{{ number_format($customer->over_ninety_days, 2) }}</td>
            <td class="text-end"><strong>{{ number_format($customer->total, 2) }}</strong></td>
        </tr>
        @php
            $total_current += $customer->current;
            $total_thirty_days += $customer->thirty_days;
            $total_sixty_days += $customer->sixty_days;    
            $total_ninety_days += $customer->ninety_days;
            $total_over_ninety_days += $customer->over_ninety_days;
            $total_grand += $customer->total;
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