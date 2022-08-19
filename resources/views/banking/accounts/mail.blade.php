<style>
    table{
        width: 100% !important;
    }
</style>

@component('mail::message')
Good day,

This is your bank account details.

@component('mail::table')
| Name | Value |
|:------------- |:------------- |
| Account Name | {{$bank_account->chartOfAccount->account_name}} |
| Account Number | {{$bank_account->bank_account_number}} |
| Bank Branch | {{$bank_account->bank_branch}} |
| Account Type | {{$bank_account->bank_account_type}} |
| Status | {{$bank_account->chartOfAccount->status}} |
| Account Balance | {{$bank_account->chartOfAccount->current_balance}} |
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
