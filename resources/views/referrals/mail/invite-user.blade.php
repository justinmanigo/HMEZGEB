@component('mail::message')
Greetings!

{{ $user->firstName . ' ' . $user->lastName }} has invited you to try {{ config('app.name') }}! To get started, copy the referral code, then open the signup form by clicking the button and paste it in the referral code field.

@component('mail::panel')
    Referral Code: <strong>{{ $code }}</strong>
@endcomponent

@component('mail::button', ['url' => config('app.url') . '/'])
    Sign Up to {{ config('app.name') }}!
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
