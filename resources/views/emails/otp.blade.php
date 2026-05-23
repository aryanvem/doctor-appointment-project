<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your OTP - DoctorsApp</title>
</head>
<body style="margin:0;padding:0;background:#f7f9fc;font-family:'Segoe UI',Arial,sans-serif;">
<table width="100%" cellpadding="0" cellspacing="0" style="padding:40px 16px;">
    <tr>
        <td align="center">
            <table width="100%" cellpadding="0" cellspacing="0" style="max-width:520px;background:#fff;border-radius:16px;overflow:hidden;border:1px solid #e8edf2;box-shadow:0 4px 20px rgba(0,0,0,.07);">
                <!-- Header -->
                <tr>
                    <td style="background:linear-gradient(135deg,#00b0b9,#008a92);padding:32px;text-align:center;">
                        <p style="color:#fff;font-size:1.8rem;font-weight:800;margin:0;letter-spacing:-0.5px;">🩺 DoctorsApp</p>
                        <p style="color:rgba(255,255,255,.85);margin:6px 0 0;font-size:.95rem;">Online Appointment System</p>
                    </td>
                </tr>
                <!-- Body -->
                <tr>
                    <td style="padding:36px 40px;">
                        <p style="font-size:1rem;margin:0 0 8px;">Hi <strong>{{ $userName }}</strong>,</p>
                        <p style="font-size:.95rem;color:#6b7c93;margin:0 0 28px;line-height:1.6;">
                            Use the OTP below to verify your identity and complete your login.
                            This code is valid for <strong>10 minutes</strong>.
                        </p>

                        <!-- OTP Box -->
                        <div style="text-align:center;margin:0 0 28px;">
                            <div style="display:inline-block;background:#e6f9fb;border:2px dashed #00b0b9;border-radius:12px;padding:20px 40px;">
                                <p style="font-size:2.4rem;font-weight:800;letter-spacing:10px;color:#008a92;margin:0;font-family:monospace;">{{ $otp }}</p>
                                <p style="font-size:.78rem;color:#6b7c93;margin:6px 0 0;">Your One-Time Password</p>
                            </div>
                        </div>

                        <p style="font-size:.85rem;color:#e74c3c;background:#fdf0f0;border-radius:8px;padding:12px 16px;border:1px solid #f5c6cb;margin:0 0 20px;">
                            ⚠️ Do not share this OTP with anyone. DoctorsApp staff will never ask for your OTP.
                        </p>
                        <p style="font-size:.85rem;color:#6b7c93;margin:0;">
                            If you didn't request this, you can safely ignore this email.
                        </p>
                    </td>
                </tr>
                <!-- Footer -->
                <tr>
                    <td style="background:#f7f9fc;padding:20px 40px;border-top:1px solid #e8edf2;text-align:center;">
                        <p style="font-size:.78rem;color:#aaa;margin:0;">
                            &copy; {{ date('Y') }} DoctorsApp &bull; Online Appointment System
                        </p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>
</html>
