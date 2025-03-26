<div>
    <!-- Top Navigation -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="d-flex align-items-center top-navigation">
            <button wire:click="setTab('overview')"
                class="btn {{ $activeTab === 'overview' ? 'btn-primary' : 'btn-link text-dark' }}">
                Overview
            </button>
            <button wire:click="setTab('address')"
                class="btn {{ $activeTab === 'address' ? 'btn-primary' : 'btn-link text-dark' }}">
                Address & Billing
            </button>
            <button wire:click="setTab('invoices')"
                class="btn {{ $activeTab === 'invoices' ? 'btn-primary' : 'btn-link text-dark' }}">
                Old Invoices
            </button>

        </div>
    </div>

    <!-- Tab Contents -->
    @if ($activeTab === 'overview')
        <div class="tab-content p-0">
            <div class="card shadow-sm p-3 mb-4">
                <div class="table-responsive">
                    <h4 class="fw-bold fs-5 mb-4 ml-2">Orders Placed</h4>
                    <table class="table">
                        <thead>
                            <tr class="text-center">
                                <th>Order ID</th>
                                <th>Order Date</th>
                                <th>Total</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $order)
                                <tr class="text-center">
                                    <td>{{ $order->order_id }}</td>
                                    <td>{{ \Carbon\Carbon::parse($order->order_date)->format('Y-m-d') }}</td>
                                    <td>${{ number_format($order->total, 2) }}</td>
                                    <td>
                                        <span
                                            class="badge bg-label-{{ $order->order_status === 'Paid' ? 'success' : ($order->order_status === 'Pending' ? 'warning' : 'danger') }}">
                                            {{ ucfirst($order->order_status) }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="d-flex justify-content-end mt-3">
                        {{ $orders->links() }}
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if ($activeTab === 'address')
        <div class="tab-content p-0">
            <div class="card shadow-sm p-3 mb-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="ml-6 mb-0 fs-5">Address Book</h5>
                    {{-- <button class="btn btn-outline-primary btn-sm">Add new address</button> --}}
                </div>
                <div class="list-group list-group-flush">
                    <!-- Billing Address -->
                    <div class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <p class="mb-0"><strong>Billing Address</strong> <span
                                    class="badge bg-label-success ms-2">Default Address</span></p>
                            <p class="text-muted mb-0">{{ $customer->billing_address }}</p>
                            <p class="text-muted mb-0">{{ $customer->billing_country }},
                                {{ $customer->billing_postal_code }}</p>
                        </div>
                        <div>
                            <a href="{{ url('/admin/customer/add?id=' . $customer->id) }}"
                                class="btn btn-link p-0 me-2">
                                <i class="fas fa-edit"></i>
                            </a>
                            {{-- <button class="btn btn-link p-0"><i class="fas fa-trash-alt"></i></button> --}}
                        </div>
                    </div>
                    <!-- Shipping Addresses -->
                    @if ($customer->shipping_address_1)
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <p class="mb-0"><strong>Shipping Address 1</strong></p>
                                <p class="text-muted mb-0">{{ $customer->shipping_address_1 }}</p>
                                <p class="text-muted mb-0">{{ $customer->shipping_country_1 }},
                                    {{ $customer->shipping_postal_code_1 }}</p>
                            </div>
                            <div>
                                <a href="{{ url('/admin/customer/add?id=' . $customer->id) }}"
                                    class="btn btn-link p-0 me-2">
                                    <i class="fas fa-edit"></i>
                                </a>
                                {{-- <button class="btn btn-link p-0"><i class="fas fa-trash-alt"></i></button> --}}
                            </div>
                        </div>
                    @endif

                    @if ($customer->shipping_address_2)
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <p class="mb-0"><strong>Shipping Address 2</strong></p>
                                <p class="text-muted mb-0">{{ $customer->shipping_address_2 }}</p>
                                <p class="text-muted mb-0">{{ $customer->shipping_country_2 }},
                                    {{ $customer->shipping_postal_code_2 }}</p>
                            </div>
                            <div>
                                <a href="{{ url('/admin/customer/add?id=' . $customer->id) }}"
                                    class="btn btn-link p-0 me-2">
                                    <i class="fas fa-edit"></i>
                                </a>
                                {{-- <button class="btn btn-link p-0"><i class="fas fa-trash-alt"></i></button> --}}
                            </div>
                        </div>
                    @endif
                    @if ($customer->shipping_address_3)
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <p class="mb-0"><strong>Shipping Address 3</strong></p>
                                <p class="text-muted mb-0">{{ $customer->shipping_address_3 }}</p>
                                <p class="text-muted mb-0">{{ $customer->shipping_country_3 }},
                                    {{ $customer->shipping_postal_code_3 }}</p>
                            </div>
                            <div>
                                <a href="{{ url('/admin/customer/add?id=' . $customer->id) }}"
                                    class="btn btn-link p-0 me-2">
                                    <i class="fas fa-edit"></i>
                                </a>
                                {{-- <button class="btn btn-link p-0"><i class="fas fa-trash-alt"></i></button> --}}
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @endif

    @if ($activeTab === 'invoices')
        <div class="tab-content p-0">
            <div class="card shadow-sm p-3 mb-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="mb-0 fs-5 fw-bold">Invoice List</h5>

                    <div class="d-flex align-items-center">
                        <div wire:loading wire:target="invoiceFile" class="me-2">
                            <div class="spinner-border spinner-border-sm text-primary" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                            <span class="ms-2">Uploading...</span>
                        </div>

                        <div wire:loading.remove wire:target="invoiceFile" class="d-flex align-items-center">
                            <div class="me-3">
                                <input type="file" wire:model="invoiceFile" accept=".pdf"
                                    class="form-control form-control-sm" id="invoiceUpload" style="display: none;">
                                <label for="invoiceUpload" class="btn btn-sm btn-outline-primary mb-0">
                                    <i class="fas fa-file-upload me-1"></i> Select PDF
                                </label>
                                @if ($invoiceFile)
                                    <span
                                        class="ms-2 small text-muted">{{ $invoiceFile->getClientOriginalName() }}</span>
                                @endif
                                @error('invoiceFile')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>
                            <button wire:click="uploadInvoice" class="btn btn-sm btn-primary"
                                {{ !$invoiceFile ? 'disabled' : '' }}>
                                <i class="fas fa-cloud-upload-alt me-1"></i> Upload
                            </button>
                        </div>
                    </div>
                </div>

                @if (session()->has('message'))
                    <div class="alert alert-success alert-dismissible fade show mb-4">
                        {{ session('message') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <!-- Invoices Table -->
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th class="text-center" width="60">#</th>
                                <th>Date</th>
                                <th>Document</th>
                                <th class="text-end" width="120">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($invoices as $invoice)
                                <tr>
                                    <td class="text-center">{{ $invoice->serial }}</td>
                                    <td>
                                        @if ($invoice->invoice_date)
                                            {{ \Carbon\Carbon::parse($invoice->invoice_date)->format('M d, Y') }}
                                        @else
                                            <span class="text-muted">N/A</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-file-pdf text-danger me-2 fs-5"></i>
                                            <div>
                                                <div>{{ $invoice->original_filename }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex align-items-center justify-content-center gap-2">
                                    
                                            <div class="dropdown">
                                                <button class="btn btn-link text-black" type="button" id="actionMenu{{ $invoice->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="fa fa-ellipsis-v" style="font-size: 20px;"></i>
                                                </button>
                                    
                                                <ul class="dropdown-menu" aria-labelledby="actionMenu{{ $invoice->id }}">
                                                    <li>
                                                        <a class="dropdown-item" href="{{ url('storage/' . $invoice->file_path) }}" target="_blank" style="cursor: pointer;">
                                                            <i class="fas fa-eye text-info me-2"></i> View PDF
                                                        </a>
                                                    </li>
                                    
                                                    <li>
                                                        <a class="dropdown-item" wire:click="downloadInvoice({{ $invoice->id }})" style="cursor: pointer;">
                                                            <i class="fas fa-download text-primary me-2"></i> Download
                                                        </a>
                                                    </li>                                                    
                                    
                                                    <li>
                                                        <a class="dropdown-item text-danger" href="#" onclick="confirmDelete({{ $invoice->id }})" style="cursor: pointer;">
                                                            <i class="fas fa-trash-alt me-2"></i> Delete
                                                        </a>
                                                    </li>                                                    
                                                </ul>
                                            </div>
                                        </div>
                                    </td>                                                                      
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4">
                                        <div class="text-muted">
                                            <i class="fas fa-file-alt fa-2x mb-3"></i>
                                            <p class="mb-0">No invoices found</p>
                                            <small>Upload your first invoice using the button above</small>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <!-- Pagination -->
                    @if ($invoices->hasPages())
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <div class="text-muted small">
                               {{--  Showing {{ $invoices->firstItem() }} to {{ $invoices->lastItem() }} of
                                {{ $invoices->total() }} entries --}}
                            </div>
                            {{ $invoices->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @endif
    <script>
        function confirmDelete(invoiceId) {
            Swal.fire({
                title: 'Are you sure?',
                text: 'You will not be able to recover this invoice!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    @this.call('deleteInvoice', invoiceId);
                    Swal.fire(
                        'Deleted!',
                        'The invoice has been deleted.',
                        'success'
                    );
                }
            });
        }
    </script>  
</div>
