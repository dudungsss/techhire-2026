<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Respon Undangan Interview</title>
</head>
<body style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; background: #f4f4f5; margin: 0; padding: 0;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background: #f4f4f5; padding: 40px 0;">
        <tr>
            <td align="center">
                <table width="600" cellpadding="0" cellspacing="0" style="background: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                    <tr>
                        <td style="background: #2563eb; padding: 32px 40px; text-align: center;">
                            <h1 style="color: #ffffff; margin: 0; font-size: 24px;">TechHire</h1>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 40px;">
                            <h2 style="color: #111827; margin: 0 0 8px 0; font-size: 20px;">Halo, {{ $invitation->recruiter->name }}</h2>

                            @if($response === 'accepted')
                                <p style="color: #16a34a; margin: 0 0 24px 0; font-size: 15px; line-height: 1.6;">
                                    <strong>{{ $invitation->jobApplication->user->name }}</strong> telah <strong>menerima</strong> undangan interview untuk posisi <strong>{{ $invitation->jobApplication->job->title }}</strong>.
                                </p>
                            @else
                                <p style="color: #dc2626; margin: 0 0 24px 0; font-size: 15px; line-height: 1.6;">
                                    <strong>{{ $invitation->jobApplication->user->name }}</strong> telah <strong>menolak</strong> undangan interview untuk posisi <strong>{{ $invitation->jobApplication->job->title }}</strong>.
                                </p>
                            @endif

                            <p style="color: #6b7280; margin: 0 0 24px 0; font-size: 14px; line-height: 1.6;">
                                Silakan login ke dashboard TechHire untuk informasi lebih lanjut.
                            </p>

                            <table cellpadding="0" cellspacing="0">
                                <tr>
                                    <td style="background: #2563eb; border-radius: 8px; text-align: center;">
                                        <a href="{{ route('recruiter.dashboard') }}"
                                           style="display: inline-block; padding: 12px 32px; color: #ffffff; text-decoration: none; font-size: 14px; font-weight: 600;">
                                            Buka Dashboard
                                        </a>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td style="background: #f9fafb; padding: 24px 40px; text-align: center; border-top: 1px solid #e5e7eb;">
                            <p style="color: #9ca3af; margin: 0; font-size: 13px;">
                                &copy; {{ date('Y') }} TechHire. All rights reserved.
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
