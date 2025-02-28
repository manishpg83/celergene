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
                            <i class="fas fa-box fa-2x text-primary"></i>
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
                            <i class="fas fa-dollar-sign fa-2x text-primary"></i>
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
                            <i class="fas fa-users fa-2x text-primary"></i>
                        </div>
                        <h6 class="text-secondary">Customers</h6>
                        <p class="h4 font-weight-bold mb-0">{{ $totalCustomers }}</p>
                    </div>
                </div>
            </div>
        </div>


        <div class="row mt-5">
            <!-- Recent Orders Card -->
            <div class="col-md-6 mb-4">
                <div class="card border-0 rounded-lg bg-white"
                    style="transition: all 0.3s ease; box-shadow: 0 .5rem 1rem rgba(0,0,0,.15);"
                    onmouseover="this.style.boxShadow='0 1rem 3rem rgba(0,0,0,.175)'"
                    onmouseout="this.style.boxShadow='0 .5rem 1rem rgba(0,0,0,.15)'">
                    <div class="card-header border-0 bg-white d-flex justify-content-between align-items-center py-3">
                        <h5 class="mb-0 font-weight-bold text-primary">Recent Orders - Offline</h5>
                        <a href="{{ route('admin.orders.index') }}"
                            class="btn btn-light rounded-circle p-2 d-inline-flex align-items-center justify-content-center"
                            style="transition: transform 0.2s ease;" onmouseover="this.style.transform='scale(1.1)'"
                            onmouseout="this.style.transform='scale(1)'">
                            <i class="fas fa-arrow-right"></i>
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
                                                <div class="rounded-circle p-2 me-3">
                                                    <i class="fas fa-calendar text-primary"></i>
                                                </div>
                                                <span>{{ $order->order_date->format('M d, Y') }}</span>
                                            </div>
                                        </td>
                                        <td class="py-3">
                                            <span
                                                style="background-color: #f8f9fa; color: #212529; padding: 0.5rem 1rem; border-radius: 0.375rem;">
                                                IN {{ $order->order_id }}
                                            </span>
                                        </td>
                                        <td class="py-3">
                                            <span
                                                style="padding: 0.5rem 1rem; border-radius: 50rem;
                                @if ($order->order_status === 'Paid') background-color: rgba(25, 135, 84, 0.1); color: #198754;
                                @elseif ($order->order_status === 'Pending')
                                    background-color: rgba(255, 193, 7, 0.1); color: #ffc107;
                                @elseif ($order->order_status === 'Cancelled')
                                    background-color: rgba(220, 53, 69, 0.1); color: #dc3545; @endif">
                                                {{ ucfirst($order->order_status) }}
                                            </span>
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
                        <h5 class="mb-0 font-weight-bold text-primary">Recent Orders - Online</h5>
                        <a href="{{ route('admin.orders.index') }}"
                            class="btn btn-light rounded-circle p-2 d-inline-flex align-items-center justify-content-center"
                            style="transition: transform 0.2s ease;" onmouseover="this.style.transform='scale(1.1)'"
                            onmouseout="this.style.transform='scale(1)'">
                            <i class="fas fa-arrow-right"></i>
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
                                @foreach ($onlineorders as $order)
                                    <tr class="border-bottom" style="transition: all 0.3s ease;">
                                        <td class="py-3">
                                            <div class="d-flex align-items-center">
                                                <div class="rounded-circle p-2 me-3">
                                                    <i class="fas fa-calendar text-primary"></i>
                                                </div>
                                                <span>{{ $order->order_date->format('M d, Y') }}</span>
                                            </div>
                                        </td>
                                        <td class="py-3">
                                            <span
                                                style="background-color: #f8f9fa; color: #212529; padding: 0.5rem 1rem; border-radius: 0.375rem;">
                                                IN {{ $order->order_id }}
                                            </span>
                                        </td>
                                        <td class="py-3">
                                            <span
                                                style="padding: 0.5rem 1rem; border-radius: 50rem;
                                @if ($order->order_status === 'Paid') background-color: rgba(25, 135, 84, 0.1); color: #198754;
                                @elseif ($order->order_status === 'Pending')
                                    background-color: rgba(255, 193, 7, 0.1); color: #ffc107;
                                @elseif ($order->order_status === 'Cancelled')
                                    background-color: rgba(220, 53, 69, 0.1); color: #dc3545; @endif">
                                                {{ ucfirst($order->order_status) }}
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

        <div class="col-md-12 mb-4">
            <div class="card border-0 rounded-lg bg-white"
                style="transition: all 0.3s ease; box-shadow: 0 .5rem 1rem rgba(0,0,0,.15);"
                onmouseover="this.style.boxShadow='0 1rem 3rem rgba(0,0,0,.175)'"
                onmouseout="this.style.boxShadow='0 .5rem 1rem rgba(0,0,0,.15)'">
                <div class="card-header border-0 bg-white d-flex justify-content-between align-items-center py-3">
                    <h5 class="mb-0 font-weight-bold text-primary">Recent Customers</h5>
                    <a href="{{ route('admin.customer.index') }}"
                        class="btn btn-light rounded-circle p-2 d-inline-flex align-items-center justify-content-center"
                        style="transition: transform 0.2s ease;" onmouseover="this.style.transform='scale(1.1)'"
                        onmouseout="this.style.transform='scale(1)'">
                        <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
                <div class="table-responsive px-3 mb-2">
                    <table class="table align-middle mb-0 table-hover">
                        <thead>
                            <tr style="background-color: #f8f9fa;">
                                <th class="border-0 py-3 text-dark" style="border-top-left-radius: 0.5rem;">Name</th>
                                <th class="border-0 py-3 text-dark">Email</th>
                                <th class="border-0 py-3 text-dark">Company Name</th>
                                <th class="border-0 py-3 text-dark" style="border-top-right-radius: 0.5rem;">Date Joined
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($recentCustomers as $customer)
                                <tr class="border-bottom" style="transition: all 0.3s ease;">
                                    <td class="py-3">
                                        <span class="fw-semibold">{{ $customer->first_name }}
                                            {{ $customer->last_name }}</span>
                                    </td>
                                    <td class="py-3">
                                        <span class="text-muted">{{ $customer->email }}</span>
                                    </td>
                                    <td class="py-3">
                                        <span class="text-muted">{{ $customer->company_name }}</span>
                                    </td>
                                    <td class="py-3">
                                        <span>{{ $customer->created_at->format('M d, Y') }}</span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-12">
                <div class="card border-0 rounded-lg bg-white"
                    style="transition: all 0.3s ease; box-shadow: 0 .5rem 1rem rgba(0,0,0,.15);"
                    onmouseover="this.style.boxShadow='0 1rem 3rem rgba(0,0,0,.175)'"
                    onmouseout="this.style.boxShadow='0 .5rem 1rem rgba(0,0,0,.15)'">
                    <div class="card-header border-0 bg-white">
                        <h5 class="mb-0 font-weight-bold text-primary">Yearly Orders</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="orderChart" height="100"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('orderChart').getContext('2d');

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: @json($months),
                    datasets: [{
                        label: 'Monthly Orders',
                        data: @json($monthlyOrderCounts),
                        borderColor: '#7367f0',
                        backgroundColor: 'rgba(64, 224, 208, 0.2)',
                        pointBackgroundColor: '#7367f0',
                        pointBorderColor: '#a19be5',
                        pointRadius: 5,
                        pointHoverRadius: 7,
                        borderWidth: 2,
                        tension: 0.4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: '#E5E5E5',
                                drawBorder: false
                            },
                            ticks: {
                                padding: 10
                            }
                        },
                        x: {
                            grid: {
                                color: '#E5E5E5',
                                drawBorder: false
                            },
                            ticks: {
                                padding: 10
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: false
                        }
                    }
                }
            });
        });
    </script>
@endsection
