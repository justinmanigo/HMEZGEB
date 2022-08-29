@component('mail::message')
Greetings!

You are invited as {{ $role }} of {{ $owner->firstName . ' ' . $owner->lastName }}'s subscription. Since you are already a registered user, you can use your current credentials to login and accept the invitation.

If you think this was sent as a mistake, you don't have to take any action. 

@component('mail::button', ['url' => config('app.url') . '/'])
Login
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
