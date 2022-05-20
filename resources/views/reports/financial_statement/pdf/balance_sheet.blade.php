@extends('reports.template')
@section('content')
<h4 class="center">Balance Sheet</h4>
<p class="center">{{$request->date_from}} - {{$request->date_to}}</p>
<table>
    <thead>
        <th class="center">ASSETS</th>
        <th class="align-right">DEBIT</th>
        <th class="align-right">CREDIT</th>
    </thead>
    <thead>
        <th width="50%">Current Assets</th>
        <th></th>
        <th></th>
    </thead>
    <tbody>
        <tr>
            <th>Cash on Hand</th>
            <td>1000</td>
            <td>100</td>
        </tr>
        <tr>
            <th>Accounts Receivable</th>
            <td class="border-bottom">1000</td>
            <td>100</td>
        </tr>
        <br>
        <tr>
            <th>Total Current Assets</th>
            <td>1000</td>
            <td>100</td>
        </tr>
        <br>
        <tr>
            <th>Property and Equipment</th>
            <td>1000</td>
            <td>100</td>
        </tr>
        <br>
        <tr>
            <th>Property and Equipment</th>
            <td>1000</td>
            <td>100</td>
        </tr><br>
        <tr>
            <th>Other Assets</th>
            <td>1000</td>
            <td>100</td>
        </tr>
        <br>
        <tr>
            <th>Total Other Assets</th>
            <td>1000</td>
            <td>100</td>
        </tr>
        <br>
        <tr>
            <th>Total Assets</th>
            <td>1000</td>
            <td>100</td>
        </tr>
    </tbody>

</table>

<table>
    <thead>
        <th class="center">LIABILITIES AND CAPITAL</th>
    </thead>
    <thead>
        <th width="50%">Current Liabilities</th>
        <th></th>
        <th></th>
    </thead>
    <tbody>
        <tr>
            <th>VAT Payables</th>
            <td>1000</td>
            <td>100</td>
        <tr>
        <br>
        <tr>
            <th>Total Current Liabilities</th>
            <td>1000</td>
            <td>100</td>
        </tr>
        <br>
        <tr>
            <th>Long-Term Liabilities</th>
            <td>1000</td>
            <td>100</td>
        </tr>
        <br>
        <tr>
            <th>Total Long-Term Liabilities</th>
            <td>1000</td>
            <td>100</td>
        </tr>
        <br>
        <tr>
            <th>Total Liabilities</th>
            <td>1000</td>
            <td>100</td>
        </tr>
        <br>
        <tr>
            <th>Capital</th>
            <td>1000</td>
            <td>100</td>
        </tr>
        <br>
        <tr>
            <th>Capital</th>
            <td>1000</td>
            <td>100</td>
        </tr>
        <tr>
            <th>Net Income</th>
            <td>1000</td>
            <td>100</td>
        </tr>
        <br>
        <tr>
            <th>Total Capital</th>
            <td>1000</td>
            <td>100</td>
        </tr>
        <br>
        <tr>
            <th>Total Liabilities & Capital</th>
            <td>1000</td>
            <td>100</td>
        </tr>
    </tbody>
</table>
@endsection