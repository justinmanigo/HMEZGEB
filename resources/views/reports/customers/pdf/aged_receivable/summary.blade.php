
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
        {{-- @foreach ($customers as $customer) --}}
        <tr>
            <td class="text-start">Test Customer{{-- $customer->name --}}</td>
            <td class="text-end">0.00{{-- $customer->balance --}}</td>
            <td class="text-end">0.00{{-- $customer->thirty_days --}}</td>
            <td class="text-end">0.00{{-- $customer->sixty_days --}}</td>
            <td class="text-end">0.00{{-- $customer->ninety_days --}}</td>
            <td class="text-end">0.00{{-- $customer->over_ninety_days --}}</td>
            <td class="text-end">0.00{{-- $customer->total --}}</td>
        </tr>
        {{-- @endforeach --}}
    </tbody>
    <tfoot>
        <th class="text-start">Total</th>
        <th class="text-end">0.00{{-- $total_balance --}}</th>
        <th class="text-end">0.00{{-- $total_thirty_days --}}</th>
        <th class="text-end">0.00{{-- $total_sixty_days --}}</th>
        <th class="text-end">0.00{{-- $total_ninety_days --}}</th>
        <th class="text-end">0.00{{-- $total_over_ninety_days --}}</th>
        <th class="text-end">0.00{{-- $total_total --}}</th>
    </tfoot>
</table>
@endsection