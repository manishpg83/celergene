<div>
    <!-- Top Navigation -->
    <div class="mb-4 d-flex justify-content-between align-items-center">
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
        <div class="p-0 tab-content">
            <div class="p-3 mb-4 shadow-sm card">
                <div class="table-responsive">
                    <h4 class="mb-4 ml-2 fw-bold fs-5">Orders Placed</h4>
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

                    <div class="mt-3 d-flex justify-content-end">
                        {{ $orders->links() }}
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if ($activeTab === 'address')
        <div class="p-0 tab-content">
            <div class="p-3 mb-4 shadow-sm card">
                <div class="mb-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 ml-6 fs-5">Address Book</h5>
                    {{-- <button class="btn btn-outline-primary btn-sm">Add new address</button> --}}
                </div>
                <div class="list-group list-group-flush">
                    <!-- Billing Address -->
                    <div class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <p class="mb-0"><strong>Billing Address</strong> <span
                                    class="badge bg-label-success ms-2">Default Address</span></p>
                            <p class="mb-0 text-muted">{{ $customer->billing_address }}</p>
                            <p class="mb-0 text-muted">{{ $customer->billing_country }},
                                {{ $customer->billing_postal_code }}</p>
                        </div>
                        <div>
                            <a href="{{ url('/admin/customer/add?id=' . $customer->id) }}"
                                class="p-0 btn btn-link me-2">
                                <i class="fas fa-edit"></i>
                            </a>
                            {{-- <button class="p-0 btn btn-link"><i class="fas fa-trash-alt"></i></button> --}}
                        </div>
                    </div>
                    <!-- Shipping Addresses -->
                    @if ($customer->shipping_address_1)
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <p class="mb-0"><strong>Shipping Address 1</strong></p>
                                <p class="mb-0 text-muted">{{ $customer->shipping_address_1 }}</p>
                                <p class="mb-0 text-muted">{{ $customer->shipping_country_1 }},
                                    {{ $customer->shipping_postal_code_1 }}</p>
                            </div>
                            <div>
                                <a href="{{ url('/admin/customer/add?id=' . $customer->id) }}"
                                    class="p-0 btn btn-link me-2">
                                    <i class="fas fa-edit"></i>
                                </a>
                                {{-- <button class="p-0 btn btn-link"><i class="fas fa-trash-alt"></i></button> --}}
                            </div>
                        </div>
                    @endif

                    @if ($customer->shipping_address_2)
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <p class="mb-0"><strong>Shipping Address 2</strong></p>
                                <p class="mb-0 text-muted">{{ $customer->shipping_address_2 }}</p>
                                <p class="mb-0 text-muted">{{ $customer->shipping_country_2 }},
                                    {{ $customer->shipping_postal_code_2 }}</p>
                            </div>
                            <div>
                                <a href="{{ url('/admin/customer/add?id=' . $customer->id) }}"
                                    class="p-0 btn btn-link me-2">
                                    <i class="fas fa-edit"></i>
                                </a>
                                {{-- <button class="p-0 btn btn-link"><i class="fas fa-trash-alt"></i></button> --}}
                            </div>
                        </div>
                    @endif
                    @if ($customer->shipping_address_3)
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <p class="mb-0"><strong>Shipping Address 3</strong></p>
                                <p class="mb-0 text-muted">{{ $customer->shipping_address_3 }}</p>
                                <p class="mb-0 text-muted">{{ $customer->shipping_country_3 }},
                                    {{ $customer->shipping_postal_code_3 }}</p>
                            </div>
                            <div>
                                <a href="{{ url('/admin/customer/add?id=' . $customer->id) }}"
                                    class="p-0 btn btn-link me-2">
                                    <i class="fas fa-edit"></i>
                                </a>
                                {{-- <button class="p-0 btn btn-link"><i class="fas fa-trash-alt"></i></button> --}}
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @endif

    @if ($activeTab === 'invoices')
        <div class="p-0 tab-content">
            <div class="p-3 mb-4 shadow-sm card">
                <div class="mb-4 d-flex justify-content-between align-items-center">
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
                                <label for="invoiceUpload" class="mb-0 btn btn-sm btn-outline-primary">
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
                    <div class="mb-4 alert alert-success alert-dismissible fade show">
                        {{ session('message') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <!-- Invoices Table -->
                <div class="mb-3 row">
                    <div class="col-md-3">
                        <input wire:model.live="search" type="text" class="form-control" placeholder="Search by document name or invoice number">
                    </div>

                    <div class="col-md-3">
                        <input wire:model.lazy="dateFrom" type="date" class="form-control" placeholder="From Date">
                    </div>

                    <div class="col-md-3">
                        <input wire:model.lazy="dateTo" type="date" class="form-control" placeholder="To Date">
                    </div>

                    <div class="col-md-3 text-end">
                        <button wire:click="resetFilters" class="btn btn-secondary">Reset Filters</button>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table align-middle table-hover">
                        <thead class="table-light">
                            <tr>
                                <th class="text-center" width="60">#</th>
                                <th>Invoices</th>
                                <th class="text-end" width="120">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($invoices as $invoice)
                                <tr>
                                    <td class="text-center">{{ $invoice->serial }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-file-pdf text-danger me-2 fs-5"></i>
                                            <div>
                                                <div>{{ $invoice->original_filename }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="gap-2 d-flex align-items-center justify-content-center">

                                            <div class="dropdown">
                                                <button class="text-black btn btn-link" type="button" id="actionMenu{{ $invoice->id }}" data-bs-toggle="dropdown" aria-expanded="false">
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
                                    <td colspan="3" class="py-4 text-center">
                                        <div class="text-muted">
                                            <i class="mb-3 fas fa-file-alt fa-2x"></i>
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
                        <div class="mt-3 d-flex justify-content-between align-items-center">
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
