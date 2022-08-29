@component('mail::message')
Greetings, {{ $owner->firstName . ' ' . $owner->lastName }}!

This is to inform you that your subscription with ID: <strong>{{ $subscription->id }}</strong> has been activated up until {{ $subscription->date_to }}.

@component('mail::button', ['url' => config('app.url') . '/'])
Login
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
