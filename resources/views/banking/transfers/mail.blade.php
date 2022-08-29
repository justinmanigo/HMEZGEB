@component('mail::message')
Good day,

This is your bank transfer details.

@component('mail::table')
| Name | Value |
|:------------- |:------------- |
|Transfer Date | {{date_format($bank_transfer->created_at,"Y/m/d")}} |
|Transfer Amount | {{$bank_transfer->amount}} |
|Transfer Status | {{$bank_transfer->status}} |
|From Account | {{$bank_transfer->fromAccount->chartOfAccount->account_name}} |
|To Account | {{$bank_transfer->toAccount->chartOfAccount->account_name}} |
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
