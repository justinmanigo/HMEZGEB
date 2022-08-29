@component('mail::message')
Greetings, {{ $owner->firstName . ' ' . $owner->lastName }}!

This is to inform you that your subscription with ID: <strong>{{ $subscription->id }}</strong> has been suspended. You may not be able to access your accounting systems until your subscription is reinstated.

@component('mail::button', ['url' => config('app.url') . '/'])
Login
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
