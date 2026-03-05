<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTP Verification</title>
</head>

<body style="margin:0; padding:0; background-color:#f4f6f9; font-family:'Segoe UI', sans-serif;">

    <table width="100%" cellpadding="0" cellspacing="0" style="background:#f4f6f9; padding: 40px 0;">
        <tr>
            <td align="center">
                <table width="480" cellpadding="0" cellspacing="0"
                    style="background:#ffffff; border-radius:15px; box-shadow:0 10px 30px rgba(0,0,0,0.08); overflow:hidden;">

                    {{-- Header --}}
                    <tr>
                        <td
                            style="background:linear-gradient(135deg, #0f2027, #203a43, #2c5364); padding:30px; text-align:center;">
                            <h1 style="margin:0; color:#ffffff; font-size:22px; font-weight:600; letter-spacing:1px;">
                                🔐 OTP Verification
                            </h1>
                            <p style="margin:6px 0 0; color:#a8c4d4; font-size:13px;">Todo App</p>
                        </td>
                    </tr>

                    {{-- Body --}}
                    <tr>
                        <td style="padding: 36px 40px;">

                            <p style="margin:0 0 16px; color:#333; font-size:15px;">
                                হ্যালো <strong>{{ $user->name }}</strong>,
                            </p>

                            <p style="margin:0 0 24px; color:#555; font-size:14px; line-height:1.6;">
                                আপনার Todo App লগইনের জন্য One-Time Password (OTP) নিচে দেওয়া হলো।
                                এই কোডটি <strong>৫ মিনিট</strong> এর জন্য valid।
                            </p>

                            {{-- OTP Box --}}
                            <table width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td align="center" style="padding: 10px 0 28px;">
                                        <div style="
                                            display:inline-block;
                                            background:#f0f4ff;
                                            border: 2px dashed #667eea;
                                            border-radius:12px;
                                            padding: 18px 40px;
                                            font-size: 38px;
                                            font-weight: 700;
                                            letter-spacing: 14px;
                                            color: #2c5364;
                                        ">
                                            {{ $otp }}
                                        </div>
                                    </td>
                                </tr>
                            </table>

                            <p style="margin:0 0 10px; color:#888; font-size:13px; line-height:1.6;">
                                ⚠️ এই OTP কারো সাথে শেয়ার করবেন না। Anthropic বা Todo App কখনো আপনার কাছে OTP চাইবে না।
                            </p>

                            <p style="margin:0; color:#888; font-size:13px;">
                                যদি আপনি login করার চেষ্টা না করে থাকেন, এই email টি ignore করুন।
                            </p>

                        </td>
                    </tr>

                    {{-- Footer --}}
                    <tr>
                        <td
                            style="background:#f9fafb; border-top:1px solid #eee; padding:20px 40px; text-align:center;">
                            <p style="margin:0; color:#aaa; font-size:12px;">
                                &copy; {{ date('Y') }} Todo App. All rights reserved.
                            </p>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>

</body>

</html>