
@extends('reports.template')
@section('page_title', 'Aged Payables')
@section('content')

@php
    $vendor_id = 0;
    $total_grand = 0;
@endphp

@foreach($results as $result)

    @if($vendor_id != $result->vendor_id && $vendor_id != 0)
        @php
            $total_sub = $total_current + $total_thirty_days + $total_sixty_days + $total_ninety_days + $total_over_ninety_days;
            $total_grand += $total_sub;
        @endphp
            </tbody>
            <tfoot>
                <th class="text-start" colspan="3">Total</th>
                <th class="text-end">{{ number_format($total_current, 2) }}</th>
                <th class="text-end">{{ number_format($total_thirty_days, 2) }}</th>
                <th class="text-end">{{ number_format($total_sixty_days, 2) }}</th>
                <th class="text-end">{{ number_format($total_ninety_days, 2) }}</th>
                <th class="text-end">{{ number_format($total_over_ninety_days, 2) }}</th>
            </tfoot>
            <tfoot>
                <th class="text-start" colspan="7">Sub Total</th>
                <th class="text-end" style="color:darkred"><strong>{{ number_format($total_sub, 2) }}</strong></th>
            </tfoot>
        </table>
    @endif
    @if($vendor_id != $result->vendor_id)
        <h5 class="text-start" style="font-size:18px;margin-bottom:0px">{{ $result->vendor_name }}</h5>
        @php
            $vendor_id = $result->vendor_id;
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
        <td class="text-start">{{ $result->payment_reference_id }}</td>
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
        @php
            $total_sub = $total_current + $total_thirty_days + $total_sixty_days + $total_ninety_days + $total_over_ninety_days;
            $total_grand += $total_sub;
        @endphp
        </tbody>
        <tfoot>
            <th class="text-start" colspan="3">Total</th>
            <th class="text-end">{{ number_format($total_current, 2) }}</th>
            <th class="text-end">{{ number_format($total_thirty_days, 2) }}</th>
            <th class="text-end">{{ number_format($total_sixty_days, 2) }}</th>
            <th class="text-end">{{ number_format($total_ninety_days, 2) }}</th>
            <th class="text-end">{{ number_format($total_over_ninety_days, 2) }}</th>
        </tfoot>
        <tfoot>
            <th class="text-start" colspan="7">Sub Total</th>
            <th class="text-end" style="color:darkred"><strong>{{ number_format($total_sub, 2) }}</strong></th>
        </tfoot>
        </table>
    @endif


@endforeach

<table class="table table-bordered">
    <thead style="font-size:20px">
        <th class="text-start" colspan="7">Grand Total</th>
        <th class="text-end" style="color:darkred">{{ number_format($total_grand, 2) }}</th>
    </thead>
</table>

@endsection