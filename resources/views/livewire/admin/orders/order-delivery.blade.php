<div class="mt-4 card">
    <div class="card-body">
        @if (session()->has('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session()->has('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="mt-3 col-md-12">
            <div class="alert alert-info">
                <div class="d-flex align-items-center">
                    <i class="bx bx-info-circle me-2"></i>
                    <div>
                        @if ($order->workflow_type === \App\Enums\OrderWorkflowType::CONSIGNMENT)
                            <strong>Order Type: Multiple Invoice Order</strong>
                            <br>
                            {{ $isInitialConsignment ? 'Initial Consignment Delivery' : 'Consignment Sale Delivery' }}
                            @if (!$isInitialConsignment)
                                <br>Remaining Quantity: {{ $remainingQuantity }}
                            @endif
                        @else
                            <strong>Order Type: {{ $order->workflow_type->label() }}</strong>
                            @if ($order->workflow_type === \App\Enums\OrderWorkflowType::MULTI_DELIVERY)
                                <br>Total Order Quantity: {{ $totalOrderQuantity }}
                            @endif
                        @endif
                    </div>

                </div>
            </div>
        </div>

        <div class="mb-4 bg-white rounded table-responsive">
            <table class="table align-middle table-bordered">
                <thead class="border-2 bg-light border-bottom">
                    <tr>
                        <th class="text-center">Product</th>
                        <th class="text-center">
                            @if ($order->workflow_type === \App\Enums\OrderWorkflowType::MULTI_DELIVERY)
                                Remaining Qty / Total Qty
                            @else
                                Quantity
                            @endif
                        </th>
                        <th class="text-center">Remaining / Total Sample Qty</th>
                        <th class="text-center">Warehouse Selection</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($order->orderDetails as $detail)
                        @if ($detail->product_id != 1)
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
                                <td class="text-center">
                                    {{ $this->calculateRemainingSampleQuantity($detail) }} /
                                    {{ $detail->sample_quantity }}
                                </td>
                                <td class="text-center">
                                    @foreach ($detail->product->inventories as $inventory)
                                        <div class="p-2 mb-3 border rounded">
                                            <div class="mb-2 text-start">
                                                <strong>Batch: {{ $inventory->batch_number }}</strong><br>
                                                Available: {{ (float) $inventory->remaining }} |
                                                Warehouse: {{ $inventory->warehouse->warehouse_name }}
                                            </div>

                                            <div class="row g-2">
                                                <div class="col-md-6">
                                                    <label class="form-label">Regular Quantity</label>
                                                    <input type="number"
                                                        wire:model.live="inventoryQuantities.{{ $inventory->id }}_{{ $detail->id }}"
                                                        class="form-control" min="0"
                                                        max="{{ (float) $inventory->remaining }}"
                                                        placeholder="Enter quantity">
                                                    @error("inventoryQuantities.{$inventory->id}_{$detail->id}")
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>

                                                <div class="col-md-6">
                                                    <label class="form-label">Sample Quantity</label>
                                                    <input type="number"
                                                        wire:model.live="inventorySampleQuantities.{{ $inventory->id }}_{{ $detail->id }}"
                                                        class="form-control" min="0"
                                                        max="{{ $this->calculateRemainingSampleQuantity($detail) }}"
                                                        placeholder="Enter sample quantity">
                                                    @error("inventorySampleQuantities.{$inventory->id}_{$detail->id}")
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                    <div class="mt-2">
                                        <div><strong>Total Regular Selected: </strong>
                                            {{ collect($this->inventoryQuantities)->filter(function ($qty, $invKey) use ($detail) {
                                                    $inventoryId = (int) explode('_', $invKey)[0];
                                                    $detailId = (int) explode('_', $invKey)[1];
                                                    if ($detail->product_id == 1) {
                                                        return false;
                                                    }
                                                    return $detail->id === $detailId && $detail->product->inventories->contains('id', $inventoryId);
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
                                        <div><strong>Total Samples Selected: </strong>
                                            {{ $this->getTotalSelectedSampleQuantity($detail) }} /
                                            {{ $this->calculateRemainingSampleQuantity($detail) }}
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mb-4 row">
            <div class="col-md-12 ms-auto">
                @if ($order->workflow_type !== \App\Enums\OrderWorkflowType::MULTI_DELIVERY || $remainingQuantity === 0)
                    <div class="mb-3 col-md-6">
                        <label for="deliveryStatus" class="form-label">Update Delivery Status:</label>
                        <select wire:model="deliveryStatus" id="deliveryStatus" class="form-select">
                            <option value="Pending">Pending</option>
                            <option value="Shipped">Shipped</option>
                            <option value="Delivered">Delivered</option>
                            <option value="Cancelled">Cancelled</option>
                        </select>
                    </div>
                @endif
                <div class="col-md-6">
                    <label for="remarks">Remarks</label>
                    <textarea id="remarks" wire:model.defer="remarks" class="form-control"></textarea>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-end">
            <button wire:click="updateDelivery" class="btn btn-success" wire:loading.attr="disabled"
                @if ($disableButton) disabled @endif>
                <span wire:loading.remove wire:target="updateDelivery">
                    Update Delivery Order
                </span>
                <span wire:loading wire:target="updateDelivery">Updating...</span>
            </button>
        </div>
    </div>
</div>
