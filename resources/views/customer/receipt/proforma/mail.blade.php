<style>
    th, td {
       text-align: center;
    }
</style>
@component('mail::message')
Good day,

This is your proforma.

@component('mail::table')
|# | Name | Quantity | Price | Total Price |
|:-----|:-----|:-----|:-----|:-----|
@foreach($proforma_items as $item)
| {{$loop->iteration}} | {{$item->inventory->item_name}} | {{$item->quantity}} | {{$item->price}} | {{$item->total_price}} |
@endforeach
||||**Sub Total:**| {{$proforma->sub_total}} |
||||**Tax:**| {{$proforma->tax}} |
||||**Grand Total:**| {{$proforma->grand_total}} |
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
