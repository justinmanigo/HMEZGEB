@extends('reports.template')
@section('page_title', 'Balance Sheet')
@section('content')

<table>
    <thead>
        <th class="center" width="50%">ASSETS</th>
        <th class="align-right">DEBIT</th>
        <th class="align-right">CREDIT</th>
    </thead>
    <tbody>
        <tr>
            <td>Current Assets</td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>Cash on Hand</td>
            <td>1000</td>
            <td>100</td>
        </tr>
        <tr>
            <td>Accounts Receivable</td>
            <td class="border-bottom">1000</td>
            <td>100</td>
        </tr>
        <tr>
            <td colspan="3" class="blank_row"></td>
        </tr>
        <tr>
            <td>Total Current Assets</td>
            <td>1000</td>
            <td>100</td>
        </tr>
        <tr>
            <td colspan="3" class="blank_row"></td>
        </tr>
        <tr>
            <td>Property and Equipment</td>
            <td>1000</td>
            <td>100</td>
        </tr>
        <tr>
            <td colspan="3" class="blank_row"></td>
        </tr>
        <tr>
            <td>Property and Equipment</td>
            <td>1000</td>
            <td>100</td>
        </tr>
        <tr>
            <td colspan="3" class="blank_row"></td>
        </tr>
        <tr>
            <td>Other Assets</td>
            <td>1000</td>
            <td>100</td>
        </tr>
        <tr>
            <td colspan="3" class="blank_row"></td>
        </tr>
        <tr>
            <td>Total Other Assets</td>
            <td>1000</td>
            <td>100</td>
        </tr>
        <tr>
            <td colspan="3" class="blank_row"></td>
        </tr>
        <tr>
            <td>Total Assets</td>
            <td>1000</td>
            <td>100</td>
        </tr>
    </tbody>

</table>

<table>
    <thead>
        <th class="center" width="50%">LIABILITIES AND CAPITAL</th>
        <th class="align-right">DEBIT</th>
        <th class="align-right">CREDIT</th>
    </thead>

    <tbody>
        <tr>
            <td>Current Liabilities</td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>VAT Payables</td>
            <td>1000</td>
            <td>100</td>
        </tr>
        <tr>
            <td colspan="3" class="blank_row"></td>
        </tr>
        <tr>
            <td>Total Current Liabilities</td>
            <td>1000</td>
            <td>100</td>
        </tr>
        <tr>
            <td colspan="3" class="blank_row"></td>
        </tr>
        <tr>
            <td>Long-Term Liabilities</td>
            <td>1000</td>
            <td>100</td>
        </tr>
        <tr>
            <td colspan="3" class="blank_row"></td>
        </tr>
        <tr>
            <td>Total Long-Term Liabilities</td>
            <td>1000</td>
            <td>100</td>
        </tr>
        <tr>
            <td colspan="3" class="blank_row"></td>
        </tr>
        <tr>
            <td>Total Liabilities</td>
            <td>1000</td>
            <td>100</td>
        </tr>
        <tr>
            <td colspan="3" class="blank_row"></td>
        </tr>
        <tr>
            <td>Capital</td>
            <td>1000</td>
            <td>100</td>
        </tr>
        <tr>
            <td colspan="3" class="blank_row"></td>
        </tr>
        <tr>
            <td>Capital</td>
            <td>1000</td>
            <td>100</td>
        </tr>
        <tr>
            <td>Net Income</td>
            <td>1000</td>
            <td>100</td>
        </tr>
        <tr>
            <td colspan="3" class="blank_row"></td>
        </tr>
        <tr>
            <td>Total Capital</td>
            <td>1000</td>
            <td>100</td>
        </tr>
        <tr>
            <td colspan="3" class="blank_row"></td>
        </tr>
        <tr>
            <td>Total Liabilities & Capital</td>
            <td>1000</td>
            <td>100</td>
        </tr>
    </tbody>
</table>
@endsection