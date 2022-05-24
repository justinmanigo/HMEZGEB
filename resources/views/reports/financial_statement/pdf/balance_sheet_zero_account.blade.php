@extends('reports.template')
@section('page_title', 'Balance Sheet With Zero Account')
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
            <td class="td-1">Petty Cash</td>
            <td class="td-2 text-end">0.00</td>
            <td class="td-3"></td>
        </tr>
        <tr>
            <td class="td-1">Revolving Fund</td>
            <td class="td-2 text-end">0.00</td>
            <td class="td-3"></td>
        </tr>
        <tr>
            <td class="td-1">Wegagen Bank</td>
            <td class="td-2 text-end">0.00</td>
            <td class="td-3"></td>
        </tr>
        <tr>
            <td class="td-1">Lion Bank</td>
            <td class="td-2 text-end">0.00</td>
            <td class="td-3"></td>
        </tr>
        <tr>
            <td>Accounts Receivable</td>
            <td class="text-end">65,110.70</td>
            <td></td>
        </tr>
        <tr>
            <td class="td-1">Allowance For Unconllecatable</td>
            <td class="td-2 text-end">0.00</td>
            <td class="td-3"></td>
        </tr>
        <tr>
            <td class="td-1">Employees Advance</td>
            <td class="td-2 text-end">0.00</td>
            <td class="td-3"></td>
        </tr>
        <tr>
            <td class="td-1">Owners Receivable</td>
            <td class="td-2 text-end">0.00</td>
            <td class="td-3"></td>
        </tr>
        <tr>
            <td class="td-1">Deptors taff</td>
            <td class="td-2 text-end">0.00</td>
            <td class="td-3"></td>
        </tr>
        <tr>
            <td class="td-1">CPO Receivable</td>
            <td class="td-2 text-end">0.00</td>
            <td class="td-3"></td>
        </tr>
        <tr>
            <td class="td-1">VAT Receivable</td>
            <td class="td-2 text-end">0.00</td>
            <td class="td-3"></td>
        </tr>
        <tr>
            <td class="td-1">Withholding Receivable</td>
            <td class="td-2 text-end">0.00</td>
            <td class="td-3"></td>
        </tr>
        <tr>
            <td class="td-1">Prepaid Rent</td>
            <td class="td-2 text-end">0.00</td>
            <td class="td-3"></td>
        </tr>
        <tr>
            <td class="td-1">Advance Profit Tax</td>
            <td class="td-2 text-end">0.00</td>
            <td class="td-3"></td>
        </tr>
        <tr>
            <td class="td-1">Suspense Account</td>
            <td class="td-2 text-end">0.00</td>
            <td class="td-3"></td>
        </tr>
        <tr>
            <td class="td-1">Finished Goods Inventory</td>
            <td class="td-2 text-end">0.00</td>
            <td class="td-3"></td>
        </tr>
        <tr>
            <td class="td-1">Raw Material</td>
            <td class="td-2 text-end">0.00</td>
            <td class="td-3"></td>
        </tr>
        <tr>
            <td class="td-1">Work in Progress - GPPSGeneral</td>
            <td class="td-2 text-end">0.00</td>
            <td class="td-3"></td>
        </tr>
        <tr>
            <td class="td-1">Work in Progress - GPPS123P</td>
            <td class="td-2 text-end">0.00</td>
            <td class="td-3"></td>
        </tr>
        <tr>
            <td class="td-1">Work in Progress - HIPS622P</td>
            <td class="td-2 text-end">0.00</td>
            <td class="td-3"></td>
        </tr>
        <tr>
            <td class="td-1">Work in Progress - Powder</td>
            <td class="td-2 text-end">0.00</td>
            <td class="td-3"></td>
        </tr>
        <tr>
            <td class="td-1">Work in Progress - YellowColor</td>
            <td class="td-2 text-end">0.00</td>
            <td class="td-3"></td>
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
            <td class="td-1">Office Furniture</td>
            <td class="td-2 text-end">0.00</td>
            <td class="td-3"></td>
        </tr>
        <tr>
            <td class="td-1">Accumulated-office Furniture
            </td>
            <td class="td-2 text-end">0.00</td>
            <td class="td-3"></td>
        </tr>
        <tr>
            <td class="td-1">Computer
            </td>
            <td class="td-2 text-end">0.00</td>
            <td class="td-3"></td>
        </tr>
        <tr>
            <td class="td-1">Accumulated Dep-Computer
            </td>
            <td class="td-2 text-end">0.00</td>
            <td class="td-3"></td>
        </tr>
        <tr>
            <td class="td-1">Automobile
            </td>
            <td class="td-2 text-end">0.00</td>
            <td class="td-3"></td>
        </tr>
        <tr>
            <td class="td-1">Accumulated Dep - Automobile
            </td>
            <td class="td-2 text-end">0.00</td>
            <td class="td-3"></td>
        </tr>
        <tr>
            <td class="td-1">Land
            </td>
            <td class="td-2 text-end">0.00</td>
            <td class="td-3"></td>
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
            <td class="td-1">Accounts Payable</td>
            <td class="td-2 text-end">0.00</td>
            <td class="td-3"></td>
        </tr>
        <tr>
            <td class="td-1">Salary Payable</td>
            <td class="td-2 text-end">0.00</td>
            <td class="td-3"></td>
        </tr>
        <tr>
            <td class="td-1">Income Tax Payable</td>
            <td class="td-2 text-end">0.00</td>
            <td class="td-3"></td>
        </tr>
        <tr>
            <td class="td-1">Pension Fund Payable</td>
            <td class="td-2 text-end">0.00</td>
            <td class="td-3"></td>
        </tr>
        <tr>
            <td class="td-1">VAT Payable</td>
            <td class="td-2 text-end">51,718.25</td>
            <td class="td-3"></td>
        </tr>
        <tr>
            <td class="td-1">Withholding Tax Payable</td>
            <td class="td-2 text-end">0.00</td>
            <td class="td-3"></td>
        </tr>
        <tr>
            <td class="td-1">Cost Sharing Payable</td>
            <td class="td-2 text-end">0.00</td>
            <td class="td-3"></td>
        </tr>
        <tr>
            <td class="td-1">Profit Tax Payable</td>
            <td class="td-2 text-end">0.00</td>
            <td class="td-3"></td>
        </tr>
        <tr>
            <td class="td-1">Payable To Owner</td>
            <td class="td-2 text-end">0.00</td>
            <td class="td-3"></td>
        </tr>
        <tr>
            <td class="td-1">Credit Association Payable</td>
            <td class="td-2 text-end">0.00</td>
            <td class="td-3"></td>
        </tr>
        <tr>
            <td class="td-1">Loan Payable to Lasta Bank</td>
            <td class="td-2 text-end">0.00</td>
            <td class="td-3"></td>
        </tr>
        <tr>
            <td class="td-1">Accrued Payable</td>
            <td class="td-2 text-end">0.00</td>
            <td class="td-3"></td>
        </tr>
        <tr>
            <td class="td-1">Dividend Payable</td>
            <td class="td-2 text-end">0.00</td>
            <td class="td-3"></td>
        </tr>
        <tr>
            <td class="td-1">Dividend Tax Payable</td>
            <td class="td-2 text-end">0.00</td>
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
            <td class="td-1">Beginning Equity</td>
            <td class="td-2 text-end">0.00</td>
            <td class="td-3"></td>
        </tr>
        <tr>
            <td class="td-1">Partner's Contribution</td>
            <td class="td-2 text-end">0.00</td>
            <td class="td-3"></td>
        </tr>
        <tr>
            <td class="td-1">Partner's Draw</td>
            <td class="td-2 text-end">0.00</td>
            <td class="td-3"></td>
        </tr>
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