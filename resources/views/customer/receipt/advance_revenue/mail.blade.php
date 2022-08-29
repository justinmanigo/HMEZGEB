@component('mail::message')
Good day,

This is your advance revenue.


@component('mail::table')
| Date | Total Amount Received | Remark | 
| ------------- |:-------------:| ------------- |
{{$advance_revenue['receiptReference']->date}} | {{$advance_revenue['total_amount_received']}} | {{$advance_revenue['remark']}} |

@endcomponent


Thanks,<br>
{{ config('app.name') }}
@endcomponent
