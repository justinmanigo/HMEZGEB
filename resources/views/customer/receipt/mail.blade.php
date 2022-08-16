<style>
    table{
        width: 100% !important;
    }
    

</style>
@component('mail::message')
Good day,

This is your receipt.

@component('mail::table')
|# | Name | Quantity | Price | Total Price |
|:-----|:-----|:-----|:-----|:-----|
@foreach($receipt_items as $item)
| {{$loop->iteration}} | {{$item->inventory->item_name}} | {{$item->quantity}} | {{$item->price}} | {{$item->total_price}} |
@endforeach
||||**Sub Total:**| {{$item->receiptReference->receipt->sub_total}} |
||||**Tax:**| {{$item->receiptReference->receipt->tax}} |
||||**Withholding:**| {{$item->receiptReference->receipt->withholding}} |
||||**Grand Total:**| {{$item->receiptReference->receipt->grand_total}} |
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
