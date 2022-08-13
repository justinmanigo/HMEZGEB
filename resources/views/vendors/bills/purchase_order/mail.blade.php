
@component('mail::message')
Good day,

This is your purchase order.

@component('mail::table')
| Due Date | Sub Total | Tax | Grand Total |
| -------- |:----------:|----:| -----------:|
| {{$purchase_order['due_date']}} | {{$purchase_order['sub_total']}} | {{$purchase_order['tax']}} | {{$purchase_order['grand_total']}} |
@endcomponent


Thanks,<br>
{{ config('app.name') }}
@endcomponent
