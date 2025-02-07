<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Delivery Order</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f8f8;
            padding: 20px;
        }
        .container {
            max-width: 500px;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        label {
            display: block;
            margin-top: 10px;
        }
        select, input {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        button {
            margin-top: 15px;
            background-color: #28a745;
            color: white;
            padding: 10px;
            border: none;
            width: 100%;
            cursor: pointer;
            border-radius: 4px;
        }
        .alert {
            padding: 10px;
            margin-top: 10px;
            background-color: #d4edda;
            color: #155724;
            border-radius: 5px;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Update Delivery Order</h2>

    @if (session('message'))
        <div class="alert">{{ session('message') }}</div>
    @endif

    <form action="{{ route('warehouse.update.delivery', $deliveryOrder->id) }}" method="POST">
        @csrf
        @method('POST')

        <label>Status:</label>
        <select name="status">
            <option value="Pending" {{ $deliveryOrder->status == 'Pending' ? 'selected' : '' }}>Pending</option>
            <option value="Shipped" {{ $deliveryOrder->status == 'Shipped' ? 'selected' : '' }}>Shipped</option>
            <option value="Delivered" {{ $deliveryOrder->status == 'Delivered' ? 'selected' : '' }}>Delivered</option>
            <option value="Cancelled" {{ $deliveryOrder->status == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
        </select>

        <label>Tracking Number:</label>
        <input type="text" name="tracking_number" value="{{ $deliveryOrder->tracking_number }}" placeholder="Enter tracking number">

        <button type="submit">Update Order</button>
    </form>
</div>

</body>
</html>
