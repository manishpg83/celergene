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
            <div class="col-md-6 mb-4">
                <div class="card shadow-sm border-0 rounded-lg bg-white">
                    <div class="card-header border-0 bg-white d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Products</h5>
                        <a href="{{ route('admin.products.index') }}" class="rounded-circle d-inline-flex align-items-center justify-content-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M5.854 4.646a.5.5 0 0 0-.708.708L9.293 9H1.5a.5.5 0 0 0 0 1h7.793l-4.147 4.146a.5.5 0 0 0 .708.708l5-5a.5.5 0 0 0 0-.708l-5-5z"/>
                            </svg>
                        </a>
                        
                    </div>
                    
                    <div class="table-responsive">
                        <table class="table table-borderless mb-0 ">
                            <thead class="text-secondary" style="font-size: 0.9rem; background-color: #f8f9fa;">
                                <tr>
                                    <th>Name</th>
                                    <th>Price</th>
                                    <th>Product Code</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($products as $product)
                                    <tr style="background-color: white;">
                                        <td>{{ $product->product_name }}</td>
                                        <td>${{ number_format($product->unit_price, 2) }}</td>
                                        <td>{{ $product->product_code }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-md-6 mb-4">
                <div class="card shadow-sm border-0 rounded-lg bg-white">
                    <div class="card-header border-0 bg-white d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Recent Orders</h5>
                        <a href="{{ route('admin.orders.index') }}" class="rounded-circle d-inline-flex align-items-center justify-content-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M5.854 4.646a.5.5 0 0 0-.708.708L9.293 9H1.5a.5.5 0 0 0 0 1h7.793l-4.147 4.146a.5.5 0 0 0 .708.708l5-5a.5.5 0 0 0 0-.708l-5-5z"/>
                            </svg>
                        </a>
                        
                    </div>
                    
                    <div class="table-responsive">
                        <table class="table table-borderless table-hover mb-0">
                            <thead class="text-secondary" style="font-size: 0.9rem; background-color: #f8f9fa;">
                                <tr>
                                    <th>Date</th>
                                    <th>Invoice</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($orders as $order)
                                    <tr style="background-color: white;">
                                        <td>{{ $order->invoice_date->format('Y-m-d') }}</td>
                                        <td>IN {{ $order->invoice_id }}</td>
                                        <td>
                                            <span class="badge"
                                                  style="background-color: 
                                                      @if ($order->invoice_status === 'Paid') #28c76f 
                                                      @elseif ($order->invoice_status === 'Pending') #FF9F43 
                                                      @elseif ($order->invoice_status === 'Cancelled') #FF4C51 
                                                      @else white 
                                                      @endif; 
                                                      color: #fff; 
                                                      padding: 0.25rem 0.5rem; 
                                                      font-size: 0.85rem; 
                                                      border-radius: 0.25rem;">
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
