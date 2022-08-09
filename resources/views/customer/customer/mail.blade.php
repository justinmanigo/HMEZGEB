@component('mail::message')
Hello, {{$customer['name']}}.

This is your statement.


@component('mail::table')
| Date     | Due Date     | Amount |   Payment | Balance
|:--------|:-------------|:-------|:---------|:-------|
| {{$receipts['date']}} | {{$receipts['due_date']}} | {{$receipts['grand_total']}} | {{$receipts['total_amount_received']}} | {{$receipts['grand_total']-$receipts['total_amount_received']}} |
@endcomponent

Please pay the above before or on {{$receipts['due_date']}}.

Thanks,<br>
{{ config('app.name') }}
@endcomponent
