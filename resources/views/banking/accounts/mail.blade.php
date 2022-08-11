<style>
    table{
        width: 100% !important;
    }
</style>

@component('mail::message')
Good day,

This is your bank account details.

@component('mail::table')
Account Name | Account Number  | Bank Branch | Account Type | Account Status | Account Balance |
|:--------|:-------------|:-------|:---------|:-------| :-------|:-------|:-------|
| {{$bank_account['account_name']}} | {{$bank_account['bank_account_number']}}  | {{$bank_account['bank_branch']}} | {{$bank_account['bank_account_type']}} | {{$bank_account['status']}} | {{$bank_account['current_balance']}} |
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
