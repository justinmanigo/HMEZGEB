
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>PDF</title>
    <style>
        .page-break {
            page-break-after: always;
        }

        table{
            width: 100%;
            margin-top: 25px;
            border-collapse: collapse;
        }

        .table-total {
            color:darkgreen;
        }

        .table-bordered th, .table-bordered td{
            border: 1px solid black;
            border-collapse: collapse;
            padding: 2px;
        }
        
        .table-padding-5 th, .table-padding-5 td{
            padding: 5px;
        }

        /* th,td{
            
        } */
        .border-bottom{
            border-bottom: 1px solid black;
        }
        .border-bottom-3{
            border-bottom: 3px solid black;
        }
        .border-right-3 {
            border-right: 3px solid black;
        }

        .blank_row
        {
            height: 15px ;
        }

        tfoot, .border-top-3
        {
            border-top:3px solid black;
        }

        .text-start
        {
            text-align:left;
        }

        .text-center{
            text-align: center;
        }

        .text-end
        {
            text-align:right;
        }

    </style>
    @stack('style')
</head>

<body>
    <main>
        @for($i = 0; $i < count($r); $i++)
            <h3 style="margin:0">{{ $r[$i]->coa_no . ' - ' . $r[$i]->coa_name }}</h3>
            <p>{{$request->date_from}} - {{$request->date_to}}</p>
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

            @if($i+1 < count($r))
                <div class="page-break"></div>
            @endif
        @endfor

    </main>

</body>
</html>