<div class="container p-4 mt-4 bg-white rounded shadow">
    <h5 class="mb-4 text-primary">Manage Payments for Order #{{ $order_id }}</h5>

    <form wire:submit.prevent="savePayment" class="mb-4 row g-3">
        <div class="col-md-6">
            <label class="form-label">Payment Method</label>
            <select wire:model="payment_method" class="form-select">
                <option value="">Select Payment Method</option>
                <option value="Bank Transfer">Bank Transfer</option>
                <option value="Cash">Cash</option>
                <option value="Credit Card">Credit Card</option>
                <option value="PayPal">PayPal</option>
                <option value="Others">Others</option>
            </select>
            @error('payment_method') <div class="text-danger small">{{ $message }}</div> @enderror
        </div>

        <div class="col-md-6">
            <label class="form-label">Amount</label>
            <input type="number" wire:model="amount" class="form-control" step="0.01">
            @error('amount') <div class="text-danger small">{{ $message }}</div> @enderror
        </div>
    

        <div class="col-md-6">
            <label class="form-label">Payment Date</label>
            <input type="date" wire:model="payment_date" class="form-control">
            @error('payment_date') <div class="text-danger small">{{ $message }}</div> @enderror
        </div>

        <div class="col-md-6">
            <label class="form-label">Payment Status</label>
            <select wire:model="status" class="form-select">
                <option value="pending">Pending</option>
                <option value="partially paid">Partially Paid</option>
                <option value="fully paid">Fully Paid</option>
                <option value="fully paid">Fully paid (bank charges waived)</option>
            </select>
            @error('status') <div class="text-danger small">{{ $message }}</div> @enderror
        </div>
        <div class="col-md-6">
            <label class="form-label">Bank Charges</label>
            <input type="number" wire:model="bank_charge" class="form-control" step="0.01">
            @error('bank_charge') <div class="text-danger small">{{ $message }}</div> @enderror
        </div>
        <div class="col-12">
            <label class="form-label">Payment Details</label>
            <textarea wire:model="payment_details" class="form-control" rows="3"></textarea>
            @error('payment_details') <div class="text-danger small">{{ $message }}</div> @enderror
        </div>

        <div class="col-12 text-end">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save me-2"></i> Save Payment
            </button>
        </div>
    </form>
    <hr/>
    <h5 class="mt-4 text-gray-700">Payment Records</h5>
    <div class="table-responsive">
        <table class="table mt-3 table-bordered table-hover">
            <thead class="text-center table-light">
                <tr>
                    <th>Method</th>
                    <th>Amount</th>
                    <th>Date</th>
                    <th>Payment Details</th>
                    <th>Bank Charges</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($payments as $payment)
                    <tr class="text-center">
                        <td>{{ $payment->payment_method }}</td>
                        <td>{{ $currencySymbol }} {{ number_format($payment->amount, 2) }}</td>
                        <td>{{ $payment->payment_date }}</td>
                        <td>{{ $payment->payment_details }}</td>
                        <td>{{ $payment->bank_charge }}</td>
                        <td>{{ ucfirst($payment->status) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
