<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $subject }}</title>
</head>
<body style="margin:0;padding:0;background:#f1f2f8;font-family:Arial,Helvetica,sans-serif;">

{{-- Inbox preview text --}}
<div style="display:none;max-height:0;overflow:hidden;opacity:0;">
    Your verification code is {{ $code }}. It expires in {{ $minutes }} minutes.
</div>

<table width="100%" cellpadding="0" cellspacing="0" role="presentation" style="background:#f1f2f8;padding:30px 12px;">
    <tr>
        <td align="center">

            <table width="100%" cellpadding="0" cellspacing="0" role="presentation" style="max-width:560px;background:#ffffff;border-radius:12px;overflow:hidden;border-top:5px solid #fd6801;">

                {{-- Text brand avoids a broken remote logo in some inboxes. --}}
                <tr>
                    <td align="center" style="padding:28px 20px 10px;">
                        <a href="{{ config('app.url') }}" style="text-decoration:none;">
                            <span style="font-size:24px;font-weight:700;color:#2a3582;">{{ $siteName }}</span>
                        </a>
                    </td>
                </tr>

                {{-- Body --}}
                <tr>
                    <td style="padding:10px 32px 8px;color:#2a3582;font-size:15px;line-height:1.7;">
                        <h2 style="margin:10px 0 12px;font-size:20px;color:#2a3582;">Hello!</h2>
                        <p style="margin:0 0 6px;">Use this 6-digit code to verify your account:</p>
                    </td>
                </tr>

                {{-- OTP code : ek click e puro select hoy --}}
                <tr>
                    <td align="center" style="padding:6px 32px 4px;">
                        <div style="display:inline-block;background:#fff4ec;border:2px dashed #fd6801;border-radius:10px;padding:14px 30px;font-size:34px;font-weight:700;letter-spacing:10px;color:#2a3582;-webkit-user-select:all;user-select:all;cursor:pointer;">{{ $code }}</div>
                    </td>
                </tr>
                <tr>
                    <td align="center" style="padding:6px 32px 0;color:#6b7280;font-size:12px;">
                        In Gmail, tap Copy code if shown. Then return to Buydor and tap Paste code.
                    </td>
                </tr>

                <tr>
                    <td style="padding:16px 32px 28px;color:#6b7280;font-size:14px;line-height:1.7;">
                        <p style="margin:0 0 10px;">This code will expire in {{ $minutes }} minutes.</p>
                        <p style="margin:0 0 10px;">If you did not request this code, you can safely ignore this email.</p>
                        <p style="margin:16px 0 0;color:#2a3582;">Regards,<br><strong>{{ $siteName }}</strong></p>
                    </td>
                </tr>

            </table>

            <p style="margin:16px 0 0;font-size:12px;color:#9ca3af;">&copy; {{ date('Y') }} {{ $siteName }}. All rights reserved.</p>

        </td>
    </tr>
</table>

</body>
</html>
