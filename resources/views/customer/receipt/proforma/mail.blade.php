<style>
    th, td {
       text-align: center;
    }
</style>
@component('mail::message')
Good day,

This is your proforma.

@component('mail::table')
| Due Date | Amount | Tax | Remark |
| ------------- |:-------------:| ------------- | ------------- |
|{{$proforma['due_date']}} | {{$proforma['amount']}} | {{$proforma['tax']}} | {{$proforma['remark']}} |
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
