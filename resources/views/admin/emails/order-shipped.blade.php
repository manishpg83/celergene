<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Order Update #{{ $deliveryOrder->id }}</title>
</head>

<body
    style="font-family: Arial, sans-serif; font-size: 14px; color: #333; margin: 0; padding: 40px; background-color: #fff; line-height: 1.6;">
    <div class="container" style="max-width: 800px; margin: 0 auto; padding: 20px;">
        <div class="logo" style="text-align: center; margin-bottom: 30px;">
            <img src="https://cdn2-bread6hkcwg3dyar.z01.azurefd.net/celergenswiss/images/common/cropped-celergen-logo.png"
                alt="Celergen Logo" style="max-height: 60px; width: auto;">
        </div>

        <div class="greeting" style="margin-bottom: 30px; line-height: 1.6;">
            <p>Dear Mr / Ms {{ $deliveryOrder->orderMaster->customer->first_name }},</p>

            @if ($deliveryOrder->status == 'Shipped')
                <p>Your product has been shipped, and the delivery tracking number is enclosed.</p>
            @elseif ($deliveryOrder->status == 'Delivered')
                <p>Your order has been successfully delivered. We hope you enjoy your purchase!</p>
            @elseif ($deliveryOrder->status == 'Cancelled')
                <p>We regret to inform you that your order has been cancelled. Please contact support if you have any
                    questions.</p>
            @endif
        </div>

        <div>
            <p><strong>Order Date :</strong> {{ $deliveryOrder->created_at->format('F d, Y') }}</p>
            <p><strong>Order No :</strong> #{{ $deliveryOrder->id }}</p>
            <p><strong>Invoice No :</strong> #{{ $deliveryOrder->orderInvoice->invoice_number ?? '-' }}</p>
            <p><strong>Tracking Number :</strong> {{ $deliveryOrder->tracking_number }}</p>
            <p><strong>Tracking Url :</strong> {{ $deliveryOrder->tracking_url }}</p>
        </div>

        <table style="width: 100%; border-collapse: collapse; margin-bottom: 30px;">
            <thead>
                <tr>
                    <th
                        style="padding: 12px; text-align: left; border-bottom: 1px solid #eee; background-color: #f8f9fa; font-weight: bold; color: #333;">
                        Item Name</th>
                    <th
                        style="padding: 12px; text-align: right; border-bottom: 1px solid #eee; background-color: #f8f9fa; font-weight: bold; color: #333;">
                        Total Quantity</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($deliveryOrder->details as $detail)
                    <tr>
                        <td style="padding: 12px; text-align: left; border-bottom: 1px solid #eee;">
                            {{ $detail->product->product_name }}</td>
                        <td style="padding: 12px; text-align: right; border-bottom: 1px solid #eee;">
                            {{ $detail->quantity }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="footer"
            style="text-align: center; margin-top: 40px; padding-top: 20px; border-top: 1px solid #eee; color: #666;">
            <p>Thank you for your business!</p>
            <p>If you have any queries, please feel free to contact us at <a href="mailto:marketing@celergenswiss.com"
                    style="color: #007bff; text-decoration: none;">marketing@celergenswiss.com</a></p>
        </div>
    </div>
</body>

</html>
