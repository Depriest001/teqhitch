<x-mail::message>
<p>Hello {{ $user->name }},</p>

<p>You recently requested to reset your password for your {{ config('app.name') }} account.</p>

<x-mail::button :url="$url">
Reset Password
</x-mail::button>

<p style="margin-bottom: 10px;">
    If the button does not work, copy and paste this link into your browser:
</p>

<p style="word-break: break-all;margin-bottom: 10px;">
    <a href="{{ $url }}" target="_blank">{{ $url }}</a>
</p>
<p style="margin-bottom: 10px;">If you did not request a password reset, please ignore this email.</p>
<p style="margin-bottom: 10px;">If you have any questions or need assistance, please contact our support team. We are always ready to help.</p>
<p style="margin-bottom: 10px;">
    Thank you for choosing Laravel. <br>
    We look forward to supporting your success.
</p>
<hr>
<p style="margin-top: 10px;">
    Best Regards,<br>
    <strong>{{ config('app.name') }} Team</strong> <br>
    Online Courses | Seminars | Project Writing <br>
    Email: support@teqhitch.com <br>
    Website:{{ config('app.url') }}
</p>
</x-mail::message>