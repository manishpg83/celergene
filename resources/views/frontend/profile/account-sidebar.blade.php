<aside class="col-xl-3">
    <div class="toggle-info">
        <h5 class="title mb-0">Account Navbar</h5>
        <a class="toggle-btn" href="#accountSidebar">Account Menu</a>
    </div>
    <div class="sticky-top account-sidebar-wrapper">
        <div class="account-sidebar" id="accountSidebar">
            <div class="profile-head">
                <div class="user-thumb">
                    <img class="rounded-circle" src="images/profile4.jpg" alt="Susan Gardner">
                </div>
                <h5 class="title mb-0">Ronald M. Spino</h5>
                <span class="text text-primary">info@example.com</span>
            </div>
            <div class="account-nav">
                <div class="nav-title bg-light">DASHBOARD</div>
                <ul>
                    <li><a href="{{ route('myaccount') }}">Dashboard</a></li>
                    <li><a href="{{ route('myorders') }}">Orders</a></li>
                </ul>
                <div class="nav-title bg-light">ACCOUNT SETTINGS</div>
                <ul class="account-info-list">
                    <li><a href="{{ route('myprofile') }}">Profile</a></li>
                    <li><a href="{{ route('billingaddress') }}">Billing Address</a></li>
                    <li><a href="{{ route('shippingaddress') }}">Shipping Address</a></li>
                    <li><a href="#">Shipping methods</a></li>
                    <li><a href="#">Payment Methods</a></li>
                    <li><a href="#">Review</a></li>
                </ul>
            </div>
        </div>
    </div>
</aside>