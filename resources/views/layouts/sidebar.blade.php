<!-- Menu -->
<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="{{ route('admin.dashboard') }}" class="app-brand-link">
            <span class="app-brand-logo">
                <img src="{{ asset('/admin/assets/img/branding/Celergen-Logo.png') }}" alt="Girl in a jacket"
                    width="180" height="30">
            </span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
            <i class="align-middle ti menu-toggle-icon d-none d-xl-block"></i>
            <i class="align-middle ti ti-x d-block d-xl-none ti-md"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="py-1 menu-inner">
        <li class="menu-header small">
            <span class="menu-header-text" data-i18n="ADMIN DASHBOARD"> ADMIN DASHBOARD</span>
        </li>

        <!-- Masters -->
        <li
            class="menu-item {{ request()->routeIs('admin.suppliers*') || request()->routeIs('admin.warehouses*') || request()->routeIs('admin.customerstype*') || request()->routeIs('admin.currencycountry*') || request()->routeIs('admin.roles*') || request()->routeIs('admin.currency*') || request()->routeIs('admin.user*') || request()->routeIs('admin.batchnumber*') || request()->routeIs('admin.entities*') || request()->routeIs('admin.invoice*') ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons ti ti-smart-home"></i>
                <div data-i18n="Masters">Masters</div>
            </a>

            <!-- Entity -->
            <ul class="menu-sub">
                <li class="menu-item {{ request()->routeIs('admin.entities.*') ? 'active open' : '' }}">
                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                        <div data-i18n="Entity">Entity</div>
                    </a>
                    <ul class="menu-sub">
                        <li class="menu-item {{ request()->routeIs('admin.entities.index') ? 'active' : '' }}">
                            <a href="{{ route('admin.entities.index') }}" class="menu-link">
                                <div data-i18n="Entities List">Entities List</div>
                            </a>
                        </li>
                        <li class="menu-item {{ request()->routeIs('admin.entities.add') ? 'active' : '' }}">
                            <a href="{{ route('admin.entities.add') }}" class="menu-link">
                                <div data-i18n="Add Entity">Add Entity</div>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
            <!-- Entity End -->

            <!-- Suppliers -->
            {{--  <ul class="menu-sub">
                <li class="menu-item {{ request()->routeIs('admin.suppliers.*') ? 'active open' : '' }}">
                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                        <div data-i18n="Distributor">Distributor</div>
                    </a>
                    <ul class="menu-sub">
                        <li class="menu-item {{ request()->routeIs('admin.suppliers.index') ? 'active' : '' }}">
                            <a href="{{ route('admin.suppliers.index') }}" class="menu-link">
                                <div data-i18n="Distributor List">Distributor List</div>
                            </a>
                        </li>
                        <li class="menu-item {{ request()->routeIs('admin.suppliers.add') ? 'active' : '' }}">
                            <a href="{{ route('admin.suppliers.add') }}" class="menu-link">
                                <div data-i18n="Add Distributor">Add Distributor</div>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul> --}}
            <!-- Suppliers End -->

            <!-- Warehouses -->
            <ul class="menu-sub">
                <li class="menu-item {{ request()->routeIs('admin.warehouses.*') ? 'active open' : '' }}">
                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                        <div data-i18n="Warehouses">Warehouses</div>
                    </a>
                    <ul class="menu-sub">
                        <li class="menu-item {{ request()->routeIs('admin.warehouses.index') ? 'active' : '' }}">
                            <a href="{{ route('admin.warehouses.index') }}" class="menu-link">
                                <div data-i18n="Warehouses List">Warehouses List</div>
                            </a>
                        </li>
                        <li class="menu-item {{ request()->routeIs('admin.warehouses.add') ? 'active' : '' }}">
                            <a href="{{ route('admin.warehouses.add') }}" class="menu-link">
                                <div data-i18n="Add Warehouse">Add Warehouse</div>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
            <!-- Warehouses End -->

            <!-- Customer Type -->
            <ul class="menu-sub">
                <li class="menu-item {{ request()->routeIs('admin.customerstype.*') ? 'active open' : '' }}">
                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                        <div data-i18n="Customer Type">Customer Type</div>
                    </a>
                    <ul class="menu-sub">
                        <li class="menu-item {{ request()->routeIs('admin.customerstype.index') ? 'active' : '' }}">
                            <a href="{{ route('admin.customerstype.index') }}" class="menu-link">
                                <div data-i18n="Customer Type List">Customer Type List</div>
                            </a>
                        </li>
                        <li class="menu-item {{ request()->routeIs('admin.customerstype.add') ? 'active' : '' }}">
                            <a href="{{ route('admin.customerstype.add') }}" class="menu-link">
                                <div data-i18n="Add Customer Type">Add Customer Type</div>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
            <!-- Customer Type End -->

            <!-- Batch Number -->
            <ul class="menu-sub">
                <li class="menu-item {{ request()->routeIs('admin.batchnumber.*') ? 'active open' : '' }}">
                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                        <div data-i18n="Batch Number">Batch Number</div>
                    </a>
                    <ul class="menu-sub">
                        <li class="menu-item {{ request()->routeIs('admin.batchnumber.add') ? 'active' : '' }}">
                            <a href="{{ route('admin.batchnumber.add') }}" class="menu-link">
                                <div data-i18n="Add Batch Number">Add Batch Number</div>
                            </a>
                        </li>
                        <li class="menu-item {{ request()->routeIs('admin.batchnumber.index') ? 'active' : '' }}">
                            <a href="{{ route('admin.batchnumber.index') }}" class="menu-link">
                                <div data-i18n="Batch Number List">Batch Number List</div>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
            <!-- Batch Number End -->

            <!-- Currency and Country -->
            <ul class="menu-sub">
                <li class="menu-item {{ request()->routeIs('admin.currency.*') ? 'active open' : '' }}">
                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                        <div data-i18n="Currency">Currency</div>
                    </a>
                    <ul class="menu-sub">
                        <li class="menu-item {{ request()->routeIs('admin.currency.index') ? 'active' : '' }}">
                            <a href="{{ route('admin.currency.index') }}" class="menu-link">
                                <div data-i18n="Currency List">Currency List</div>
                            </a>
                        </li>
                        <li class="menu-item {{ request()->routeIs('admin.currency.add') ? 'active' : '' }}">
                            <a href="{{ route('admin.currency.add') }}" class="menu-link">
                                <div data-i18n="Add Currency">Add Currency</div>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
            <!-- Currency and Country End -->

            <!-- Admin Users -->
            <ul class="menu-sub">
                <li class="menu-item {{ request()->routeIs('admin.user.*') ? 'active open' : '' }}">
                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                        <div data-i18n="Admin Users">Admin Users</div>
                    </a>
                    <ul class="menu-sub">
                        <li class="menu-item {{ request()->routeIs('admin.user.index') ? 'active' : '' }}">
                            <a href="{{ route('admin.user.index') }}" class="menu-link">
                                <div data-i18n="Users List">Users List</div>
                            </a>
                        </li>
                        <li class="menu-item {{ request()->routeIs('admin.user.add') ? 'active' : '' }}">
                            <a href="{{ route('admin.user.add') }}" class="menu-link">
                                <div data-i18n="Add Users">Add Users</div>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
            <!-- Admin Users End -->
        </li>
        <!-- Masters End -->

        <!-- Sales Orders -->
        <li class="menu-item {{ request()->routeIs('admin.orders.*') ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons ti ti-shopping-cart"></i>
                <div data-i18n="Sales Orders">Sales Orders</div>
            </a>
            <ul class="menu-sub {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                <li class="menu-item {{ request()->routeIs('admin.orders.add') ? 'active' : '' }}">
                    <a href="{{ route('admin.orders.add') }}" class="menu-link">
                        <div data-i18n="Add Orders">Add Orders</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('admin.orders.index') ? 'active' : '' }}">
                    <a href="{{ route('admin.orders.index') }}" class="menu-link">
                        <div data-i18n="Orders List">Orders List</div>
                    </a>
                </li>
            </ul>
        </li>
        <!-- Sales Orders End -->


        <!-- Customers -->
        <li class="menu-item {{ request()->routeIs('admin.customer.*') ? 'active open' : '' }} ">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons ti ti-files"></i>
                <div data-i18n="Customers">Customers</div>
            </a>
            <ul class="menu-sub {{ request()->routeIs('admin.customer.*') ? 'active' : '' }}">
                <li class="menu-item {{ request()->routeIs('admin.customer.index') ? 'active' : '' }}">
                    <a href="{{ route('admin.customer.index') }}" class="menu-link">
                        <div data-i18n="Customers List">Customers List</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('admin.customer.add') ? 'active' : '' }}">
                    <a href="{{ route('admin.customer.add') }}" class="menu-link">
                        <div data-i18n="Add New Customer">Add New Customer</div>
                    </a>
                </li>
            </ul>
        </li>

        <!-- Customers End-->

        <!-- Invoice Management -->
        {{-- <li class="menu-item {{ request()->routeIs('admin.invoices.*') ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons ti ti-file-dollar"></i>
                <div data-i18n="Invoice Management">Invoice Management</div>
            </a>
            <ul class="menu-sub">
                <!-- <li class="menu-item">
                    <a href="../front-pages/landing-page.html" class="menu-link" target="_blank">
                        <div data-i18n="Online Invoices List">Online Invoices List</div>
                    </a>
                </li> -->
                <li class="menu-item {{ request()->routeIs('admin.invoices.index') ? 'active' : '' }}">
                    <a href="{{ route('admin.invoices.index') }}" class="menu-link" target="_blank">
                        <div data-i18n="Offline Invoices List">Offline Invoices List</div>
                    </a>
                </li>
                <!-- <li class="menu-item">
                    <a href="#" class="menu-link" target="_blank">
                        <div data-i18n="Shipping Invoice">Shipping Invoice</div>
                    </a>
                </li> -->
            </ul>
        </li> --}}
        <!-- Invoice Management End-->

        <!-- Product Management -->
        <li
            class="menu-item {{ request()->routeIs('admin.products*') || request()->routeIs('admin.productscategory*') ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons ti ti-cube"></i>
                <div data-i18n="Product Management">Product Management</div>
            </a>
            <ul class="menu-sub">
                <li
                    class="menu-item {{ request()->routeIs('admin.products.*') || request()->routeIs('admin.productscategory*') ? 'active open' : '' }}">
                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                        <div data-i18n="Products">Products</div>
                    </a>
                    <ul class="menu-sub">
                        <li class="menu-item {{ request()->routeIs('admin.products.add') ? 'active' : '' }}">
                            <a href="{{ route('admin.products.add') }}" class="menu-link">
                                <div data-i18n="Add Product">Add Product</div>
                            </a>
                        </li>
                        <li class="menu-item {{ request()->routeIs('admin.products.index') ? 'active' : '' }}">
                            <a href="{{ route('admin.products.index') }}" class="menu-link">
                                <div data-i18n="Products List">Products List</div>
                            </a>
                        </li>
                        <li class="menu-item {{ request()->routeIs('admin.productscategory.add') ? 'active' : '' }}">
                            <a href="{{ route('admin.productscategory.add') }}" class="menu-link">
                                <div data-i18n="Add Category">Add Category</div>
                            </a>
                        </li>
                        <li
                            class="menu-item {{ request()->routeIs('admin.productscategory.index') ? 'active' : '' }}">
                            <a href="{{ route('admin.productscategory.index') }}" class="menu-link">
                                <div data-i18n="Category List">Category List</div>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </li>
        <!-- Product Management End -->

        <!-- Inventory Management -->
        <li class="menu-item {{ request()->routeIs('admin.inventory*') ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons ti ti-file-dollar"></i>
                <div data-i18n="Inventory Management">Inventory Management</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ request()->routeIs('admin.inventory.add') ? 'active' : '' }}">
                    <a href="{{ route('admin.inventory.add') }}" class="menu-link">
                        <div data-i18n="Add Inventory">Add Inventory</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('admin.inventory.index') ? 'active' : '' }}">
                    <a href="{{ route('admin.inventory.index') }}" class="menu-link">
                        <div data-i18n="Inventory List">Inventory List</div>
                    </a>
                </li>
            </ul>
        </li>
        <!-- Inventory Management End -->

        <!-- Accounts and Billing -->
        <li class="menu-item {{ request()->routeIs('admin.debtors*') || request()->routeIs('admin.consignment*') ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons ti ti-file-dollar"></i>
                <div data-i18n="Accounts">Accounts</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ request()->routeIs('admin.debtors.index') ? 'active' : '' }}">
                    <a href="{{ route('admin.debtors.index') }}" class="menu-link">
                        <div data-i18n="Debtors List">Debtors List</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('admin.consignment.index') ? 'active' : '' }}">
                    <a href="{{ route('admin.consignment.index') }}" class="menu-link">
                        <div data-i18n="Consignment List">Consignment List</div>
                    </a>
                </li>
                <!-- <li class="menu-item {{ request()->routeIs('admin.debtors.manage') ? 'active' : '' }}">
                    <a href="#" class="menu-link">
                        <div data-i18n="Manage Debtors">Manage Debtors</div>
                    </a>
                </li> -->
            </ul>
        </li>
        <!-- Accounts and Billing End -->

        <!-- Users Dashboard -->
        <li
            class="menu-item {{ request()->routeIs('admin.roles.*') || request()->routeIs('admin.users.*') ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons ti ti-users"></i>
                <div data-i18n="Users">Users Dashboard</div>
            </a>
            <!-- Manage Roles / Permissions -->
            <ul class="menu-sub">
                <li class="menu-item {{ request()->routeIs('admin.roles.*') ? 'active open' : '' }}">
                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                        <div data-i18n="Manage Roles / Permissions">Manage Roles / Permissions</div>
                    </a>
                    <ul class="menu-sub">
                        <li class="menu-item {{ request()->routeIs('admin.roles.index') ? 'active' : '' }}">
                            <a href="{{ route('admin.roles.index') }}" class="menu-link">
                                <div data-i18n="Manage User Role">Manage User Role</div>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
            <!-- Manage Roles / Permissions End -->
        </li>

        <!-- Reports -->
        <li class="menu-item {{ request()->routeIs('admin.reports*') || request()->routeIs('admin.reports.index') || request()->routeIs('admin.consignment*') ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons ti ti-chart-pie"></i>
                <div data-i18n="Reports">Reports</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ request()->routeIs('admin.reports.index') ? 'active' : '' }}">
                    <a href="{{ route('admin.reports.index') }}" class="menu-link">
                        <div data-i18n="Custom Report">Custom Report</div>
                    </a>
                </li>
            </ul>
            <ul class="menu-sub">
                <li class="menu-item {{ request()->routeIs('admin.reports.ytd') ? 'active' : '' }}">
                    <a href="{{ route('admin.reports.ytd') }}" class="menu-link">
                        <div data-i18n="YTD Report">YTD Report</div>
                    </a>
                </li>
            </ul>
            <ul class="menu-sub">
                <li class="menu-item {{ request()->routeIs('admin.reports.business') ? 'active' : '' }}">
                    <a href="{{ route('admin.reports.business') }}" class="menu-link">
                        <div data-i18n="Business Report">Business Report</div>
                    </a>
                </li>
            </ul>
            <ul class="menu-sub">
                <li class="menu-item {{ request()->routeIs('admin.reports.country') ? 'active' : '' }}">
                    <a href="{{ route('admin.reports.country') }}" class="menu-link">
                        <div data-i18n="Country Report">Country Report</div>
                    </a>
                </li>
            </ul>
        </li>
    </ul>
</aside>
<!-- Menu End -->
