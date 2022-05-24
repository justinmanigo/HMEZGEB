
@extends('reports.template')
@section('page_title', 'Income Statement')
@section('content')

<table>
    <thead >
        <th class="text-start" width="50%">REVENUES</th>
        <th></th>
        <th></th>
    </thead>
    <tbody>
        <tr>
            <td class="text-start">Sales</td>
            <td class="text-end">1000</td>
            <td class="text-end">100</td>
        </tr>
        <tr>
            <td class="text-start">Gains</td>
            <td class="text-end">1000</td>
            <td class="text-end">100</td>
        </tr>
    </tbody>
    <tfoot>
        <tr>
            <th class="text-start">Total Revenue</th>
            <td class="text-end">1000</td>
            <td class="text-end">100</td>
        </tr>
    </tfoot>

</table>

<table>
    <thead>
        <th class="text-start" width="50%">EXPENSES</th>
        <th></th>
        <th></th>
    </thead>
    <tbody>
        <tr>
            <td class="text-start">Cost of Goods Sold</td>
            <td class="text-end">1000</td>
            <td class="text-end">100</td>
        <tr>
        <tr>
            <td class="text-start">Salaries</td>
            <td class="text-end">1000</td>
            <td class="text-end">100</td>
        <tr>
        <tr>
            <td class="text-start">Rent</td>
            <td class="text-end">1000</td>
            <td class="text-end">100</td>
        <tr>
        <tr>
            <td class="text-start">Utilities</td>
            <td class="text-end">1000</td>
            <td class="text-end">100</td>
        <tr>
        <tr>
            <td class="text-start">Interest Expense</td>
            <td class="text-end">1000</td>
            <td class="text-end">100</td>
        <tr>    
        <tr>
            <td class="text-start">Depreciation</td>
            <td class="text-end">1000</td>
            <td class="text-end">100</td>
        <tr>
    </tbody>
    <tfoot>
        <tr>
            <th class="text-start">Total Expenses</th>
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