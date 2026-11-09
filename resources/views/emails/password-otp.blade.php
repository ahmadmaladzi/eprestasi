<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kode OTP Reset Password E-Prestasi</title>
</head>
<body style="margin:0;padding:0;background:#F5F7FB;font-family:Arial,Helvetica,sans-serif;color:#0B1E38;">
    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="background:#F5F7FB;padding:32px 16px;">
        <tr>
            <td align="center">
                <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="max-width:560px;background:#ffffff;border:1px solid #E8EDF5;border-radius:16px;overflow:hidden;">
                    <tr>
                        <td style="background:#2F6FED;padding:22px 28px;">
                            <div style="font-size:20px;font-weight:bold;color:#ffffff;letter-spacing:-0.3px;">E-Prestasi</div>
                            <div style="font-size:11px;color:#DCE8FF;margin-top:3px;">Sistem Informasi Prestasi Siswa</div>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:32px 28px;">
                            <p style="margin:0 0 8px;font-size:15px;color:#0B1E38;">Halo, <strong>{{ $user->nama }}</strong></p>
                            <p style="margin:0 0 24px;font-size:13px;line-height:1.7;color:#64748B;">
                                Kami menerima permintaan untuk mereset password akun E-Prestasi kamu.
                                Gunakan kode OTP di bawah ini untuk melanjutkan.
                            </p>

                            <div style="background:#EEF4FF;border:1px solid #D8E5FF;border-radius:12px;padding:22px;text-align:center;margin-bottom:24px;">
                                <div style="font-size:11px;font-weight:bold;letter-spacing:0.16em;text-transform:uppercase;color:#2F6FED;margin-bottom:10px;">Kode OTP</div>
                                <div style="font-size:34px;line-height:1;font-weight:bold;letter-spacing:0.3em;color:#0B1E38;">{{ $otp }}</div>
                                <div style="font-size:11px;color:#64748B;margin-top:12px;">Berlaku selama {{ $expiresInMinutes }} menit</div>
                            </div>

                            <p style="margin:0 0 8px;font-size:12px;line-height:1.7;color:#64748B;">
                                Jangan bagikan kode ini kepada siapa pun, termasuk pihak yang mengaku sebagai admin sekolah.
                            </p>
                            <p style="margin:0;font-size:12px;line-height:1.7;color:#64748B;">
                                Jika kamu tidak meminta reset password, abaikan email ini. Password kamu tidak akan berubah.
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td style="border-top:1px solid #E8EDF5;padding:18px 28px;background:#FAFCFF;">
                            <p style="margin:0;font-size:11px;line-height:1.6;color:#94A3B8;">
                                Email ini dikirim otomatis oleh sistem E-Prestasi. Mohon jangan membalas email ini.
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
