@component('mail::message')
Good day,

This is your bank deposit.

{{-- Table --}}
@component('mail::table')
|Name | Value|
| ------------- | ------------- |
|Status | {{$deposit->status}} |
|Ticket Date | {{$deposit->deposit_ticket_date}} |
|Total Amount | {{$deposit->total_amount}} |
|Account Name | {{$deposit->account_name}} |
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
