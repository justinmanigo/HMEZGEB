@extends('reports.template')
@section('page_title', 'Journal Voucher')
@section('content')

<table>
    <thead>
        <th>REFERENCE</th>
        <th>DATE</th>
        <th>ACCOUNT</th>
        <th>DESCRIPTION</th>
        <th>DEBIT</th>
        <th>CREDIT</th>
    </thead>
    <tbody class="border-bottom">
        @foreach($journalVouchers as $jv)
        {{-- Debit --}}
        <tr>
            <td>{{$jv->id}}</td>
            <td>{{date_format($jv->created_at,"Y/m/d");}}</td>
            <td>{{$jv->journalEntry->journalPostings[0]->chartOfAccount->chart_of_account_no}} - {{$jv->journalEntry->journalPostings[0]->chartOfAccount->name}}</td>
            <td>
               {{--! NO DESCRIPTION YET --}}
               N/A
            </td>
            <td class="text-end">
               {{$jv->journalEntry->journalPostings[0]->amount}}
            </td>
            <td></td>
        </tr>
        {{-- Credit --}}
        <tr>
            <td></td>
            <td></td>
            <td>{{$jv->journalEntry->journalPostings[1]->chartOfAccount->chart_of_account_no}} - {{$jv->journalEntry->journalPostings[1]->chartOfAccount->name}}</td>
            <td>
                 {{--! NO DESCRIPTION YET --}}
                 N/A
            </td>
            <td></td>
            <td class="text-end">{{$jv->journalEntry->journalPostings[1]->amount}}</td>
        </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <th></th>
            <td></td>
            <td></td>
            <td>TOTAL</td>
            <td class="text-end">
                {{$totalDebit}}
            </td>
            <td class="text-end">
                {{$totalCredit}}
            </td>
        </tr>
    </tfoot>

</table>
@endsection