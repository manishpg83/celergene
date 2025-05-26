<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome to Celergen</title>
</head>
<body style="font-family: Helvetica, Arial, sans-serif; font-size: 14px; color: #222; margin: 0; padding: 20px; background-color: #fff; line-height: 1.6;">
    <div class="container" style="max-width: 800px; margin: 0 auto; padding: 15px;">
        <div style="text-align: center; margin-bottom: 30px;">
            <img src="{{ asset('admin/assets/img/branding/cropped-celergen-logo.png') }}" alt="Celergen Swiss Logo"
                style="display: block; margin: 0 auto; max-width: 200px; width: 80%;">
        </div>

        <div style="font-size: 14px; color: #444;">
            <p>Welcome to the World of Celergen, <strong>{{ $user->first_name }}</strong>,</p>

            <p>Thank you for registering with us. Your account has been successfully activated.</p>

            <p>
                You can now log in with your email address and your password. With this login, you will enjoy a seamless online experience—effortlessly purchasing Caviarlieri products without the need to re-enter your billing or shipping information.
            </p>

            <p>
                You will also have exclusive access to your purchase history and the ability to update your personal profile at your convenience.
            </p>

            <p>
                We are delighted to have you with us and look forward to accompanying you on your journey to elevated vitality, youth and timeless beauty.
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
