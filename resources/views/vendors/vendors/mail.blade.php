@component('mail::message')
Hello, {{$vendors['name']}}.

This is your statement.


@component('mail::table')
| Date     | Due Date     | Amount |   Payment | Balance
|:--------|:-------------|:-------|:---------|:-------|
@foreach($bills as $bill)
| {{$bill['date']}} | {{$bill['due_date']}} | {{$bill['grand_total']}} | {{$bill['amount_received']}} | {{$bill['grand_total']-$bill['amount_received']}} |
@endforeach
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
