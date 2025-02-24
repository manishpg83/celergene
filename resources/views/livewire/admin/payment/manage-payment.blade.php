<div class="bg-white shadow-md rounded-lg p-6">
    <h2 class="text-xl font-semibold mb-4 text-gray-700">Manage Payments for Order #{{ $order_id }}</h2>

    @if (session()->has('message'))
        <div class="bg-green-100 text-green-700 p-2 rounded-md mb-4">
            {{ session('message') }}
        </div>
    @endif

    <form wire:submit.prevent="savePayment" class="grid grid-cols-2 gap-4">
        <div>
            <label class="block text-gray-600 font-medium mb-1">Payment Method</label>
            <select wire:model="payment_method" class="w-full border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500">
                <option value="">Select Payment Method</option>
                <option value="Bank Transfer">Bank Transfer</option>
                <option value="Cash">Cash</option>
                <option value="Credit Card">Credit Card</option>
                <option value="PayPal">PayPal</option>
                <option value="Others">Others</option>
            </select>
            @error('payment_method') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block text-gray-600 font-medium mb-1">Amount</label>
            <input type="number" wire:model="amount" class="w-full border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500" step="0.01">
            @error('amount') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block text-gray-600 font-medium mb-1">Payment Date</label>
            <input type="date" wire:model="payment_date" class="w-full border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500">
            @error('payment_date') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block text-gray-600 font-medium mb-1">Payment Status</label>
            <select wire:model="status" class="w-full border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500">
                <option value="pending">Pending</option>
                <option value="partially paid">Partially Paid</option>
                <option value="fully paid">Fully Paid</option>
            </select>
            @error('status') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="col-span-2">
            <label class="block text-gray-600 font-medium mb-1">Payment Details</label>
            <textarea wire:model="payment_details" class="w-full border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500" rows="3"></textarea>
            @error('payment_details') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="col-span-2">
            <button type="submit" class="w-full bg-blue-600 text-white font-semibold py-2 rounded-md hover:bg-blue-700 transition">
                <i class="fas fa-save"></i> Save Payment
            </button>
        </div>
    </form>

    <h3 class="mt-6 font-semibold text-gray-700">Payment Records</h3>
    <div class="overflow-x-auto">
        <table class="w-full mt-3 border border-gray-200 rounded-lg shadow-sm">
            <thead class="bg-gray-100">
                <tr>
                    <th class="border p-2 text-gray-600">Method</th>
                    <th class="border p-2 text-gray-600">Amount</th>
                    <th class="border p-2 text-gray-600">Date</th>
                    <th class="border p-2 text-gray-600">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($payments as $payment)
                    <tr class="border">
                        <td class="border p-2 text-gray-700">{{ $payment->payment_method }}</td>
                        <td class="border p-2 text-gray-700">${{ number_format($payment->amount, 2) }}</td>
                        <td class="border p-2 text-gray-700">{{ $payment->payment_date }}</td>
                        <td class="border p-2 text-gray-700">{{ ucfirst($payment->status) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
