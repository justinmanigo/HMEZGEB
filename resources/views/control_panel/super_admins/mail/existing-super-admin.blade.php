@component('mail::message')
# You are invited as a new super admin of {{ config('app.name') }}

Greetings!

You are invited to join the {{ config('app.name') }} super admin team. Since you are already a registered user, you can use the current credentials to login and accept the invitation.

If you think this was sent as a mistake, you don't have to take any action.

@component('mail::button', ['url' => config('app.url') . '/'])
Login
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
