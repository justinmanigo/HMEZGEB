@component('mail::message')
Greetings!

You are invited as {{ $role }} of {{ $owner->firstName . ' ' . $owner->lastName }}'s subscription. You can use the following credentials to login to the system:

@component('mail::panel')
    Email: <strong>{{ $user->email }}</strong><br>
    Password: <strong>{{ $password }}</strong>
@endcomponent

You will be prompted to change your password and update your profile after you login for the first time. Then, you can accept the invitation by navigating to the subscription panel.

If you think this was sent as a mistake, you don't have to take any action. But we strongly recommend you to delete this email immediately.

@component('mail::button', ['url' => config('app.url') . '/'])
Login
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
