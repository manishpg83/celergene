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
                <div class="customer-profile">
                    <img src="{{ $customer->image ? asset('storage/' . $customer->image) : 'https://avatar.iran.liara.run/public' }}" alt="Profile" class="rounded-circle mb-3" />
                    <h5 class="mb-1">{{ $customer->first_name }} {{ $customer->last_name }}</h5>
                    <p class="text-muted">Customer ID #{{ $customer->id }}</p>
                </div>                
                <div class="d-flex justify-content-around my-3">
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
                    <p class="mt-1"><strong>Username:</strong>
                        {{ $customer->first_name . '.' . $customer->last_name }}</p>
                    <p class="mt-1"><strong>Email:</strong> {{ $customer->email }}</p>
                    <p class="mt-1"><strong>Status:</strong>
                        <span class="badge {{ $customer->trashed() ? 'bg-label-danger' : 'bg-label-success' }}">
                            {{ $customer->trashed() ? 'Suspended' : 'Active' }}
                        </span>
                    </p>
                    <p class="mt-1"><strong>Contact:</strong> {{ $customer->mobile_number }}</p>
                    <p class="mt-1"><strong>Country:</strong> {{ $customer->billing_country }}</p>
                </div>
                {{-- <button class="btn btn-primary w-100 mt-3">Edit Details</button> --}}
            </div>
        </div>

        <!-- Address Book Section -->
        <div class="col-md-8">
            <!-- Top Navigation -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div class="d-flex align-items-center top-navigation">
                    <button class="btn btn-link text-dark">Overview</button>
                    <button class="btn btn-link text-dark">Security</button>
                    <button class="btn btn-primary ms-2">Address & Billing</button>
                </div>
            </div>
            <div class="card shadow-sm p-3 mb-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="ml-6 mb-0 fs-5">Address Book</h5>
                    <button class="btn btn-outline-primary btn-sm">Add new address</button>
                </div>
                <div class="list-group list-group-flush">
                    <!-- Billing Address -->
                    <div class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <p class="mb-0"><strong>Home</strong> <span class="badge bg-label-success ms-2">Default
                                    Address</span></p>
                            <p class="text-muted mb-0">{{ $customer->billing_address }}</p>
                            <p class="text-muted mb-0">{{ $customer->billing_country }},
                                {{ $customer->billing_postal_code }}</p>
                        </div>
                        <div>
                            <button class="btn btn-link p-0 me-2"><i class="fas fa-edit"></i></button>
                            <button class="btn btn-link p-0"><i class="fas fa-trash-alt"></i></button>
                        </div>
                    </div>
                    <!-- Shipping Address 1 -->
                    <div class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <p class="mb-0"><strong>Office</strong></p>
                            <p class="text-muted mb-0">{{ $customer->shipping_address_1 }}</p>
                            <p class="text-muted mb-0">{{ $customer->shipping_country_1 }},
                                {{ $customer->shipping_postal_code_1 }}</p>
                        </div>
                        <div>
                            <button class="btn btn-link p-0 me-2"><i class="fas fa-edit"></i></button>
                            <button class="btn btn-link p-0"><i class="fas fa-trash-alt"></i></button>
                        </div>
                    </div>
                    <!-- Shipping Address 2 -->
                    @if ($customer->shipping_address_2)
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <p class="mb-0"><strong>Family</strong></p>
                                <p class="text-muted mb-0">{{ $customer->shipping_address_2 }}</p>
                                <p class="text-muted mb-0">{{ $customer->shipping_country_2 }},
                                    {{ $customer->shipping_postal_code_2 }}</p>
                            </div>
                            <div>
                                <button class="btn btn-link p-0 me-2"><i class="fas fa-edit"></i></button>
                                <button class="btn btn-link p-0"><i class="fas fa-trash-alt"></i></button>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
