<div class="container-fluid py-4">
    <div class="row">
        <!-- Product Details Card (Left side) -->
        <div class="col-md-6 mb-4">
            <div class="bg-white p-6 shadow-lg rounded-lg">
                <h3 class="text-xl font-semibold mb-4">Product Details</h3>
                <div class="space-y-4">
                    <div class="flex justify-between">
                        <span class="font-medium">Product Code:</span>
                        <span>{{ $inventoryData->first()->product->product_code ?? 'N/A' }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="font-medium">Product Name:</span>
                        <span>{{ $inventoryData->first()->product->product_name ?? 'N/A' }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="font-medium">Unit Price:</span>
                        <span>{{ $inventoryData->first()->product->unit_price ?? 'N/A' }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stock Details Card (Right side) -->
        <div class="col-md-6 mb-4">
            <div class="bg-white p-6 shadow-lg rounded-lg">
                <h3 class="text-xl font-semibold mb-4">Stock Details</h3>
                <div class="space-y-4">
                    <div class="flex justify-between">
                        <span class="font-medium">Total Stock:</span>
                        <span>{{ $totalStock }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="font-medium">Total Consumed:</span>
                        <span>{{ $totalConsumed }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="font-medium">Warehouse Count:</span>
                        <span>{{ $warehouseCount }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Warehouse Quantities Table (Full width) -->
        <div class="col-md-12">
            <div class="bg-white p-6 shadow-lg rounded-lg">
                <h3 class="text-xl font-semibold mb-4">Warehouse Quantities</h3>
                <table class="table table-striped table-bordered w-full text-center">
                    <thead>
                        <tr>
                            <th>Warehouse</th>
                            <th>Batch Number</th>
                            <th>Expiry</th>
                            <th>Quantity</th>
                            <th>Consumed</th>
                            <th>Remaining</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($inventoryData as $inventory)
                            <tr>
                                <td>{{ $inventory->warehouse->warehouse_name }}</td>
                                <td>{{ $inventory->batch_number }}</td>
                                <td>{{ \Carbon\Carbon::parse($inventory->expiry)->format('M d, Y') }}</td>
                                <td>{{ $inventory->quantity }}</td>
                                <td>{{ $inventory->consumed }}</td>
                                <td>{{ $inventory->remaining }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
