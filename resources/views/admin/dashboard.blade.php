@extends('layouts.admin')

@section('title', 'Admin Dashboard')
@section('header', 'Admin Dashboard')

@section('content')
    <div class="container mt-4">
        <h1 class="h4 font-weight-bold mb-4">Admin Dashboard</h1>

        <div class="row text-center">
            <div class="col-md-3 mb-3">
                <div class="card shadow-sm border-0" style="padding: 10px; transition: transform 0.3s, box-shadow 0.3s;"
                    onmouseover="this.style.transform='scale(1.05)'; this.style.boxShadow='0 4px 8px rgba(0, 0, 0, 0.2)';"
                    onmouseout="this.style.transform='scale(1)'; this.style.boxShadow='0 2px 4px rgba(0, 0, 0, 0.1)';">
                    <div class="card-body p-3">
                        <div class="text-center mb-2">
                            <i class="fas fa-box fa-2x text-danger"></i>
                        </div>
                        <h6 class="text-secondary">Orders</h6>
                        <p class="h4 font-weight-bold mb-0">{{ $totalOrders }}</p>
                    </div>
                </div>
            </div>

            <div class="col-md-3 mb-3">
                <div class="card shadow-sm border-0" style="padding: 10px; transition: transform 0.3s, box-shadow 0.3s;"
                    onmouseover="this.style.transform='scale(1.05)'; this.style.boxShadow='0 4px 8px rgba(0, 0, 0, 0.2)';"
                    onmouseout="this.style.transform='scale(1)'; this.style.boxShadow='0 2px 4px rgba(0, 0, 0, 0.1)';">
                    <div class="card-body p-3">
                        <div class="text-center mb-2">
                            <i class="fas fa-dollar-sign fa-2x text-success"></i>
                        </div>
                        <h6 class="text-secondary">Total Order</h6>
                        <p class="h4 font-weight-bold mb-0">${{ number_format($averageOrder, 2) }}</p>
                    </div>
                </div>
            </div>

            <div class="col-md-3 mb-3">
                <div class="card shadow-sm border-0" style="padding: 10px; transition: transform 0.3s, box-shadow 0.3s;"
                    onmouseover="this.style.transform='scale(1.05)'; this.style.boxShadow='0 4px 8px rgba(0, 0, 0, 0.2)';"
                    onmouseout="this.style.transform='scale(1)'; this.style.boxShadow='0 2px 4px rgba(0, 0, 0, 0.1)';">
                    <div class="card-body p-3">
                        <div class="text-center mb-2">
                            <i class="fas fa-shopping-cart fa-2x text-primary"></i>
                        </div>
                        <h6 class="text-secondary">Avg Purchase</h6>
                        <p class="h4 font-weight-bold mb-0">${{ number_format($averagePurchase, 2) }}</p>
                    </div>
                </div>
            </div>

            <div class="col-md-3 mb-3">
                <div class="card shadow-sm border-0" style="padding: 10px; transition: transform 0.3s, box-shadow 0.3s;"
                    onmouseover="this.style.transform='scale(1.05)'; this.style.boxShadow='0 4px 8px rgba(0, 0, 0, 0.2)';"
                    onmouseout="this.style.transform='scale(1)'; this.style.boxShadow='0 2px 4px rgba(0, 0, 0, 0.1)';">
                    <div class="card-body p-3">
                        <div class="text-center mb-2">
                            <i class="fas fa-users fa-2x text-info"></i>
                        </div>
                        <h6 class="text-secondary">Customers</h6>
                        <p class="h4 font-weight-bold mb-0">{{ $totalCustomers }}</p>
                    </div>
                </div>
            </div>
        </div>


        <div class="row mt-5">
            <!-- Products Card -->
            <div class="col-md-6 mb-4">
                <div class="card border-0 rounded-lg bg-white"
                    style="transition: all 0.3s ease; box-shadow: 0 .5rem 1rem rgba(0,0,0,.15);"
                    onmouseover="this.style.boxShadow='0 1rem 3rem rgba(0,0,0,.175)'"
                    onmouseout="this.style.boxShadow='0 .5rem 1rem rgba(0,0,0,.15)'">
                    <div class="card-header border-0 bg-white d-flex justify-content-between align-items-center py-3">
                        <h5 class="mb-0 font-weight-bold text-primary">Products</h5>
                        <a href="{{ route('admin.products.index') }}"
                            class="btn btn-light rounded-circle p-2 d-inline-flex align-items-center justify-content-center"
                            style="transition: transform 0.2s ease;" onmouseover="this.style.transform='scale(1.1)'"
                            onmouseout="this.style.transform='scale(1)'">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor"
                                class="bi bi-arrow-left" viewBox="0 0 16 16">
                                <path fill-rule="evenodd"
                                    d="M5.854 4.646a.5.5 0 0 0-.708.708L9.293 9H1.5a.5.5 0 0 0 0 1h7.793l-4.147 4.146a.5.5 0 0 0 .708.708l5-5a.5.5 0 0 0 0-.708l-5-5z" />
                            </svg>
                        </a>
                    </div>

                    <div class="table-responsive px-3">
                        <table class="table table-hover align-middle mb-0">
                            <thead>
                                <tr style="background-color: #f8f9fa;">
                                    <th class="border-0 py-3 text-dark" style="border-top-left-radius: 0.5rem;">Name</th>
                                    <th class="border-0 py-3 text-dark">Price</th>
                                    <th class="border-0 py-3 text-dark" style="border-top-right-radius: 0.5rem;">Product
                                        Code</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($products as $product)
                                    <tr class="border-bottom" style="transition: all 0.3s ease;">
                                        <td class="py-3">
                                            <div class="d-flex align-items-center">
                                                <div class="rounded-circle p-2 me-3"
                                                    style="background-color: rgba(13, 110, 253, 0.1);">
                                                    <i class="fas fa-box text-primary"></i>
                                                </div>
                                                <span class="fw-semibold">{{ $product->product_name }}</span>
                                            </div>
                                        </td>
                                        <td class="py-3">
                                            <span
                                                style="background-color: rgba(25, 135, 84, 0.1); color: #198754; padding: 0.5rem 1rem; border-radius: 0.375rem;">
                                                ${{ number_format($product->unit_price, 2) }}
                                            </span>
                                        </td>
                                        <td class="py-3">
                                            <span class="text-muted">{{ $product->product_code }}</span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Recent Orders Card -->
            <div class="col-md-6 mb-4">
                <div class="card border-0 rounded-lg bg-white"
                    style="transition: all 0.3s ease; box-shadow: 0 .5rem 1rem rgba(0,0,0,.15);"
                    onmouseover="this.style.boxShadow='0 1rem 3rem rgba(0,0,0,.175)'"
                    onmouseout="this.style.boxShadow='0 .5rem 1rem rgba(0,0,0,.15)'">
                    <div class="card-header border-0 bg-white d-flex justify-content-between align-items-center py-3">
                        <h5 class="mb-0 font-weight-bold text-primary">Recent Orders</h5>
                        <a href="{{ route('admin.orders.index') }}"
                            class="btn btn-light rounded-circle p-2 d-inline-flex align-items-center justify-content-center"
                            style="transition: transform 0.2s ease;" onmouseover="this.style.transform='scale(1.1)'"
                            onmouseout="this.style.transform='scale(1)'">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor"
                                class="bi bi-arrow-left" viewBox="0 0 16 16">
                                <path fill-rule="evenodd"
                                    d="M5.854 4.646a.5.5 0 0 0-.708.708L9.293 9H1.5a.5.5 0 0 0 0 1h7.793l-4.147 4.146a.5.5 0 0 0 .708.708l5-5a.5.5 0 0 0 0-.708l-5-5z" />
                            </svg>
                        </a>
                    </div>

                    <div class="table-responsive px-3">
                        <table class="table align-middle mb-0 table-hover">
                            <thead>
                                <tr style="background-color: #f8f9fa;">
                                    <th class="border-0 py-3 text-dark" style="border-top-left-radius: 0.5rem;">Date</th>
                                    <th class="border-0 py-3 text-dark">Invoice</th>
                                    <th class="border-0 py-3 text-dark" style="border-top-right-radius: 0.5rem;">Status
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($orders as $order)
                                    <tr class="border-bottom" style="transition: all 0.3s ease;">
                                        <td class="py-3">
                                            <div class="d-flex align-items-center">
                                                <div class="rounded-circle p-2 me-3"
                                                    style="background-color: rgba(13, 110, 253, 0.1);">
                                                    <i class="fas fa-calendar text-primary"></i>
                                                </div>
                                                <span>{{ $order->invoice_date->format('M d, Y') }}</span>
                                            </div>
                                        </td>
                                        <td class="py-3">
                                            <span
                                                style="background-color: #f8f9fa; color: #212529; padding: 0.5rem 1rem; border-radius: 0.375rem;">
                                                IN {{ $order->invoice_id }}
                                            </span>
                                        </td>
                                        <td class="py-3">
                                            <span
                                                style="padding: 0.5rem 1rem; border-radius: 50rem;
                                    @if ($order->invoice_status === 'Paid') background-color: rgba(25, 135, 84, 0.1); color: #198754;
                                    @elseif ($order->invoice_status === 'Pending')
                                        background-color: rgba(255, 193, 7, 0.1); color: #ffc107;
                                    @elseif ($order->invoice_status === 'Cancelled')
                                        background-color: rgba(220, 53, 69, 0.1); color: #dc3545; @endif">
                                                {{ ucfirst($order->invoice_status) }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
