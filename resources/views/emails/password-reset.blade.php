<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password Notification</title>
</head>

<body style="font-family: Helvetica, Arial, sans-serif; font-size: 14px; color: #222; margin: 0; padding: 20px; background-color: #fff; line-height: 1.6;">
    <div class="container" style="max-width: 800px; margin: 0 auto; padding: 15px;">

        <div style="text-align: center; margin-bottom: 30px;">
            <img src="{{ asset('admin/assets/img/branding/cropped-celergen-logo.png') }}" alt="Celergen Swiss Logo"
                style="display: block; margin: 0 auto; max-width: 200px; width: 80%;">
        </div>

        <div class="header" style="text-align: left; font-size: 14px; line-height: 1.5;color: #666;">
            <span>Dear Customer,</span><br>
            <span style="display: inline-block; margin-top: 10px;">
                We received a password reset request for your account.

                Please click the button below to reset your password:
            </span>
        </div>

        <div style="text-align: center; margin: 30px 0;">
            <a href="{{ $url }}"
               style="display: inline-block; background-color: #2c3e50; color: white; padding: 12px 24px; text-decoration: none; border-radius: 5px; font-weight: bold; font-size: 16px;">
                Reset Password
            </a>
        </div>

        <div style="font-size: 14px; margin-bottom: 10px; color: #666;">
            This password reset link will expire in {{ config('auth.passwords.'.config('auth.defaults.passwords').'.expire') }} minutes.
        </div>

        <div style="font-size: 14px; margin-bottom: 10px; color: #666;">
            If you did not request a password reset, no further action is required.
        </div>

        <div class="footer" style="margin-top: 10px; text-align: left; font-size: 0.9em; color: #666;">
            <p>If you have any queries, please feel free to contact us at
                <a href="mailto:marketing@celergenswiss.com"
                    style="color: #666; word-break: break-all;">marketing@celergenswiss.com</a>
            </p>
        </div>

        <div class="signature" style="margin-top: 30px; font-weight: bold;">
            Yours sincerely,<br>
            Celergen Team
        </div>

        <div style="margin-top: 30px; text-align: center; width: 100%;">
            <img src="{{ asset('frontend/images/email_banner.png') }}" alt="Celergen Banner"
                style="max-width: 100%; width: 100%; height: auto; display: block;">
        </div>
    </div>
</body>
</html>
