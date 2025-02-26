<div class="p-6 mt-4 bg-white rounded-lg shadow-lg">
    <h2 class="mb-6 text-xl font-semibold text-gray-700">Manage Payments for Order #{{ $order_id }}</h2>

    <form wire:submit.prevent="savePayment" class="grid grid-cols-2 gap-4 mb-4">
        <div>
            <label class="block mb-2 font-medium text-gray-600">Payment Method</label>
            <select wire:model="payment_method" class="w-full p-2 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                <option value="">Select Payment Method</option>
                <option value="Bank Transfer">Bank Transfer</option>
                <option value="Cash">Cash</option>
                <option value="Credit Card">Credit Card</option>
                <option value="PayPal">PayPal</option>
                <option value="Others">Others</option>
            </select>
            @error('payment_method') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block mb-2 font-medium text-gray-600">Amount</label>
            <input type="number" wire:model="amount" class="w-full p-2 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" step="0.01">
            @error('amount') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block mb-2 font-medium text-gray-600">Payment Date</label>
            <input type="date" wire:model="payment_date" class="w-full p-2 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
            @error('payment_date') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block mb-2 font-medium text-gray-600">Payment Status</label>
            <select wire:model="status" class="w-full p-2 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                <option value="pending">Pending</option>
                <option value="partially paid">Partially Paid</option>
                <option value="fully paid">Fully Paid</option>
            </select>
            @error('status') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
        </div>

        <div class="col-span-2">
            <label class="block mb-2 font-medium text-gray-600">Payment Details</label>
            <textarea wire:model="payment_details" class="w-full p-2 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" rows="3"></textarea>
            @error('payment_details') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
        </div>

        <div class="col-span-2 text-end">
            <button type="submit" class="btn btn-primary">
                <i class="mr-2 fas fa-save"></i> Save Payment
            </button>
        </div>
    </form>
    <hr/>
    <h3 class="mt-4 font-semibold text-gray-700">Payment Records</h3>
    <div class="overflow-x-auto">
        <table class="w-full mt-3 border border-gray-200 rounded-lg shadow-sm">
            <thead class="text-center bg-gray-100">
                <tr>
                    <th class="p-2 text-gray-600 border">Method</th>
                    <th class="p-2 text-gray-600 border">Amount</th>
                    <th class="p-2 text-gray-600 border">Date</th>
                    <th class="p-2 text-gray-600 border">Payment Details</th>
                    <th class="p-2 text-gray-600 border">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($payments as $payment)
                    <tr class="text-center border">
                        <td class="p-2 text-gray-700 border">{{ $payment->payment_method }}</td>
                        <td class="p-2 text-gray-700 border">${{ number_format($payment->amount, 2) }}</td>
                        <td class="p-2 text-gray-700 border">{{ $payment->payment_date }}</td>
                        <td class="p-2 text-gray-700 border">{{ $payment->payment_details }}</td>
                        <td class="p-2 text-gray-700 border">{{ ucfirst($payment->status) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
