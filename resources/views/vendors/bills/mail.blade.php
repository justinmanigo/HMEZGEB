<style>
    table{
        width: 100% !important;
    }
    

</style>
@component('mail::message')
Good day,

This is your bill.

@component('mail::table')
|# | Name | Quantity | Price | Total Price |
|:-----|:-----|:-----|:-----|:-----|
@foreach($bill_items as $item)
| {{$loop->iteration}} | {{$item->inventory->name}} | {{$item->quantity}} | {{$item->price}} | {{$item->total_price}} |
@endforeach
||||**Sub Total:**| {{$item->paymentReference->bills->sub_total}} |
||||**Tax:**| {{$item->paymentReference->bills->tax}} |
||||**Withholding:**| {{$item->paymentReference->bills->withholding}} |
||||**Grand Total:**| {{$item->paymentReference->bills->grand_total}} |
@endcomponent


Thanks,<br>
{{ config('app.name') }}
@endcomponent
