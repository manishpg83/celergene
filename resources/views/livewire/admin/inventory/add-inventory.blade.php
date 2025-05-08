<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div
                    class="card-header sticky-element bg-label-secondary d-flex justify-content-sm-between align-items-sm-center flex-column flex-sm-row">
                    <h5 class="card-title mb-sm-0 me-2">{{ $isEditMode ? 'Edit Inventory' : 'Add New Inventory' }}</h5>
                    <div class="action-btns">
                        <button wire:click="back" class="btn btn-label-primary me-4">
                            <span class="align-middle"> Back</span>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="mx-auto col-lg-10">
                            @if (session()->has('success'))
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                            @endif

                            <form wire:submit.prevent="saveInventory" class="mt-2 row g-3">
                                <div class="col-md-6">
                                    <label class="form-label" for="product_code">Product</label>
                                    <select wire:model="product_code" id="product_code" class="form-select" required>
                                        <option value="">-- Select Product --</option>
                                        @foreach ($products as $product)
                                            <option value="{{ $product->id }}">{{ $product->product_code }}</option>
                                        @endforeach
                                    </select>
                                    @error('product_code')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label" for="warehouse_id">Warehouse</label>
                                    <select wire:model="warehouse_id" id="warehouse_id" class="form-select" required>
                                        <option value="">-- Select Warehouse --</option>
                                        @foreach ($warehouses as $warehouse)
                                            <option value="{{ $warehouse->id }}">{{ $warehouse->warehouse_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('warehouse_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label" for="batch_number">Batch Number</label>
                                    <select wire:model="batch_number" id="batch_number" class="form-select" required>
                                        <option value="">-- Select Batch Number --</option>
                                        @foreach ($batchNumbers as $id => $batchNumber)
                                            <option value="{{ $batchNumber }}">{{ $batchNumber }}</option>
                                        @endforeach
                                    </select>
                                    @error('batch_number')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label" for="expiry">Expiry Date (Scroll down to change
                                        year)</label>
                                    <input type="month" wire:model="expiry" id="expiry" min="{{ date('Y-m') }}"
                                        class="form-control @error('expiry') is-invalid @enderror">
                                    @error('expiry')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>


                                <div class="col-md-6">
                                    <label class="form-label" for="quantity">Quantity</label>
                                    <input type="number" wire:model="quantity" id="quantity" class="form-control"
                                        placeholder="Enter quantity" required>
                                    @error('quantity')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label" for="reason">Reason</label>
                                    <input type="text" wire:model="reason" id="reason" class="form-control"
                                        placeholder="Enter reason" required>
                                    @error('reason')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label class="form-label">Available Quantity</label>
                                            <p class="form-control-plaintext fw-bold">{{ $remaining }}</p>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">Consumed Quantity</label>
                                            <p class="form-control-plaintext fw-bold">{{ $consumed }}</p>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">Total Quantity</label>
                                            <p class="form-control-plaintext fw-bold">{{ $remaining + $consumed }}</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-4 col-12">
                                    <button type="submit" class="btn btn-primary">
                                        {{ $isEditMode ? 'Update Inventory' : 'Add Inventory' }}
                                    </button>
                                </div>
                            </form>
                            @if ($isEditMode)
                                    <div class="mt-2 row">
                                        <form wire:submit.prevent="transferStock">
                                            <div class="mb-3">
                                                <label class="form-label" for="destination_warehouse_id">Destination
                                                    Warehouse</label>
                                                <select wire:model="destination_warehouse_id" id="destination_warehouse_id"
                                                    class="form-select" required>
                                                    <option value="">-- Select Warehouse --</option>
                                                    @foreach ($warehouses as $warehouse)
                                                        <option value="{{ $warehouse->id }}">{{ $warehouse->warehouse_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('destination_warehouse_id')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label" for="transfer_quantity">Quantity to Transfer</label>
                                                <input type="number" wire:model="transfer_quantity" id="transfer_quantity"
                                                    class="form-control" placeholder="Enter quantity" required>
                                                @error('transfer_quantity')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label" for="transfer_reason">Reason</label>
                                                <input type="text" wire:model="transfer_reason" id="transfer_reason"
                                                    class="form-control" placeholder="Enter reason" required>
                                                @error('transfer_reason')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="mt-4 col-12">
                                                <button type="submit" class="btn btn-primary">
                                                    Transfer Stock
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                                <div class="mt-5">
                                    <h5 class="mb-2 fw-bold text-primary">📦 Inventory History</h5>
                                    <div
                                        class="p-3 mb-3 border rounded bg-light d-flex justify-content-between align-items-center">
                                        <span class="fw-bold text-dark">🛒 Remaining Inventory:</span>
                                        <span class="fs-5 fw-bold text-primary">Consumed:
                                            {{ number_format($consumed) }}</span><br>
                                        <span class="fs-5 fw-bold text-success">Remaining:
                                            {{ number_format($remaining) }}</span><br>
                                        <span class="fs-5 fw-bold text-dark">Total:
                                            {{ number_format($consumed + $remaining) }}</span>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th class="text-center" wire:click="sortBy('quantity_change')"
                                                        style="cursor: pointer;">Quantity Change</th>
                                                    <th class="text-center" wire:click="sortBy('new_quantity')"
                                                        style="cursor: pointer;">New Quantity</th>
                                                    <th class="text-center" wire:click="sortBy('reason')"
                                                        style="cursor: pointer;">Reason</th>
                                                    <th class="text-center" wire:click="sortBy('created_by')"
                                                        style="cursor: pointer;">Created By</th>
                                                    <th class="text-center" wire:click="sortBy('updated_at')"
                                                        style="cursor: pointer;">Updated At</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if ($stockHistory->isEmpty())
                                                    <tr>
                                                        <td colspan="6" class="py-3 text-center text-muted">
                                                            🚫 No history records found.
                                                        </td>
                                                    </tr>
                                                @else
                                                    @foreach ($stockHistory as $history)
                                                        <tr>
                                                            <td class="text-center">
                                                                <span
                                                                    class="badge bg-{{ $history->quantity_change > 0 ? 'success' : 'danger' }}">
                                                                    {{ $history->quantity_change > 0 ? '+' : '-' }}{{ number_format(abs($history->quantity_change)) }}
                                                                </span>
                                                            </td>
                                                            <td class="text-center fw-bold">
                                                                {{ number_format($history->new_quantity) }}
                                                            </td>
                                                            <td class="text-center">
                                                                <span class="badge bg-info">{{ $history->reason }}</span>
                                                            </td>
                                                            <td class="text-center text-primary fw-semibold">
                                                                {{ $history->creator->name }}
                                                            </td>
                                                            <td class="text-center text-muted">
                                                                <small>{{ $history->created_at->format('Y-m-d H:i:s') }}</small>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>

                                    @if ($stockHistory->hasPages())
                                        <div class="mt-3">
                                            {{ $stockHistory->links() }}
                                        </div>
                                    @endif
                                </div>
                            @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>