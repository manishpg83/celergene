<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header sticky-element bg-label-secondary d-flex justify-content-sm-between align-items-sm-center flex-column flex-sm-row">
                    <h5 class="card-title mb-sm-0 me-2">{{ $currencyId ? 'Edit' : 'Add' }} Currency</h5>
                    <div class="action-btns">
                        <button wire:click="back" class="btn btn-label-primary me-4">
                            <span class="align-middle"> Back</span>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    @if (session()->has('message'))
                        <div class="bg-green-500 text-white p-2 mb-4">
                            {{ session('message') }}
                        </div>
                    @endif

                    <form wire:submit.prevent="saveCurrency">
                        <input type="hidden" wire:model="currencyId">
                        <div class="row g-3 mt-2">
                            <div class="col-md-12">
                                <label class="form-label" for="name">Currency Name</label>
                                <input type="text" id="name" wire:model="name" class="form-control" placeholder="Enter currency name" required>
                                @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label" for="code">Currency Code</label>
                                <input type="text" id="code" wire:model="code" class="form-control" placeholder="Enter currency code (e.g., USD)" required>
                                @error('code') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label" for="symbol">Currency Symbol</label>
                                <input type="text" id="symbol" wire:model="symbol" class="form-control" placeholder="Enter currency symbol (e.g., $)" required>
                                @error('symbol') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-md-12">
                                <label class="form-label" for="rate">Exchange Rate</label>
                                <input type="number" id="rate" wire:model="rate" class="form-control" step="0.0001" placeholder="Enter exchange rate" required>
                                @error('rate') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-md-12">
                                <label class="form-label">Status</label>
                                <div class="mt-2">
                                    <div class="form-check form-check-inline">
                                        <input wire:model="status" class="form-check-input" type="radio" value="active" id="status_active" required>
                                        <label class="form-check-label" for="status_active">Active</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input wire:model="status" class="form-check-input" type="radio" value="inactive" id="status_inactive" required>
                                        <label class="form-check-label" for="status_inactive">Inactive</label>
                                    </div>
                                </div>
                                @error('status') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="col-12 mt-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ $currencyId ? 'Update Currency' : 'Add Currency' }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>