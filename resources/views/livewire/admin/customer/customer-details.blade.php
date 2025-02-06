<style>
    .customer-profile {
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .customer-profile img {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        margin-bottom: 1rem;
    }

    .customer-profile h5 {
        margin-bottom: 0.25rem;
    }

    .customer-profile p {
        margin-bottom: 0;
    }

    /* Align the top navigation to the right */
    .top-navigation {
        display: flex;
        justify-content: flex-start;
        align-items: center;
        width: 100%;
    }

    .top-navigation button,
    .top-navigation img {
        margin-left: 1rem;
    }
</style>
<div class="container-fluid py-4">
    <!-- Top Navigation -->
    <div
        class="d-flex flex-column flex-sm-row align-items-center justify-content-sm-between mb-4 text-center text-sm-start gap-2">
        <div class="ml-6 mb-2 mb-sm-0">
            <h4 class="fw-bold fs-4">Customer ID #{{ $customer->id }}</h4>
            <p class="mb-0">{{ $customer->created_at }}</p>
        </div>
        {{-- <div class="align-items-end">
            <button type="button" class="btn btn-label-danger delete-customer waves-effect">Delete Customer</button>
            <button type="button" class="btn btn-label-danger suspend-customer waves-effect">Suspend Customer</button>
        </div> --}}
    </div>

    <!-- Main Content -->
    <div class="row">
        <!-- Customer Profile Card -->
        <div class="col-md-4">
            <div class="card shadow-sm p-3 mb-4">
                <div class="customer-profile mt-3 text-center">
                    <img src="{{ $customer->image ? asset('storage/' . $customer->image) : asset('frontend/images/default.jpeg') }}"
                        alt="Profile" class="rounded-circle mb-3" style="width: 100px; height: 100px; object-fit: cover;" />
                    <h5 class="mb-1">{{ $customer->first_name }} {{ $customer->last_name }}</h5>
                    <p class="text-muted">Customer ID #{{ $customer->id }}</p>
                </div>                
                <div class="d-flex justify-content-around mb-5 mt-7">
                    <div class="text-center">
                        <i class="fas fa-shopping-cart fa-lg text-primary"></i>
                        <p class="fw-bold mt-1">{{ $customer->orders_count }}</p>
                        <p class="text-muted">Orders</p>
                    </div>
                    <div class="text-center">
                        <i class="fas fa-dollar-sign fa-lg text-primary"></i>
                        <p class="fw-bold mt-1">${{ number_format($customer->orders_sum_total, 2) }}</p>
                        <p class="text-muted">Spent</p>
                    </div>
                </div>
                <hr>
                <div class="mb-2">
                    <p class="mt-4"><strong>Name:</strong>
                        {{ $customer->first_name }} {{ $customer->last_name }}</p>
                    <p class="mt-3"><strong>Email:</strong> {{ $customer->email }}</p>
                    <p class="mt-3"><strong>Type:</strong> {{ $customer->customerType->customer_type ?? 'N/A' }}</p>
                    <p class="mt-3"><strong>Status:</strong>
                        <span class="badge {{ $customer->trashed() ? 'bg-label-danger' : 'bg-label-success' }}">
                            {{ $customer->trashed() ? 'Suspended' : 'Active' }}
                        </span>
                    </p>
                    <p class="mt-3"><strong>Contact:</strong> {{ $customer->mobile_number }}</p>
                    <p class="mt-3"><strong>Country:</strong> {{ $customer->billing_country }}</p>
                </div>
                {{-- <button class="btn btn-primary w-100 mt-3">Edit Details</button> --}}
            </div>
        </div>

        <!-- Address Book Section -->
        <div class="col-md-8">
            <livewire:admin.customer.customer-tabs :customer="$customer" />
        </div>
    </div>
</div>
