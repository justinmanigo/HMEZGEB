
@extends('reports.template')
@section('page_title', 'Aged Receivables')
@section('content')

@php
    $customer_id = 0;
@endphp

@foreach($results as $result)

    @if($customer_id != $result->customer_id && $customer_id != 0)
            </tbody>
            <tfoot>
                <th class="text-start" colspan="3">Total</th>
                <th class="text-end">{{ number_format($total_current, 2) }}</th>
                <th class="text-end">{{ number_format($total_thirty_days, 2) }}</th>
                <th class="text-end">{{ number_format($total_sixty_days, 2) }}</th>
                <th class="text-end">{{ number_format($total_ninety_days, 2) }}</th>
                <th class="text-end">{{ number_format($total_over_ninety_days, 2) }}</th>
            </tfoot>
        </table>
    @endif
    @if($customer_id != $result->customer_id)
        <h5 class="text-start" style="font-size:18px;margin-bottom:0px">{{ $result->customer_name }}</h5>
        @php
            $customer_id = $result->customer_id;
            $total_current = floatval(0);
            $total_thirty_days = floatval(0);
            $total_sixty_days = floatval(0);    
            $total_ninety_days = floatval(0);
            $total_over_ninety_days = floatval(0);
        @endphp

        <table class="table table-bordered">
            <thead>
                <th class="text-start">Date</th>
                <th class="text-start">Due Date</th>
                <th class="text-start">Reference</th>
                <th class="text-end">Current</th>
                <th class="text-end">30 Days</th>
                <th class="text-end">60 Days</th>
                <th class="text-end">90 Days</th>
                <th class="text-end">Over 90 Days</th>
            </thead>
            <tbody>
    @endif

    <tr>
        <td class="text-start">{{ $result->date }}</td>
        <td class="text-start">{{ $result->due_date }}</td>
        <td class="text-start">{{ $result->receipt_reference_id }}</td>
        <td class="text-end">{{ number_format($result->current, 2) }}</td>
        <td class="text-end">{{ number_format($result->thirty_days, 2) }}</td>
        <td class="text-end">{{ number_format($result->sixty_days, 2) }}</td>
        <td class="text-end">{{ number_format($result->ninety_days, 2) }}</td>
        <td class="text-end">{{ number_format($result->over_ninety_days, 2) }}</td>
    </tr>

    @php
        $total_current += floatval($result->current);
        $total_thirty_days += floatval($result->thirty_days);
        $total_sixty_days += floatval($result->sixty_days);
        $total_ninety_days += floatval($result->ninety_days);
        $total_over_ninety_days += floatval($result->over_ninety_days);
    @endphp

    @if($loop->last)
        </tbody>
        <tfoot>
            <th class="text-start" colspan="3">Total</th>
            <th class="text-end">{{ number_format($total_current, 2) }}</th>
            <th class="text-end">{{ number_format($total_thirty_days, 2) }}</th>
            <th class="text-end">{{ number_format($total_sixty_days, 2) }}</th>
            <th class="text-end">{{ number_format($total_ninety_days, 2) }}</th>
            <th class="text-end">{{ number_format($total_over_ninety_days, 2) }}</th>
        </tfoot>
        </table>
    @endif


@endforeach
@endsection