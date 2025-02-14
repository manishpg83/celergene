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
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&ampdisplay=swap"
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

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Page CSS -->
    <link rel="stylesheet" href="{{ asset('/admin/assets/vendor/css/pages/page-auth.css') }}" />

    <!-- Helpers -->
    <script src="{{ asset('/admin/assets/vendor/js/helpers.js') }}"></script>
    <script src="{{ asset('/admin/assets/vendor/js/template-customizer.js') }}"></script>
    <script src="{{ asset('/admin/assets/js/config.js') }}"></script>
    <script src="{{ asset('/admin/assets/js/pages-account-settings-account.js') }}"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    @stack('styles')
    <style>
        .main-body {
            font-family: Arial !important;
        }

        .mt-8 {
            margin-top: 8rem !important;
        }
    </style>
</head>

<body class="main-body">
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            @can('view dashboard')
                @include('layouts.sidebar')
            @endcan
            <div class="layout-page">
                @can('view dashboard')
                    @include('layouts.navbar')
                @endcan
                <div class="content-wrapper">
                    @yield('content')

                    @include('layouts.footer')

                    <div class="content-backdrop fade"></div>
                </div>
            </div>
        </div>
        <div class="layout-overlay layout-menu-toggle"></div>
        <div class="drag-target"></div>
    </div>
    @yield('scripts')
    @livewireScripts
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
    <script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

    <script>
        Livewire.on('openEditTab', url => {
            console.log('test');
            window.open(url, '_blank'); // Opens edit page in new tab
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#sameAsBilling').change(function() {
                if ($(this).is(':checked')) {
                    let billingAddress = $('#billing_address').val();
                    let billingCountry = $('#billing_country').val();
                    let billingPostalCode = $('#billing_postal_code').val();

                    $('#shipping_address_receiver_name_1').val($('#first_name').val() + ' ' + $(
                        '#last_name').val());
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
    <script>
        document.addEventListener('livewire:load', function() {
            const modal = new bootstrap.Modal(document.getElementById('editOrderDateModal'));

            Livewire.on('closeModal', () => {
                modal.hide();
            });

            Livewire.hook('message.processed', (message, component) => {
                if (component.get('isEditingOrderDate')) {
                    modal.show();
                } else {
                    modal.hide();
                }
            });
        });

        document.addEventListener('livewire:load', function() {
            const orderDateModal = new bootstrap.Modal(document.getElementById('editOrderDateModal'));
            const invoiceDateModal = new bootstrap.Modal(document.getElementById('editInvoiceDateModal'));

            Livewire.on('closeModal', () => {
                orderDateModal.hide();
                invoiceDateModal.hide();
            });

            Livewire.hook('message.processed', (message, component) => {
                if (component.get('isEditingOrderDate')) {
                    orderDateModal.show();
                } else if (component.get('isEditingInvoiceDate')) {
                    invoiceDateModal.show();
                } else {
                    orderDateModal.hide();
                    invoiceDateModal.hide();
                }
            });
        });
    </script>
</body>

</html>
