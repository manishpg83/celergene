<!DOCTYPE html>

<html lang="en" class="light-style layout-wide customizer-hide" dir="ltr" data-theme="theme-default"
    data-assets-path="{{ asset('/admin/assets/') }}" data-template="vertical-menu-template" data-style="light">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>{{ isset($pageTitle) ? $pageTitle . ' —' : '' }} {{ isset($siteTitle) ? $siteTitle : 'Celergen' }}
    </title>
    <meta name="description" content="Celergen" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('/admin/assets/img/favicon/favicon.ico') }}" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&ampdisplay=swap"
        rel="stylesheet" />

    <!-- Icons -->
    <link rel="stylesheet" href="{{ asset('/admin/assets/vendor/fonts/fontawesome.css') }}" />
    <link rel="stylesheet" href="{{ asset('/admin/assets/vendor/fonts/tabler-icons.css') }}" />
    <link rel="stylesheet" href="{{ asset('/admin/assets/vendor/fonts/flag-icons.css') }}" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ asset('/admin/assets/vendor/css/rtl/core.css') }}"
        class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{ asset('/admin/assets/vendor/css/rtl/theme-default.css') }}"
        class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{ asset('/admin/assets/css/demo.css') }}" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{ asset('/admin/assets/vendor/libs/node-waves/node-waves.css') }}" />
    <link rel="stylesheet" href="{{ asset('/admin/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />
    <link rel="stylesheet" href="{{ asset('/admin/assets/vendor/libs/typeahead-js/typeahead.css') }}" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{ asset('/admin/assets/vendor/libs/select2/select2.css') }}" />
    <link rel="stylesheet" href="{{ asset('/admin/assets/vendor/libs/@form-validation/form-validation.css') }}" />
    <link rel="stylesheet" href="{{ asset('/admin/assets/vendor/libs/animate-css/animate.css') }}" />
    <link rel="stylesheet" href="{{ asset('/admin/assets/vendor/libs/sweetalert2/sweetalert2.css') }}" />

    <!-- Page CSS -->
    <link rel="stylesheet" href="{{ asset('/admin/assets/vendor/css/pages/page-auth.css') }}" />

    <!-- Helpers -->
    <script src="{{ asset('/admin/assets/vendor/js/helpers.js') }}"></script>
    <script src="{{ asset('/admin/assets/vendor/js/template-customizer.js') }}"></script>
    <script src="{{ asset('/admin/assets/js/config.js') }}"></script>
    <script src="{{ asset('/admin/assets/js/pages-account-settings-account.js') }}"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>

<body>
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <!-- Menu -->
            @include('layouts.sidebar')
            <!-- Menu End -->

            <!-- Layout container -->
            <div class="layout-page">
                <!-- Navbar -->
                @include('layouts.navbar')
                <!-- / Navbar -->

                <!-- Content wrapper -->
                <div class="content-wrapper">
                    <!-- Content -->
                    @yield('content')
                    <!-- / Content -->

                    <!-- Footer -->
                    @include('layouts.footer')
                    <!-- / Footer -->

                    <div class="content-backdrop fade"></div>
                </div>
                <!-- Content wrapper -->
            </div>
            <!-- / Layout page -->
        </div>

        <!-- Overlay -->
        <div class="layout-overlay layout-menu-toggle"></div>

        <!-- Drag Target Area To SlideIn Menu On Small Screens -->
        <div class="drag-target"></div>
    </div>
    @livewireScripts
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('/admin/assets/vendor/libs/jquery/jquery.js') }}"></script>
    <script src="{{ asset('/admin/assets/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ asset('/admin/assets/vendor/js/bootstrap.js') }}"></script>
    <script src="{{ asset('/admin/assets/vendor/libs/node-waves/node-waves.js') }}"></script>
    <script src="{{ asset('/admin/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('/admin/assets/vendor/libs/hammer/hammer.js') }}"></script>
    <script src="{{ asset('/admin/assets/vendor/libs/i18n/i18n.js') }}"></script>
    <script src="{{ asset('/admin/assets/vendor/libs/typeahead-js/typeahead.js') }}"></script>
    <script src="{{ asset('/admin/assets/vendor/js/menu.js') }}"></script>

    <!-- Vendors JS -->
    <script src="{{ asset('/admin/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>
    <!-- Vendors JS -->
    <script src="{{ asset('/admin/assets/vendor/libs/select2/select2.js') }}"></script>
    <script src="{{ asset('/admin/assets/vendor/libs/@form-validation/popular.js') }}"></script>
    <script src="{{ asset('/admin/assets/vendor/libs/@form-validation/bootstrap5.js') }}"></script>
    <script src="{{ asset('/admin/assets/vendor/libs/@form-validation/auto-focus.js') }}"></script>
    <script src="{{ asset('/admin/assets/vendor/libs/cleavejs/cleave.js') }}"></script>
    <script src="{{ asset('/admin/assets/vendor/libs/cleavejs/cleave-phone.js') }}"></script>
    <script src="{{ asset('/admin/assets/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>

    <!-- Main JS -->
    <script src="{{ asset('/admin/assets/js/main.js') }}"></script>

    <!-- Page JS -->
    <script src="{{ asset('/admin/assets/js/app-ecommerce-order-list.js') }}"></script>

    <script>
        $(document).ready(function() {
            $('#sameAsBilling').change(function() {
                if ($(this).is(':checked')) {
                    let billingAddress = $('#billing_address').val();
                    let billingCountry = $('#billing_country').val();
                    let billingPostalCode = $('#billing_postal_code').val();
    
                    $('#shipping_address_receiver_name_1').val($('#first_name').val() + ' ' + $('#last_name').val());
                    $('#shipping_address_1').val(billingAddress);
                    $('#shipping_country_1').val(billingCountry);
                    $('#shipping_postal_code_1').val(billingPostalCode);
                } else {
                    $('#shipping_address_receiver_name_1').val('');
                    $('#shipping_address_1').val('');
                    $('#shipping_country_1').val('');
                    $('#shipping_postal_code_1').val('');
                }
            });
        });
    </script>
</body>

</html>
