<style>
    table{
        width: 100% !important;
    }
    

</style>
@component('mail::message')
Good day,

This is your bill.


@component('mail::table')
Due Date | Sub Total | Discount | Tax | Grand Total | Total Amount Received | Withholding | Withholding Status  | Payment Method
|:--------|:-------------|:-------|:---------|:-------| :-------|:-------|:-------|:-------| 
| {{$bills['due_date']}} | {{$bills['grand_total']}} | {{$bills['discount']}} | {{$bills['tax']}} | {{$bills['grand_total']-$bills['amount_received']}} | {{$bills['amount_received']}} | {{$bills['withholding']}}|  {{$bills['withholding_status']}} | {{$bills['payment_method']}} |
@endcomponent


Thanks,<br>
{{ config('app.name') }}
@endcomponent
