
@extends('reports.template')
@section('page_title', 'Income Statement')
@section('content')

<table>
    <thead>
        <th width="50%"></th>
        <th></th>
        <th></th>    
    </thead>
    <tbody>
        <tr>
            <td>Sales</td>
            <td class="text-end">1000</td>
            <td class="text-end">100</td>
        </tr>
        <tr>
            <td>Cost of Goods Sold</td>
            <td class="text-end">1000</td>
            <td class="text-end">100</td>
        </tr>
    </tbody>
    <tfoot>
        <tr>
            <th class="text-start">Gross Profit</th>
            <td class="text-end">1000</td>
            <td class="text-end">100</td>
        </tr>
    </tfoot>

</table>

<table>
    <thead>
        <th class="text-start" width="50%">OPERATING EXPENSES</th>
        <th></th>
        <th></th>
    </thead>
    <tbody>
        <tr>
            <td>Salaries</td>
            <td class="text-end">1000</td>
            <td class="text-end">100</td>
        <tr>
        <tr>
            <td>Rent</td>
            <td class="text-end">1000</td>
            <td class="text-end">100</td>
        <tr>
        <tr>
            <td>Utilities</td>
            <td class="text-end">1000</td>
            <td class="text-end">100</td>
        <tr>
        <tr>
            <td>Depreciation</td>
            <td class="text-end">1000</td>
            <td class="text-end">100</td>
        <tr>
    </tbody>
    <tfoot>
        <tr>
            <th class="text-start">Total Operating Expenses</th>
            <td class="text-end">1000</td>
            <td class="text-end">100</td>
        </tr>
        <tr>
            <th class="text-start">OPERATING INCOME</th>
            <td class="text-end">1000</td>
            <td class="text-end">100</td>
        </tr>
    </tfoot>
</table>


<table>
    <thead>
        <th class="text-start" width="50%">NON-OPERATING OR OTHER</th>
        <th></th>
        <th></th>
    </thead>
    <tbody>
        <tr>
            <td>Gains</td>
            <td class="text-end">1000</td>
            <td class="text-end">100</td>
        <tr>
        <tr>
            <td>Interest Expense</td>
            <td class="text-end">1000</td>
            <td class="text-end">100</td>
        <tr>
    </tbody>
    <tfoot>
        <tr>
            <th class="text-start">Total Non-Operating or Other</th>
            <td class="text-end">1000</td>
            <td class="text-end">100</td>
        </tr>
        <tr>
            <th class="text-start">NET INCOME/LOSE</th>
            <td class="text-end">1000</td>
            <td class="text-end">100</td>
        </tr>
    </tfoot>
</table>
@endsection