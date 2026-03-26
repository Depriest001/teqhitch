<x-mail::message>
<p>Hello 👋</p>

<p>Thank you for subscribing to our newsletter at <strong>{{ config('app.name') }}</strong>!</p>

<p>To confirm your subscription, please click the button below:</p>

<x-mail::button :url="$url">
Confirm Subscription
</x-mail::button>

<p style="margin-bottom: 10px;">
    If the button does not work, copy and paste this link into your browser:
</p>

<p style="word-break: break-all; margin-bottom: 10px;">
    <a href="{{ $url }}" target="_blank">{{ $url }}</a>
</p>

<p style="margin-bottom: 10px;">
    Once confirmed, you'll receive regular updates, tips, and exclusive content from us.
</p>

<p style="margin-bottom: 10px;">
    If you did not subscribe to our newsletter, you can safely ignore this email.
</p>

<p style="margin-bottom: 10px;">
    We are excited to have you with us!
</p>

<hr>

<p style="margin-top: 10px;">
    Best Regards,<br>
    <strong>{{ config('app.name') }} Team</strong> <br>
    Online Courses | Seminars | Project Writing <br>
    Email: support@teqhitch.com <br>
    Website: {{ config('app.url') }}
</p>
</x-mail::message>