<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Tracking Info</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f0f2f5;
            height: 100vh;
            display: flex;
            align-items: center;
        }
        .main-card {
            max-height: 95vh;
        }
        .info-section {
            font-size: 0.9rem;
        }
        .table {
            font-size: 0.9rem;
            margin-bottom: 0;
        }
        .table td, .table th {
            padding: 0.5rem;
        }
        .compact-form .form-label {
            margin-bottom: 0.2rem;
        }
        .compact-form .form-control, 
        .compact-form .form-select {
            padding: 0.375rem 0.5rem;
        }
        .section-title {
            font-size: 1rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }
        .btn-primary {
            background: linear-gradient(45deg, #7367f0, #7367f0);

        }
        .card-header {
            background: linear-gradient(45deg, #7367f0, #7367f0);
        }
    </style>
</head>
<body>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow main-card">
                <div class="card-header py-2">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 text-white">Update Tracking Info</h5>
                        <small class="text-white">DO ID: {{ $deliveryOrder->id }}</small>
                    </div>
                </div>
                <div class="card-body p-3">
                    <div class="row">
                        <!-- Left Column -->
                        <div class="col-md-5">
                            <div class="info-section mb-3">
                                <div class="section-title border-bottom">Shipping Details</div>
                                <div class="ps-2">
                                    <small class="d-block"><strong>Name:</strong> {{ $deliveryOrder->orderMaster->customer->first_name }} {{ $deliveryOrder->orderMaster->customer->last_name }}</small>
                                    <small class="d-block"><strong>Address:</strong> {{ $deliveryOrder->orderMaster->shipping_address ?? '' }}</small>
                                    <small class="d-block"><strong>Phone:</strong> {{ $deliveryOrder->orderMaster->customer->mobile_number ?? 'N/A' }}</small>
                                </div>
                            </div>
                            
                            <div class="table-responsive">
                                <div class="section-title border-bottom">Ordered Items</div>
                                <table class="table table-sm">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Item</th>
                                            <th width="80">Qty</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($deliveryOrder->details as $detail)
                                        <tr>
                                            <td>{{ optional($detail->product)->product_name ?? 'N/A' }}</td>
                                            <td>{{ $detail->quantity }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Right Column -->
                        <div class="col-md-7">
                            <div class="section-title border-bottom">Update Status</div>
                            <form class="compact-form" action="{{ route('warehouse.update.delivery', $deliveryOrder->id) }}" method="POST">
                                @csrf
                                @method('POST')
                                <div class="row">
                                    {{-- <div class="col-md-6 mb-2">
                                        <label class="form-label">Status:</label>
                                        <select class="form-select form-select-sm" name="status">
                                            <option value="Pending" {{ $deliveryOrder->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="Shipped" {{ $deliveryOrder->status == 'Shipped' ? 'selected' : '' }}>Shipped</option>
                                            <option value="Delivered" {{ $deliveryOrder->status == 'Delivered' ? 'selected' : '' }}>Delivered</option>
                                            <option value="Cancelled" {{ $deliveryOrder->status == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                                        </select>
                                    </div> --}}
                                    <div class="col-md-6 mb-2">
                                        <label class="form-label">Tracking Number:</label>
                                        <input type="text" class="form-control form-control-sm" name="tracking_number" value="{{ $deliveryOrder->tracking_number }}">
                                    </div>
                                    <div class="col-md-12 mb-2">
                                        <label class="form-label">Tracking URL:</label>
                                        <input type="text" class="form-control form-control-sm" name="tracking_url" value="{{ $deliveryOrder->tracking_url }}">
                                    </div>
                                </div>
                                <div class="d-grid mt-2">
                                    <button type="submit" class="btn btn-primary btn-sm">Update Order</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>