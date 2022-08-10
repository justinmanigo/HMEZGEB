@component('mail::message')
Good day,

This is your deposit receipt.

{{-- Table --}}
@component('mail::table')
| Status          | Ticket Date | Total Amount | Account Name |
| ------------- |:-----------:| -----------:| -----------:|
| {{ $deposits['status'] }} | {{ $deposits['deposit_ticket_date'] }} | {{ $deposits['total_amount'] }} | {{ $deposits['account_name'] }} |
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
