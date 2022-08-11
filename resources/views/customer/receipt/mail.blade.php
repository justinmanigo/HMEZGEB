<style>
    table{
        width: 100% !important;
    }
    

</style>
@component('mail::message')
Good day,

This is your receipt.


@component('mail::table')
Due Date | Sub Total | Discount | Tax | Grand Total | Total Amount Received | Withholding  | Payment Method
|:--------|:-------------|:-------|:---------|:-------| :-------|:-------|:-------|:-------|
| {{$receipt['due_date']}} | {{$receipt['grand_total']}} | {{$receipt['discount']}} | {{$receipt['tax']}} | {{$receipt['grand_total']-$receipt['total_amount_received']}} | {{$receipt['total_amount_received']}} | {{$receipt['withholding']}}  | {{$receipt['payment_method']}} |
@endcomponent


Thanks,<br>
{{ config('app.name') }}
@endcomponent
