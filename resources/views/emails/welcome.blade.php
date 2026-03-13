<x-mail::message>

<p style="margin-bottom: 10px;">Hello {{ $user->name }},</p>

<p style="margin-bottom: 10px;">
Welcome to <strong>{{ config('app.name') }}</strong>! Your account has been successfully created and verified.
</p>

<p style="margin-bottom: 10px;">
You can now log in and start exploring our services, including online courses, seminars, and project writing assistance.
</p>

<x-mail::button :url="config('app.url')" :color="'primary'">
Go to Dashboard
</x-mail::button>

<p style="margin-bottom: 10px;">
If you have any questions or need assistance, our support team is always ready to help.
</p>

<p style="margin-bottom: 10px;">
We're excited to have you on board and look forward to supporting your success.
</p>

</x-mail::message>