<div>
    <h2>Product List</h2>

    @if (session()->has('message'))
        <div class="alert alert-success">{{ session('message') }}</div>
    @endif

    <table class="table table-striped">
        <thead>
            <tr>
                <th>Brand</th>
                <th>Product Name</th>
                <th>Product Category</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $product)
                <tr>
                    <td>{{ $product->brand }}</td>
                    <td>{{ $product->product_name }}</td>
                    <td>{{ $product->product_category }}</td>
                    <td>
                        <button wire:click="deleteProduct({{ $product->id }})" class="btn btn-danger">Delete</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
