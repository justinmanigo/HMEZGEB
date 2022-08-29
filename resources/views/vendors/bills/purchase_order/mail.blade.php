
@component('mail::message')
Good day,

This is your purchase order.

@component('mail::table')
| Name | Value |
| :--- | :--- |
| Due Date | {{$purchase_order->due_date}} |
| Sub Total | {{$purchase_order->sub_total}} |
| Tax | {{$purchase_order->tax}} |
| Grand Total | {{$purchase_order->grand_total}} |
@endcomponent


Thanks,<br>
{{ config('app.name') }}
@endcomponent
