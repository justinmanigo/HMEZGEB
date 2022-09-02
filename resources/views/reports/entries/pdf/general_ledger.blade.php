
@extends('reports.template')
@section('page_title', 'General Ledger')
@section('content')

@for($i = 0; $i < count($r); $i++)
    <h3>{{ $r[$i]->coa_no . ' - ' . $r[$i]->coa_name }}</h3>
    @php
        if(count($jp_d[$i]) < count($jp_c[$i])){
            $loop_limit = count($jp_c[$i]);
        }
        else{
            $loop_limit = count($jp_d[$i]);
        }

        $total_debit = 0;
        $total_credit = 0
    @endphp

    <table class="table table-padding-5">
        <thead class="border-bottom-3">
            <th colspan="@if($loop_limit == 0) 1 @else 2 @endif" style="width:50%" class="border-right-3">Debit</th>
            <th colspan="@if($loop_limit == 0) 1 @else 2 @endif" style="width:50%">Credit</th>
        </thead>
        <tbody>
            @for($j = 0; $j < $loop_limit; $j++)
                <tr>
                    @php
                        // Debit
                        try {
                            echo "
                                <td style='width:20%'>{$jp_d[$i][$j]->date}</td>
                                <td style='width:30%' class='text-end border-right-3'>".number_format($jp_d[$i][$j]->amount, 2)."</td>
                            ";

                            $total_debit += $jp_d[$i][$j]->amount;
                        } catch(\Exception $e) {
                            echo "
                                <td style='width:20%'>&nbsp;</td>
                                <td style='width:30%' class='text-end border-right-3'>&nbsp;</td>
                            ";
                        }
                        // Credit
                        try {
                            echo "
                                <td style='width:20%'>{$jp_c[$i][$j]->date}</td>
                                <td style='width:30%' class='text-end'>".number_format($jp_c[$i][$j]->amount, 2)."</td>
                            ";

                            $total_credit += $jp_c[$i][$j]->amount;
                        } catch(\Exception $e) {
                            echo "
                                <td style='width:20%'>&nbsp;</td>
                                <td style='width:30%' class='text-end'>&nbsp;</td>
                            ";
                        }
                    @endphp
                </tr>
            @endfor
        </tbody>
        <tfoot>
            <th colspan="@if($loop_limit == 0) 1 @else 2 @endif" style="width:50%" class="text-end border-right-3">{{ number_format($total_debit, 2) }}</th>
            <th colspan="@if($loop_limit == 0) 1 @else 2 @endif" style="width:50%" class="text-end">{{ number_format($total_credit, 2) }}</th>
        </tfoot>
    </table>

@endfor

@endsection