@extends('reports.template')
@section('page_title', 'Balance Sheet')
@push('style')
<style>
    .td-1 {
        width:60%;
    }

    .td-2 {
        width:20%;
    }

    .td-3 {
        width:20%;
    }
</style>

@endpush
@section('content')

<br>
<h3>ASSETS</h3>

{{-- Current Assets --}}
<table>
    <thead>
        <td colspan="3" class="text-start"><strong>CURRENT ASSETS</strong></td>
    </thead>
    <tbody>
        <tr>
            <td class="td-1">Cash on Hand</td>
            <td class="td-2 text-end">331,395.75</td>
            <td class="td-3"></td>
        </tr>
        <tr>
            <td>Accounts Receivable</td>
            <td class="text-end">65,110.70</td>
            <td></td>
        </tr>
    </tbody>
    <tfoot>
        <th colspan="2" class="text-start">TOTAL CURRENT ASSETS</th>
        <th class="text-end">396.506.45</th>
    </tfoot>
</table>

{{-- Property and Equipment --}}
<table>
    <thead>
        <th colspan="3" class="text-start">PROPERTY AND EQUIPMENT</th>
    </thead>
    <tbody>
        <tr>
            <td class="td-1"></td>
            <td class="td-2 text-end"></td>
            <td class="td-3"></td>
        </tr>
        <tr>
            <td></td>
            <td class="text-end"></td>
            <td></td>
        </tr>
    </tbody>
    <tfoot>
        <th colspan="2" class="text-start">TOTAL PROPERTY AND EQUIPMENT</th>
        <th class="text-end">0.00</th>
    </tfoot>
</table>

{{-- Other Assets--}}
<table>
    <thead>
        <th colspan="3" class="text-start">OTHER ASSETS</th>
    </thead>
    <tbody>
        <tr>
            <td class="td-1"></td>
            <td class="td-2 text-end"></td>
            <td class="td-3"></td>
        </tr>
    </tbody>
    <tfoot>
        <th colspan="2" class="text-start">TOTAL OTHER ASSETS</th>
        <th class="text-end">0.00</th>
    </tfoot>
</table>

{{-- TOTAL ASSETS --}}
<table class="table-total">
    <thead class="border-top-3">
        <th colspan="2" class="text-start">TOTAL ASSETS</th>
        <th class="text-end">396,506.45</th>
    </thead>
</table>

<br>
<br>
<h3>LIABILITIES AND CAPITAL</h3>

{{-- Current Liabilities --}}
<table>
    <thead>
        <th colspan="3" class="text-start">CURRENT LIABILITIES</th>
    </thead>
    <tbody>
        <tr>
            <td class="td-1">VAT Payable</td>
            <td class="td-2 text-end">51,718.25</td>
            <td class="td-3"></td>
        </tr>
    </tbody>
    <tfoot>
        <th colspan="2" class="text-start">TOTAL CURRENT LIABILITIES</th>
        <th class="text-end">51,718.25</th>
    </tfoot>
</table>

{{-- Long-Term Liabilities --}}
<table>
    <thead>
        <th colspan="3" class="text-start">LONG-TERM LIABILITIES</th>
    </thead>
    <tbody>
        <tr>
            <td class="td-1"></td>
            <td class="td-2 text-end"></td>
            <td class="td-3"></td>
        </tr>
    </tbody>
    <tfoot>
        <th colspan="2" class="text-start">TOTAL LONG-TERM LIABILITIES</th>
        <th class="text-end">0.00</th>
    </tfoot>
</table>

{{-- TOTAL LIABILITIES --}}
<table>
    <thead class="border-top-3">
        <th colspan="2" class="text-start">TOTAL LIABILITIES</th>
        <th class="text-end">51,718.25</th>
    </thead>
</table>

{{-- Capital --}}
<table>
    <thead>
        <th colspan="3" class="text-start">CAPITAL</th>
    </thead>
    <tbody>
        <tr>
            <td class="td-1">Net Income</td>
            <td class="td-2 text-end">344,788.20</td>
            <td class="td-3"></td>
        </tr>
    </tbody>
    <tfoot>
        <th colspan="2" class="text-start">TOTAL CAPITAL</th>
        <th class="text-end">344,788.20</th>
    </tfoot>
</table>

{{-- TOTAL LIABILITIES AND CAPITAL --}}
<table class="table-total">
    <thead class="border-top-3">
        <th colspan="2" class="text-start">TOTAL LIABILITIES AND CAPITAL</th>
        <th class="text-end">396,506.45</th>
    </thead>
</table>
@endsection