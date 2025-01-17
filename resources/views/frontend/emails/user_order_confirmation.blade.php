<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation</title>
</head>
<body>
    <h1>Thank You for Your Order, {{ $user->first_name }}!</h1>
    <p>Your order number is <strong>{{ $orderNumber }}</strong>.</p>
    <p>We will notify you once your order is shipped. Thank you for shopping with us!</p>
</body>
</html>
