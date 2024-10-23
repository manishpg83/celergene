<div class="container mt-5">
    <h2 class="mb-4">Create Order</h2>
    <form wire:submit.prevent="submitOrder" class="bg-light p-4 rounded shadow">
        
        <div class="mb-3">
            <label for="customer" class="form-label">Select Customer:</label>
            <select wire:model="customer_id" class="form-select">
                <option value="">Select a customer</option>
                @foreach($customers as $customer)
                    <option value="{{ $customer->id }}">{{ $customer->first_name }} {{ $customer->last_name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="shipping_address" class="form-label">Shipping Address:</label>
            <input type="text" wire:model="shipping_address" class="form-control">
        </div>

        <div class="mb-3">
            <h5>Order Details</h5>
            @foreach($orderDetails as $index => $orderDetail)
                <div class="row mb-3 align-items-end">
                    <div class="col">
                        <select wire:model.live="orderDetails.{{ $index }}.id" class="form-select">
                            <option value="">Select a product</option>
                            @foreach($products as $product)
                                <option value="{{ $product->id }}">{{ $product->product_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col">
                        <input type="number" wire:model="orderDetails.{{ $index }}.quantity" placeholder="Quantity" class="form-control" min="1" wire:change="updatedOrderDetails(orderDetails)">
                    </div>
                    <div class="col">
                        <input type="number" wire:model="orderDetails.{{ $index }}.unit_price" placeholder="Unit Price" class="form-control"  readonly>
                    </div>
                    <div class="col">
                        <input type="number" wire:model="orderDetails.{{ $index }}.discount" placeholder="Discount" class="form-control" min="0" wire:change="updatedOrderDetails(orderDetails)">
                    </div>
                    <div class="col-auto">
                        <button wire:click.prevent="removeOrderDetail({{ $index }})" class="btn btn-danger">Remove</button>
                    </div>
                </div>
            @endforeach

            <button wire:click.prevent="addOrderDetail" class="btn btn-primary">+ Add Item</button>
        </div>

        <div class="mb-3">
            <label for="subtotal" class="form-label">Subtotal:</label>
            <input type="text" wire:model="subtotal" readonly class="form-control" placeholder="Subtotal">
        </div>

        <div class="mb-3">
            <label for="discount" class="form-label">Discount:</label>
            <input type="text" wire:model="discount" class="form-control" min="0">
        </div>

        <div class="mb-3">
            <label for="tax" class="form-label">Tax:</label>
            <input type="text" wire:model="tax" class="form-control" min="0">
        </div>

        <div class="mb-3">
            <label for="total" class="form-label">Total:</label>
            <input type="text" wire:model="total" readonly class="form-control" placeholder="Total">
        </div>
        
        <button type="submit" class="btn btn-success">Submit Order</button>
    </form>
</div>
