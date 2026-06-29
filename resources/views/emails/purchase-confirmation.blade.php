<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Order Confirmed - INSPIN</title>
</head>
<body style="margin:0;padding:0;background-color:#0a0a0a;font-family:'Helvetica Neue',Arial,sans-serif;">

<table width="100%" cellpadding="0" cellspacing="0" style="background-color:#0a0a0a;padding:40px 20px;">
    <tr>
        <td align="center">
            <table width="100%" cellpadding="0" cellspacing="0" style="max-width:560px;">

                <tr>
                    <td align="center" style="padding-bottom:28px;">
                        <img src="https://inspin.com/images/inspin-logo.png" alt="INSPIN" height="40" style="height:40px;width:auto;">
                    </td>
                </tr>

                <tr>
                    <td style="background:#161616;border:1px solid rgba(255,255,255,.08);border-radius:16px;overflow:hidden;">

                        <table width="100%" cellpadding="0" cellspacing="0">
                            <tr><td style="height:4px;background:linear-gradient(90deg,#FDB515,#f59e0b);"></td></tr>
                        </table>

                        <table width="100%" cellpadding="0" cellspacing="0">
                            <tr>
                                <td style="padding:36px 40px;">

                                    <table width="100%" cellpadding="0" cellspacing="0">
                                        <tr>
                                            <td align="center" style="padding-bottom:24px;">
                                                <div style="width:64px;height:64px;background:rgba(0,209,91,.1);border:1px solid rgba(0,209,91,.3);border-radius:16px;display:inline-block;line-height:64px;text-align:center;font-size:28px;">✓</div>
                                            </td>
                                        </tr>
                                    </table>

                                    <h1 style="margin:0 0 10px;font-size:24px;font-weight:700;color:#ffffff;text-align:center;">
                                        Order Confirmed
                                    </h1>

                                    <p style="margin:0 0 28px;font-size:15px;color:rgba(255,255,255,.5);text-align:center;line-height:1.7;">
                                        Hi <strong style="color:#fff;">{{ $userPackage->user->name }}</strong>, your payment was successful and your package is now active.
                                    </p>

                                    <table width="100%" cellpadding="0" cellspacing="0" style="background:#1e1e1e;border-radius:12px;margin-bottom:24px;">
                                        <tr>
                                            <td style="padding:18px 22px;">
                                                <table width="100%" cellpadding="0" cellspacing="0">
                                                    <tr>
                                                        <td style="padding:6px 0;font-size:13px;color:rgba(255,255,255,.45);">Package</td>
                                                        <td align="right" style="padding:6px 0;font-size:13.5px;color:#fff;font-weight:600;">{{ $userPackage->package->name }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td style="padding:6px 0;font-size:13px;color:rgba(255,255,255,.45);">Amount Charged</td>
                                                        <td align="right" style="padding:6px 0;font-size:13.5px;color:#FDB515;font-weight:700;">${{ number_format($userPackage->amount_paid, 2) }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td style="padding:6px 0;font-size:13px;color:rgba(255,255,255,.45);">Access Starts</td>
                                                        <td align="right" style="padding:6px 0;font-size:13.5px;color:#fff;font-weight:600;">{{ $userPackage->starts_at->format('M j, Y') }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td style="padding:6px 0;font-size:13px;color:rgba(255,255,255,.45);">Access Expires</td>
                                                        <td align="right" style="padding:6px 0;font-size:13.5px;color:#fff;font-weight:600;">{{ $userPackage->expires_at->format('M j, Y') }}</td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>

                                    <table width="100%" cellpadding="0" cellspacing="0">
                                        <tr>
                                            <td align="center" style="padding-bottom:8px;">
                                                <a href="https://inspin.com/subscriber/dashboard"
                                                   style="display:inline-block;padding:15px 44px;background:#FDB515;color:#000000;font-size:15px;font-weight:700;text-decoration:none;border-radius:50px;">
                                                    Go to Dashboard
                                                </a>
                                            </td>
                                        </tr>
                                    </table>

                                    <table width="100%" cellpadding="0" cellspacing="0">
                                        <tr><td style="height:1px;background:rgba(255,255,255,.07);"></td></tr>
                                    </table>

                                    <p style="margin:20px 0 0;font-size:13px;color:rgba(255,255,255,.35);text-align:center;line-height:1.6;">
                                        This is a one-time charge — no recurring billing, ever. Questions? Email <a href="mailto:help@inspin.com" style="color:#FDB515;">help@inspin.com</a> or call <a href="tel:+16108704799" style="color:#FDB515;">610-870-4799</a>.
                                    </p>

                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>

                <tr>
                    <td align="center" style="padding:24px 0 0;">
                        <p style="margin:0;font-size:12px;color:rgba(255,255,255,.2);">
                            © {{ date('Y') }} INSPIN. All rights reserved.<br>
                            <a href="https://inspin.com" style="color:rgba(255,255,255,.3);text-decoration:none;">inspin.com</a>
                        </p>
                    </td>
                </tr>

            </table>
        </td>
    </tr>
</table>

</body>
</html>
