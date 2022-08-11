@component('mail::message')
Good day,$bank_transfer

This is your bank transfer details.

@component('mail::table')
|Transfer Date | Transfer Amount | Transfer Status | From Account | To Account |
|:--------|:-------------|:-------|:---------| :-------|:-------| 
| {{date_format($bank_transfer['created_at'],"Y/m/d");}} | {{$bank_transfer['amount']}} | {{$bank_transfer['status']}} | {{$bank_transfer['fromAccount']->chartOfAccount->account_name}} | {{$bank_transfer['toAccount']->chartOfAccount->account_name}} | 

@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
