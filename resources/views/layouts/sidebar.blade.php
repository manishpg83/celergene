{{-- <!-- Sidebar -->
<div x-data="{ open: false }"
    class="flex h-full bg-white border-r transition-all duration-500 ease-in-out"
    :class="{ 'w-64': open, 'w-20': !open }"
    @mouseenter="open = true" @mouseleave="open = false"
    style="box-shadow: 0 .125rem .5rem 0 rgba(47, 43, 61, .12);">
    <div class="flex flex-col flex-1 overflow-y-auto">
        <!-- Sidebar Header (Logo) -->
        <div class="flex items-center justify-center h-16 bg-purple-600">
            <svg class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
            </svg>
        </div>
        <!-- Sidebar Links -->
        <nav class="flex-1 px-2 py-4 space-y-2">
            <!-- Dashboard -->
            <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-2 text-gray-700 hover:bg-purple-100 rounded-md">
                <svg class="h-6 w-6 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                <span class="ml-3" x-show="open">Dashboard</span>
            </a>
            <!-- Vendor -->
            <a href="{{ route('admin.vendors.index') }}" class="flex items-center px-4 py-2 text-gray-700 hover:bg-purple-100 rounded-md">
                <svg class="h-6 w-6 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M5 12h14M12 5v14" />
                </svg>
                <span class="ml-3" x-show="open">Vendors</span>
            </a>
            <!-- Entities -->
            <a href="{{ route('admin.entities.index') }}" class="flex items-center px-4 py-2 text-gray-700 hover:bg-purple-100 rounded-md">
                <svg class="h-6 w-6 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 7h18M3 11h18M5 3h14a2 2 0 012 2v14a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2z" />
                </svg>
                <span class="ml-3" x-show="open">Entities</span>
            </a>
            <!-- Customers -->
            <a href="{{ route('admin.customer.index') }}" class="flex items-center px-4 py-2 text-gray-700 hover:bg-purple-100 rounded-md">
                <svg class="h-6 w-6 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
                <span class="ml-3" x-show="open">Customers</span>
            </a>
        </nav>
    </div>
</div> --}}
 <!-- Menu -->
 <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
      <a href="{{ route('admin.dashboard') }}" class="app-brand-link">
        <span class="app-brand-logo">
          <img src="{{ asset('/admin/assets/img/branding/Celergen-Logo.png') }}" alt="Girl in a jacket" width="180" height="30">
        </span>
        <!--<span class="app-brand-text demo menu-text fw-bold">Vuexy</span>-->
      </a>

      <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
        <i class="ti menu-toggle-icon d-none d-xl-block align-middle"></i>
        <i class="ti ti-x d-block d-xl-none ti-md align-middle"></i>
      </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
      <li class="menu-header small">
        <span class="menu-header-text"  data-i18n="ADMIN DASHBOARD"> ADMIN DASHBOARD</span>
      </li>
      <!-- Masters -->
      <li class="menu-item active">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
          <i class="menu-icon tf-icons ti ti-smart-home"></i>
          <div data-i18n="Masters">Masters</div>
          <!--<div class="badge bg-danger rounded-pill ms-auto">5</div>-->
        </a>
        <!-- Entity -->
        <ul class="menu-sub">
          <li class="menu-item">
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
        <ul class="menu-sub">
          <li class="menu-item">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
              <div data-i18n="Suppliers">Suppliers</div>
            </a>
            <ul class="menu-sub">
              <li class="menu-item">
                <a href="#" class="menu-link">
                  <div data-i18n="Suppliers List">Suppliers List</div>
                </a>
              </li>
              <li class="menu-item">
                <a href="#" class="menu-link">
                  <div data-i18n="Add Supplier">Add Supplier</div>
                </a>
              </li>
            </ul>
          </li>
        </ul>
        <!-- Suppliers End -->
        <!-- Warehouses -->
        <ul class="menu-sub">
          <li class="menu-item">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
              <div data-i18n="Warehouses">Warehouses</div>
            </a>
            <ul class="menu-sub">
              <li class="menu-item">
                <a href="#" class="menu-link">
                  <div data-i18n="Warehouses List">Warehouses List</div>
                </a>
              </li>
              <li class="menu-item">
                <a href="#" class="menu-link">
                  <div data-i18n="Add Warehouse">Add Warehouse</div>
                </a>
              </li>
            </ul>
          </li>
        </ul>
        <!-- Warehouses End -->
        <!-- Customer Type -->
        <ul class="menu-sub">
          <li class="menu-item">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
              <div data-i18n="Customer Type">Customer Type</div>
            </a>
            <ul class="menu-sub">
              <li class="menu-item">
                <a href="{{ route('admin.customerstype.index') }}" class="menu-link">
                  <div data-i18n="Customer Type List">Customer Type List</div>
                </a>
              </li>
              <li class="menu-item">
                <a href="{{ route('admin.customerstype.add') }}" class="menu-link">
                  <div data-i18n="Add Customer Type">Add Customer Type</div>
                </a>
              </li>
            </ul>
          </li>
        </ul>
        <!-- Customer Type End -->
        <!-- Currency and Country -->
        <ul class="menu-sub">
          <li class="menu-item">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
              <div data-i18n="Currency and Country">Currency and Country</div>
            </a>
            <ul class="menu-sub">
              <li class="menu-item">
                <a href="#" class="menu-link">
                  <div data-i18n="Currency and Country List">Currency and Country List</div>
                </a>
              </li>
              <li class="menu-item">
                <a href="#" class="menu-link">
                  <div data-i18n="Add Currency and Country">Add Currency and Country</div>
                </a>
              </li>
            </ul>
          </li>
        </ul>
        <!-- Currency and Country End -->
        <!-- Manage Roles / Permissions -->
        <ul class="menu-sub">
          <li class="menu-item">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
              <div data-i18n="Manage Roles / Permissions">Manage Roles / Permissions</div>
            </a>
            <ul class="menu-sub">
              <li class="menu-item">
                <a href="#" class="menu-link">
                  <div data-i18n="Manage User Role">Manage User Role</div>
                </a>
              </li>
            </ul>
          </li>
        </ul>
        <!-- Manage Roles / Permissions End -->
        <!-- Admin Users -->
        <ul class="menu-sub">
          <li class="menu-item">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
              <div data-i18n="Admin Users">Admin Users</div>
            </a>
            <ul class="menu-sub">
              <li class="menu-item">
                <a href="{{ route('admin.vendors.index') }}" class="menu-link">
                  <div data-i18n="Users List">Users List</div>
                </a>
              </li>
              <li class="menu-item">
                <a href="#" class="menu-link">
                  <div data-i18n="Add Users">Add Users</div>
                </a>
              </li>
            </ul>
          </li>
        </ul>
      </li>
      <!-- Admin Users End -->
      <!-- Masters End -->
      <!-- Sales Orders -->
      <li class="menu-item">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
          <i class="menu-icon tf-icons ti ti-shopping-cart"></i>
          <div data-i18n="Sales Orders">Sales Orders</div>
        </a>
        <ul class="menu-sub">
          <li class="menu-item">
            <a href="javascript:void(0);" class="menu-link">
              <div data-i18n="Orders">Orders</div>
            </a>
          <li class="menu-item">
            <a href="app-ecommerce-product-list.html" class="menu-link">
              <div data-i18n="Orders List">Orders List</div>
            </a>
          </li>
      </li>
    </ul>
    </li>
    <!-- Sales Orders End -->

    <!-- Customers -->
    <li class="menu-item">
      <a href="javascript:void(0);" class="menu-link menu-toggle">
        <i class="menu-icon tf-icons ti ti-files"></i>
        <div data-i18n="Customers">Customers</div>
      </a>
      <ul class="menu-sub">
        <li class="menu-item">
          <a href="{{ route('admin.customer.index') }}" class="menu-link">
            <div data-i18n="Customers List">Customers List</div>
          </a>
        </li>
        <li class="menu-item">
          <a href="{{ route('admin.customer.add') }}" class="menu-link">
            <div data-i18n="Add New Customer">Add New Customer</div>
          </a>
        </li>
      </ul>
    </li>
    <!-- Customers End-->
    <!-- Invoice Management -->
    <li class="menu-item">
      <a href="javascript:void(0);" class="menu-link menu-toggle">
        <i class="menu-icon tf-icons ti ti-file-dollar"></i>
        <div data-i18n="Invoice Management">Invoice Managerment</div>
      </a>
      <ul class="menu-sub">
        <li class="menu-item">
          <a href="../front-pages/landing-page.html" class="menu-link" target="_blank">
            <div data-i18n="Online Invoices List">Online Invoices List</div>
          </a>
        </li>
        <li class="menu-item">
          <a href="../front-pages/pricing-page.html" class="menu-link" target="_blank">
            <div data-i18n="Offline Invoices List">Offline Invoices List</div>
          </a>
        </li>
        <li class="menu-item">
          <a href="../front-pages/pricing-page.html" class="menu-link" target="_blank">
            <div data-i18n="Custom Invoice">Custom Invoice</div>
          </a>
        </li>
      </ul>
    </li>
    <!-- Invoice Management End-->
    <!-- Product Management -->
    <li class="menu-item">
      <a href="javascript:void(0);" class="menu-link menu-toggle">
        <i class="menu-icon tf-icons ti ti-shopping-cart"></i>
        <div data-i18n="Product Management">Product Management</div>
      </a>
      <ul class="menu-sub">
        <li class="menu-item">
          <a href="javascript:void(0);" class="menu-link menu-toggle">
            <div data-i18n="Products">Products</div>
          </a>
          <ul class="menu-sub">
            <li class="menu-item">
              <a href="app-ecommerce-product-list.html" class="menu-link">
                <div data-i18n="Products List">Products List</div>
              </a>
            </li>
            <li class="menu-item">
              <a href="app-ecommerce-product-list.html" class="menu-link">
                <div data-i18n="Category List">Category List</div>
              </a>
            </li>
            <li class="menu-item">
              <a href="app-ecommerce-product-list.html" class="menu-link">
                <div data-i18n="Add Product">Add Product</div>
              </a>
            </li>
          </ul>
        </li>
      </ul>
      <ul class="menu-sub">
        <li class="menu-item">
          <a href="javascript:void(0);" class="menu-link menu-toggle">
            <div data-i18n="Settings">Settings</div>
          </a>
          <ul class="menu-sub">
            <li class="menu-item">
              <a href="app-ecommerce-product-list.html" class="menu-link">
                <div data-i18n="Store Details">Store Details</div>
              </a>
            </li>
            <li class="menu-item">
              <a href="app-ecommerce-product-list.html" class="menu-link">
                <div data-i18n="Payments">Payments</div>
              </a>
            </li>
            <li class="menu-item">
              <a href="app-ecommerce-product-list.html" class="menu-link">
                <div data-i18n="Checkout">Checkout</div>
              </a>
            </li>
            <li class="menu-item">
              <a href="app-ecommerce-product-list.html" class="menu-link">
                <div data-i18n="Shipping & Delivery">Shipping &bsp; Delivery</div>
              </a>
            </li>
            <li class="menu-item">
              <a href="app-ecommerce-product-list.html" class="menu-link">
                <div data-i18n="Locations">Locations</div>
              </a>
            </li>
            <li class="menu-item">
              <a href="app-ecommerce-product-list.html" class="menu-link">
                <div data-i18n="Notifications">Notifications</div>
              </a>
            </li>
          </ul>
        </li>
      </ul>
    </li>
    <!-- Product Management End -->
    <!-- Inventory Management -->
    <li class="menu-item">
      <a href="javascript:void(0);" class="menu-link menu-toggle">
        <i class="menu-icon tf-icons ti ti-file-dollar"></i>
        <div data-i18n="Inventory Management">Inventory Management</div>
      </a>
      <ul class="menu-sub">
        <li class="menu-item">
          <a href="#" class="menu-link">
            <div data-i18n="Online Invoices List">Inventory List</div>
          </a>
        </li>
        <li class="menu-item">
          <a href="#" class="menu-link">
            <div data-i18n="Offline Invoices List">Offline Invoices List</div>
          </a>
        </li>
        <li class="menu-item">
          <a href="#" class="menu-link">
            <div data-i18n="Custom Invoice">Custom Invoice</div>
          </a>
        </li>
        <li class="menu-item">
          <a href="#" class="menu-link">
            <div data-i18n="Shipping Invoice">Shipping Invoice</div>
          </a>
        </li>

      </ul>
    </li>
    <!-- Inventory Management End -->
    <!-- Accounts and Billing -->
    <li class="menu-item">
      <a href="javascript:void(0);" class="menu-link menu-toggle">
        <i class="menu-icon tf-icons ti ti-file-dollar"></i>
        <div data-i18n="Accounts">Accounts</div>
      </a>
      <ul class="menu-sub">
        <li class="menu-item">
          <a href="#" class="menu-link">
            <div data-i18n="Debtors List">Debtors List</div>
          </a>
        </li>
        <li class="menu-item">
          <a href="#" class="menu-link">
            <div data-i18n="Manage Debtors">Manage Debtors</div>
          </a>
        </li>


      </ul>
    </li>
    <!-- Accounts and Billing End -->
    <!-- Shipping -->
    <li class="menu-item">
      <a href="javascript:void(0);" class="menu-link menu-toggle">
        <i class="menu-icon tf-icons ti ti-truck"></i>
        <div data-i18n="Shipping">Shipping</div>
      </a>
      <ul class="menu-sub">
        <li class="menu-item">
          <a href="#" class="menu-link">
            <div data-i18n="Shipping Fee">Shipping Fee</div>
          </a>
        </li>
        <li class="menu-item">
          <a href="#" class="menu-link">
            <div data-i18n="Courier Airway Bill">Courier Airway Bill</div>
          </a>
        </li>
        <li class="menu-item">
          <a href="#" class="menu-link">
            <div data-i18n="Frieght">Frieght Charges</div>
          </a>
        </li>
      </ul>
    </li>
    <!-- Shipping End -->
    <li class="menu-item">
      <a href="javascript:void(0);" class="menu-link menu-toggle">
        <i class="menu-icon tf-icons ti ti-users"></i>
        <div data-i18n="Users">Users Dashboard</div>
      </a>
      <ul class="menu-sub">
        <li class="menu-item">
          <a href="#" class="menu-link">
            <div data-i18n="User Settings">User Settings</div>
          </a>
        </li>

        <li class="menu-item">
          <a href="javascript:void(0);" class="menu-link menu-toggle">
            <div data-i18n="View">View</div>
          </a>
          <ul class="menu-sub">
            <li class="menu-item">
              <a href="#" class="menu-link">
                <div data-i18n="Account">Account</div>
              </a>
            </li>
            <li class="menu-item">
              <a href="#" class="menu-link">
                <div data-i18n="Security">Security</div>
              </a>
            </li>
            <li class="menu-item">
              <a href="#" class="menu-link">
                <div data-i18n="Billing & Plans">Billing &nbsb; Plans</div>
              </a>
            </li>
            <li class="menu-item">
              <a href="#" class="menu-link">
                <div data-i18n="Notifications">Notifications</div>
              </a>
            </li>
            <li class="menu-item">
              <a href="#" class="menu-link">
                <div data-i18n="Connections">Connections</div>
              </a>
            </li>
          </ul>
        </li>
      </ul>
    </li>
    <!-- Content Management -->
    <li class="menu-item">
      <a href="javascript:void(0);" class="menu-link menu-toggle">
        <i class="menu-icon tf-icons ti ti-file"></i>
        <div data-i18n="Content Management">Content Management</div>
      </a>
      <ul class="menu-sub">
        <li class="menu-item">
          <a href="javascript:void(0);" class="menu-link menu-toggle">
            <div data-i18n="Rages">Pages</div>
          </a>
          <ul class="menu-sub">
            <li class="menu-item">
              <a href="#" class="menu-link">
                <div data-i18n="Home">Home</div>
              </a>
            </li>
            <li class="menu-item">
              <a href="#" class="menu-link">
                <div data-i18n="Home Slider">Home Slider</div>
              </a>
            </li>
            <li class="menu-item">
              <a href="#" class="menu-link">
                <div data-i18n="Footer">Footer</div>
              </a>
            </li>

            <li class="menu-item">
              <a href="#" class="menu-link">
                <div data-i18n="Contact page">Contact Page</div>
              </a>
            </li>
            <li class="menu-item">
              <a href="#" class="menu-link">
                <div data-i18n="Contact form Entries">Contact Form Entries</div>
              </a>
            </li>
            <li class="menu-item">
              <a href="#" class="menu-link">
                <div data-i18n="Media Library">Media Library</div>
              </a>
            </li>

            <li class="menu-item">
              <a href="#" class="menu-link">
                <div data-i18n="PDFs">PDFs</div>
              </a>
            </li>

            <li class="menu-item">
              <a href="#" class="menu-link">
                <div data-i18n="Social Media">Social Media</div>
              </a>
            </li>
          </ul>
        </li>
        <!-- Blog Management -->
        <li class="menu-item">
          <a href="javascript:void(0);" class="menu-link menu-toggle">
            <div data-i18n="Blogs Management">Blogs Management</div>
          </a>
          <ul class="menu-sub">
            <li class="menu-item">
              <a href="#" class="menu-link">
                <div data-i18n="Blogs List">Blogs List</div>
              </a>
            </li>
            <li class="menu-item">
              <a href="#" class="menu-link">
                <div data-i18n="Add New Blog">Add New Blog</div>
              </a>
            </li>
            <li class="menu-item">
              <a href="#" class="menu-link">
                <div data-i18n="Blog Category">Blog Category</div>
              </a>
            </li>
          </ul>
        </li>
      </ul>
    </li>
    <!-- Reports -->
    <li class="menu-item">
      <a href="javascript:void(0);" class="menu-link menu-toggle">
        <i class="menu-icon tf-icons ti ti-chart-pie"></i>
        <div data-i18n="Sales Reports">Sales Reports</div>
      </a>
      <ul class="menu-sub">
        <li class="menu-item">
          <a href="#" class="menu-link">
            <div data-i18n="Custom Report">Custom Report</div>
          </a>
        </li>
      </ul>
    </li>
    <!-- Settings -->
    <li class="menu-item">
      <a href="javascript:void(0);" class="menu-link menu-toggle">
        <i class="menu-icon tf-icons ti ti-settings"></i>
        <div data-i18n="Settings">Settings</div>
      </a>
      <ul class="menu-sub">
        <li class="menu-item">
          <a href="#" class="menu-link">
            <div data-i18n="SMTP">SMTP Settings</div>
          </a>
        </li>
        <li class="menu-item">
          <a href="#" class="menu-link">
            <div data-i18n="Email Settings">Email Settings</div>
          </a>
        </li>
        <li class="menu-item">
          <a href="#" class="menu-link">
            <div data-i18n="Notification Settings">Notification Settings</div>
          </a>
        </li>
        <li class="menu-item">
          <a href="#" class="menu-link">
            <div data-i18n="SMTP">Language Settings</div>
          </a>
        </li>
        <li class="menu-item">
          <a href="#" class="menu-link">
            <div data-i18n="Server Settings">Server Settings</div>
          </a>
        </li>
        <li class="menu-item">
          <a href="#" class="menu-link">
            <div data-i18n="Security Settings">Security Settings</div>
          </a>
        </li>
      </ul>
    </li>
    </ul>
  </aside>
  <!-- Menu End -->
