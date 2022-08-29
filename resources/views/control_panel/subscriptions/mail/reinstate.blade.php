@component('mail::message')
Greetings, {{ $owner->firstName . ' ' . $owner->lastName }}!

This is to inform you that your subscription with ID: <strong>{{ $subscription->id }}</strong> has been reinstated. You may now be able to access your accounting systems.

@component('mail::button', ['url' => config('app.url') . '/'])
Login
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
