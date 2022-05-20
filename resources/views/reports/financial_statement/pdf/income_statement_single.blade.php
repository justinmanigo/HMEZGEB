
@extends('reports.template')
@section('page_title', 'Income Statement')
@section('content')

<table>
    <thead>
        <th class="center" width="50%">REVENUES</th>
        <th>DEBIT</th>
        <th>CREDIT</th>
    </thead>
    <tbody>
        <tr>
            <td>Sales</td>
            <td>1000</td>
            <td>100</td>
        </tr>
        <tr>
            <td>Gains</td>
            <td>1000</td>
            <td>100</td>
        </tr>
    </tbody>
    <tfoot>
        <tr>
            <th>Total Revenue</th>
            <td>1000</td>
            <td>100</td>
        </tr>
    </tfoot>

</table>

<table>
    <thead>
        <th class="center" width="50%">EXPENSES</th>
        <th>DEBIT</th>
        <th>CREDIT</th>
    </thead>
    <tbody>
        <tr>
            <td>Cost of Goods Sold</td>
            <td>1000</td>
            <td>100</td>
        <tr>
        <tr>
            <td>Salaries</td>
            <td>1000</td>
            <td>100</td>
        <tr>
        <tr>
            <td>Rent</td>
            <td>1000</td>
            <td>100</td>
        <tr>
        <tr>
            <td>Utilities</td>
            <td>1000</td>
            <td>100</td>
        <tr>
        <tr>
            <td>Interest Expense</td>
            <td>1000</td>
            <td>100</td>
        <tr>    
        <tr>
            <td>Depreciation</td>
            <td>1000</td>
            <td>100</td>
        <tr>
    </tbody>
    <tfoot>
        <tr>
            <th>Total Expenses</th>
            <td>1000</td>
            <td>100</td>
        </tr>
        <tr>
            <th>NET INCOME/LOSE</th>
            <td>1000</td>
            <td>100</td>
        </tr>
    </tfoot>
</table>
@endsection