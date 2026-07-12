<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Undangan Interview</title>
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
                            <h2 style="color: #111827; margin: 0 0 8px 0; font-size: 20px;">Halo, {{ $invitation->jobApplication->user->name }}</h2>
                            <p style="color: #6b7280; margin: 0 0 24px 0; font-size: 15px; line-height: 1.6;">
                                Selamat! Kamu mendapatkan undangan interview dari <strong>{{ $invitation->jobApplication->job->company->name }}</strong>.
                            </p>

                            <table width="100%" cellpadding="0" cellspacing="0" style="background: #f9fafb; border-radius: 8px; padding: 20px; margin-bottom: 24px;">
                                <tr>
                                    <td style="padding-bottom: 12px;">
                                        <p style="color: #6b7280; margin: 0; font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px;">Posisi</p>
                                        <p style="color: #111827; margin: 4px 0 0 0; font-size: 16px; font-weight: 600;">{{ $invitation->jobApplication->job->title }}</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding-bottom: 12px;">
                                        <p style="color: #6b7280; margin: 0; font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px;">Pesan dari Rekruter</p>
                                        <p style="color: #111827; margin: 4px 0 0 0; font-size: 15px; line-height: 1.5;">{{ $invitation->message }}</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding-bottom: 12px;">
                                        <p style="color: #6b7280; margin: 0; font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px;">Kontak Rekruter</p>
                                        <p style="color: #111827; margin: 4px 0 0 0; font-size: 16px;">{{ $invitation->contact_info }}</p>
                                    </td>
                                </tr>
                                @if($invitation->meeting_link)
                                <tr>
                                    <td style="padding-bottom: 12px;">
                                        <p style="color: #6b7280; margin: 0; font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px;">Link Meeting</p>
                                        <p style="margin: 4px 0 0 0; font-size: 15px;">
                                            <a href="{{ $invitation->meeting_link }}" style="color: #2563eb;">{{ $invitation->meeting_link }}</a>
                                        </p>
                                    </td>
                                </tr>
                                @endif
                                @if($invitation->location)
                                <tr>
                                    <td>
                                        <p style="color: #6b7280; margin: 0; font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px;">Lokasi</p>
                                        <p style="color: #111827; margin: 4px 0 0 0; font-size: 15px;">{{ $invitation->location }}</p>
                                    </td>
                                </tr>
                                @endif
                            </table>

                            <p style="color: #6b7280; margin: 0 0 24px 0; font-size: 14px; line-height: 1.6;">
                                Silakan login ke dashboard TechHire untuk mengonfirmasi atau menolak undangan ini.
                            </p>

                            <table cellpadding="0" cellspacing="0">
                                <tr>
                                    <td style="background: #2563eb; border-radius: 8px; text-align: center;">
                                        <a href="{{ route('applicant.dashboard') }}"
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
