@component('mail::message')
Greetings!

This is to inform you that you are removed as {{ $role }} of {{ $owner->firstName . ' ' . $owner->lastName }}'s subscription.

This would also mean you no longer have access to its accounting systems and other privileges.

@component('mail::button', ['url' => config('app.url')])
    Purchase a Subscription
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
