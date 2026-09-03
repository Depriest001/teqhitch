<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{ $subject ?? 'Your verification code' }}</title>

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

            .otp-code {
                font-size: 26px !important;
                letter-spacing: .25em !important;
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

                <p style="margin:0 0 4px 0; font-size:18px; font-weight:bold; color:#1A1A1A;">
                    {{ $heading ?? 'Verify your identity' }}
                </p>

                <p style="margin:0 0 20px 0; color:#4A4A4A;">
                    {{ $intro ?? 'Use the code below to complete your verification. This code is valid for a limited time.' }}
                </p>

                <!-- OTP Code -->
                <table width="100%" cellpadding="0" cellspacing="0" style="margin: 20px 0;">
                    <tr>
                        <td align="center">
                            <div style="background:#F4F7FB; border:1px dashed #C7D2E3; border-radius:8px; padding:20px; display:inline-block; min-width:220px;">
                                <span class="otp-code" style="font-family: 'Courier New', Courier, monospace; font-size:32px; font-weight:bold; letter-spacing:.35em; color:#1E5FD8;">
                                    {{ $code }}
                                </span>
                            </div>
                        </td>
                    </tr>
                </table>

                <p style="margin:0 0 20px 0; font-size:13px; color:#777; text-align:center;">
                    This code expires in {{ $expiresInMinutes }} minute{{ $expiresInMinutes == 1 ? '' : 's' }}.
                </p>

                <p style="margin:0; font-size:13px; color:#777;">
                    If you didn't request this code, you can safely ignore this email — no changes will be made to your account.
                </p>

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
                    This is an automated security email from {{ config('app.name') }}.
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