
@extends('reports.template')
@section('page_title', 'Income Statement')
@section('content')

<table>
    <thead>
        <th class="center" width="50%"></th>
    </thead>
    <tbody>
        <tr>
            <td>Sales</td>
            <td>1000</td>
            <td>100</td>
        </tr>
        <tr>
            <td>Cost of Goods Sold</td>
            <td>1000</td>
            <td>100</td>
        </tr>
    </tbody>
    <tfoot>
        <tr>
            <th>Gross Profit</th>
            <td>1000</td>
            <td>100</td>
        </tr>
    </tfoot>

</table>

<table>
    <thead>
        <th class="center" width="50%">OPERATING EXPENSES</th>
    </thead>
    <tbody>
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
            <td>Depreciation</td>
            <td>1000</td>
            <td>100</td>
        <tr>
    </tbody>
    <tfoot>
        <tr>
            <th>Total Operating Expenses</th>
            <td>1000</td>
            <td>100</td>
        </tr>
        <tr>
            <th>OPERATING INCOME</th>
            <td>1000</td>
            <td>100</td>
        <tr>
    </tfoot>
</table>


<table>
    <thead>
        <th class="center" width="50%">NON-OPERATING OR OTHER</th>
    </thead>
    <tbody>
        <tr>
            <td>Gains</td>
            <td>1000</td>
            <td>100</td>
        <tr>
        <tr>
            <td>Interest Expense</td>
            <td>1000</td>
            <td>100</td>
        <tr>
    </tbody>
    <tfoot>
        <tr>
            <th>Total Non-Operating or Other</th>
            <td>1000</td>
            <td>100</td>
        </tr>
        <tr>
            <th>NET INCOME/LOSE</th>
            <td>1000</td>
            <td>100</td>
        <tr>
    </tfoot>
</table>
@endsection