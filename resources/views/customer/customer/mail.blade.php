@component('mail::message')
Hello, {{$customer['name']}}.

This is your statement.


@component('mail::table')
| Date     | Due Date     | Amount |   Payment | Balance
|:--------|:-------------|:-------|:---------|:-------|
@foreach($receipts as $receipt)
| {{$receipt['date']}} | {{$receipt['due_date']}} | {{$receipt['grand_total']}} | {{$receipt['total_amount_received']}} | {{$receipt['grand_total']-$receipt['total_amount_received']}} |
@endforeach
@endcomponent

Please pay the above before or on {{$receipt['due_date']}}.

Thanks,<br>
{{ config('app.name') }}
@endcomponent
