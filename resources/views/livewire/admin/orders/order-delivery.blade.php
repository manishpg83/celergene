<div class="card mt-4">
    <div class="card-body">
        @if (session()->has('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"
                    aria-label="Close"></button>
            </div>
        @endif

        @if (session()->has('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"
                    aria-label="Close"></button>
            </div>
        @endif

        <div class="col-md-12 mt-3">
            <div class="alert alert-info">
                <div class="d-flex align-items-center">
                    <i class="bx bx-info-circle me-2"></i>
                    <div>
                        <strong>Order Type: {{ $order->workflow_type->label() }}</strong>
                        @if ($order->workflow_type === \App\Enums\OrderWorkflowType::MULTI_DELIVERY)
                            <br>Total Order Quantity: {{ $totalOrderQuantity }}
                        @elseif($order->workflow_type === \App\Enums\OrderWorkflowType::CONSIGNMENT)
                            <br>{{ $isInitialConsignment ? 'Initial Consignment Delivery' : 'Consignment Sale Delivery' }}
                            @if (!$isInitialConsignment)
                                <br>Remaining Quantity: {{ $remainingQuantity }}
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="table-responsive mb-4 bg-white rounded">
            <table class="table table-bordered align-middle">
                <thead class="bg-light border-bottom border-2">
                    <tr>
                        <th class="text-center">Product</th>
                        <th class="text-center">
                            @if ($order->workflow_type === \App\Enums\OrderWorkflowType::MULTI_DELIVERY)
                                Remaining Qty / Total Qty
                            @else
                                Quantity
                            @endif
                        </th>
                        <th class="text-center">Samlple Qty</th>
                        {{-- <th class="text-center">Price</th> --}}
                        {{-- <th class="text-center">Discount</th> --}}
                        {{-- <th class="text-center">Total Price</th> --}}
                        <th class="text-center">Warehouse Selection</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($order->orderDetails as $detail)
                        <tr>
                            <td class="text-center">{{ $detail->product->product_name }}</td>
                            <td class="text-center">
                                @if ($order->workflow_type === \App\Enums\OrderWorkflowType::MULTI_DELIVERY)
                                    {{ $this->calculateRemainingQuantity($detail) }} /
                                    {{ $detail->quantity }}
                                @else
                                    {{ $detail->quantity }}
                                @endif
                            </td>
                            <td class="text-center">{{ $detail->sample_quantity }}</td>
                            {{-- <td class="text-center">${{ number_format($detail->unit_price, 2) }}</td> --}}
                            {{--  <td class="text-danger text-center">
                                @if ($detail->discount > 0)
                                    -${{ number_format($detail->discount, 2) }}
                                @else
                                    $0.00
                                @endif
                            </td> --}}
                            {{-- <td class="text-center">
                                ${{ number_format(($detail->quantity - $detail->sample_quantity) * $detail->unit_price - $detail->discount, 2) }}
                            </td> --}}
                            <td class="text-center">
                                @foreach ($detail->product->inventories as $inventory)
                                    <div class="mb-3 p-2 border rounded">
                                        <div class="mb-2">
                                            <strong>Batch: {{ $inventory->batch_number }}</strong><br>
                                            Available: {{ (float) $inventory->remaining }} |
                                            Warehouse: {{ $inventory->warehouse->warehouse_name }}
                                        </div>
                                        <input type="number"
                                            wire:model.live="inventoryQuantities.{{ $inventory->id }}"
                                            class="form-control" min="0"
                                            max="{{ (float) $inventory->remaining }}"
                                            placeholder="Enter quantity">
                                        @error("inventoryQuantities.{$inventory->id}")
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                @endforeach

                                <div class="mt-2">
                                    <strong>Total Selected: </strong>
                                    {{ collect($inventoryQuantities)->filter(function ($qty, $invId) use ($detail) {
                                            return $detail->product->inventories->contains('id', $invId);
                                        })->map(fn($value) => (float) $value)->sum() }}
                                    /
                                    @if ($order->workflow_type === \App\Enums\OrderWorkflowType::MULTI_DELIVERY)
                                        {{ $this->calculateRemainingQuantity($detail) }}
                                    @elseif($order->workflow_type === \App\Enums\OrderWorkflowType::CONSIGNMENT)
                                        {{ $this->calculateRemainingQuantity($detail) }}
                                    @else
                                        {{ (float) $detail->quantity }}
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="row mb-4">
            <div class="col-md-6 ms-auto">
                @if ($order->workflow_type !== \App\Enums\OrderWorkflowType::MULTI_DELIVERY || $remainingQuantity === 0)
                    <div class="col-md-6">
                        <label for="deliveryStatus" class="form-label">Update Delivery Status:</label>
                        <select wire:model="deliveryStatus" id="deliveryStatus" class="form-select">
                            <option value="Pending">Pending</option>
                            <option value="Shipped">Shipped</option>
                            <option value="Delivered">Delivered</option>
                            <option value="Cancelled">Cancelled</option>
                        </select>
                    </div>
                @endif
                <div class="col-md-12">
                    <label for="remarks">Remarks</label>
                    <textarea id="remarks" wire:model.defer="remarks" class="form-control"></textarea>
                </div>
            </div>      
            <div class="col-md-6 ms-auto">
                <div class="card rounded-3 shadow-sm border">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="text-muted">Subtotal:</span>
                            <span>${{ number_format($order->subtotal, 2) }}</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="text-muted">Total Discount:</span>
                            <span class="text-danger">-${{ number_format($order->discount, 2) }}</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="text-muted">Freight:</span>
                            <span class="text-success">+${{ number_format($order->freight, 2) }}</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="text-muted">Tax:</span>
                            <span class="text-success">+${{ number_format($order->tax, 2) }}</span>
                        </div>
                        <hr class="my-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="h6 mb-0">Total:</span>
                            <span class="h5 mb-0 fw-semibold">${{ number_format($order->total, 2) }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-end">
            <button wire:click="updateDelivery" class="btn btn-success" wire:loading.attr="disabled">
                <span wire:loading.remove wire:target="updateDelivery">
                    @if ($order->workflow_type === \App\Enums\OrderWorkflowType::MULTI_DELIVERY)
                        Update Delivery Order
                    @elseif($order->workflow_type === \App\Enums\OrderWorkflowType::CONSIGNMENT)
                        {{ $isInitialConsignment ? 'Update Delivery Order' : 'Update Delivery Order' }}
                    @else
                        Update Delivery Order
                    @endif
                </span>
                <span wire:loading wire:target="updateDelivery">Updating...</span>
            </button>
        </div>
    </div>
</div>