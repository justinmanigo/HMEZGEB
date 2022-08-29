@component('mail::message')
# You are removed as a new super admin of {{ config('app.name') }}

Greetings!

This is to inform you that you are removed as super admin of {{ config('app.name') }}.

Your unlimited subscription privileges will remain active within a week unless you reactivate by purchasing a subscription.

Thanks,<br>
{{ config('app.name') }}
@endcomponent
