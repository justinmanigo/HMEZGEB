@component('mail::message')
Good day,

This is your credit receipt.


@component('mail::table')
| Date | Total Amount Received | Remark | 
| ------------- |:-------------:| ------------- |
{{$credit_receipt['receiptReference']->date}} | {{$credit_receipt['total_amount_received']}} | {{$credit_receipt['remark']}} |

@endcomponent


Thanks,<br>
{{ config('app.name') }}
@endcomponent
