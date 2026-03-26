<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{ $newsletter->subject ?? config('app.name') }}</title>

    <style>
        /* Mobile styles */
        @media only screen and (max-width: 600px) {
            .container {
                width: 100% !important;
            }

            .padding {
                padding: 20px !important;
            }

            .header h2 {
                font-size: 20px !important;
            }

            .content {
                font-size: 14px !important;
            }
        }
    </style>
</head>

<body style="margin:0; padding:0; background-color:#F4F7FB; font-family: Arial, Helvetica, sans-serif;">

<table width="100%" cellpadding="0" cellspacing="0" style="background-color:#F4F7FB; padding: 20px 10px;">
<tr>
<td align="center">

    <!-- Container -->
    <table class="container" width="600" cellpadding="0" cellspacing="0"
        style="max-width:600px; width:100%; background:#ffffff; border-radius:10px; overflow:hidden; box-shadow:0 4px 10px rgba(0,0,0,0.05);">

        <!-- Header -->
        <tr>
            <td class="header" style="background: linear-gradient(135deg, #1E5FD8, #2EC4B6, #6BD66B); padding: 25px; text-align: center;">
                <img src="{{ asset('logo.png') }}" alt="Logo" width="60" style="display:block; margin:0 auto 10px auto; max-width:100%;">
                <h2 style="color:#ffffff; margin:0; font-size:24px;">
                    {{ config('app.name') }}
                </h2>
            </td>
        </tr>

        <!-- Body -->
        <tr>
            <td class="padding content" style="padding: 30px; color:#1A1A1A; font-size:15px; line-height:1.6;">

                <!-- Dynamic Content -->
                <div>
                    {!! $content !!}
                </div>

                <!-- CTA -->
                @if(!empty($newsletter->url))
                <table width="100%" cellpadding="0" cellspacing="0" style="margin: 30px 0;">
                    <tr>
                        <td align="center">
                            <a href="{{ $newsletter->url }}" class="btn"
                               style="background: linear-gradient(135deg, #1E5FD8, #2EC4B6); color:#ffffff; padding:10px 25px; text-decoration:none; border-radius:6px; display:inline-block; font-weight:bold;">
                                {{ $newsletter->url_text ?? 'Take Action' }}
                            </a>
                        </td>
                    </tr>
                </table>
                @endif

                <hr style="border:none; border-top:1px solid #eee; margin:30px 0;">

                <p style="font-size:14px;">
                    Best Regards,<br>
                    <strong>{{ config('app.name') }} Team</strong><br>
                    Online Courses | Seminars | Project Writing<br>
                    Email: support@teqhitch.com<br>
                    Website: {{ config('app.url') }}
                </p>

            </td>
        </tr>

        <!-- Footer -->
        <tr>
            <td style="background:#f9fafc; padding:20px; text-align:center; font-size:12px; color:#777;">
                <p style="margin:0;">
                    You are receiving this email because you subscribed to {{ config('app.name') }}.
                </p>

                <p style="margin:10px 0;">
                    <a href="{{ $unsubscribeUrl }}" style="color:#1E5FD8; text-decoration:none;">Unsubscribe</a>
                </p>

                <p style="margin:0;">
                    &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
                </p>
            </td>
        </tr>

    </table>

</td>
</tr>
</table>

</body>
</html>