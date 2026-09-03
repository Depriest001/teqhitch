@component('mail::message')
# Welcome, {{ $student->full_name ?? $student->name }}!

Your payment for the SIWES / IT Placement programme has been received, and your student account is ready.

Here are your login details:

@component('mail::panel')
**Email:** {{ $student->email }}
**Temporary password:** {{ $password }}
@endcomponent

@component('mail::button', ['url' => $loginUrl])
Log in to your dashboard
@endcomponent

For your security, please log in and change this password as soon as possible.

Thanks,<br>
{{ config('app.name') }}
@endcomponent