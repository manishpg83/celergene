<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card">
        <div class="card-body">
            <h1 class="mb-4">Manage Countries</h1>

            <!-- Add Country Form -->
            <form wire:submit.prevent="addCountry">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="name" class="form-label">Country Name</label>
                        <input type="text" class="form-control" wire:model="name" required>
                    </div>
                    <div class="col-md-6">
                        <label for="currency_code" class="form-label">Currency Code</label>
                        <input type="text" class="form-control" wire:model="currency_code" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="currency_name" class="form-label">Currency Name</label>
                        <input type="text" class="form-control" wire:model="currency_name" required>
                    </div>
                    <div class="col-md-6">
                        <label for="currency_symbol" class="form-label">Currency Symbol</label>
                        <input type="text" class="form-control" wire:model="currency_symbol">
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="rate" class="form-label">Currency Rate</label>
                        <input type="number" class="form-control" wire:model="rate" step="0.0001" required>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Add Country</button>
            </form>

            <!-- Existing Countries Table -->
            <h2 class="mt-5">Existing Countries</h2>

            <!-- Table Wrapper -->
            <div class="table-responsive mt-3">
                <table class="table table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th>Country Name</th>
                            <th>Currency Code</th>
                            <th>Currency Name</th>
                            <th>Currency Symbol</th>
                            <th>Current Rate</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($countries as $country)
                            <tr>
                                <td>{{ $country->name }}</td>
                                <td>{{ $country->currency_code }}</td>
                                <td>{{ $country->currency_name }}</td>
                                <td>{{ $country->currency_symbol }}</td>
                                <td>{{ optional($country->currencyRates->first())->rate ?? 'N/A' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">No countries found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
