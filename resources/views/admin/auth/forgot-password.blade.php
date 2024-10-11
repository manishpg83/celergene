<!doctype html>

<html lang="en" class="light-style layout-wide customizer-hide" dir="ltr" data-theme="theme-default"
    data-assets-path="assets/" data-template="vertical-menu-template" data-style="light">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>Login Basic | Celergen Swiss</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('admin/assets/img/favicon/favicon.ico') }}" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&ampdisplay=swap"
        rel="stylesheet" />

    <!-- Icons -->
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/fonts/fontawesome.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/fonts/tabler-icons.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/fonts/flag-icons.css') }}" />

    <!-- Core CSS -->

    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/css/rtl/core.css') }}"
        class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/css/rtl/theme-default.css') }}"
        class="template-customizer-theme-css" />

    <link rel="stylesheet" href="{{ asset('admin/assets/css/demo.css') }}" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/node-waves/node-waves.css') }}" />

    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/libs/typeahead-js/typeahead.css') }}" />
    <!-- Vendor -->


    <!-- Page CSS -->
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/css/pages/page-auth.css') }}" />

    <!-- Helpers -->
    <script src="{{ asset('admin/assets/vendor/js/helpers.js') }}"></script>

    <script src="{{ asset('admin/assets/vendor/js/template-customizer.js') }}"></script>

    <script src="{{ asset('admin/assets/js/config.js') }}"></script>

    @livewireStyles
</head>

<body>

    <!-- Content -->
    <div class="container-xxl">
        <div class="authentication-wrapper authentication-basic container-p-y">
            <div class="authentication-inner py-6">
                <div class="card">
                    <div class="card-body">
                        <div class="app-brand justify-content-center mb-6">
                            <a href="index.html" class="app-brand-link">
                                <span class="app-brand-text demo text-heading fw-bold"></span><img
                                    src="{{ asset('admin/assets/img/branding/Celergen-Logo.png') }}"
                                    alt="Celergen Swiss" width="auto" height="40">
                            </a>
                        </div>
                        <h4 class="mb-1">Welcome to Celergen Swiss! 👋</h4>
                        <p class="mb-6">Please sign-in to your account and start the adventure</p>

                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        @if ($errors->has('email'))
                            <div class="alert alert-danger">
                                {{ $errors->first('email') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('admin.password.email') }}" id="passwordResetForm"
                            onsubmit="showLoader()">
                            @csrf
                            <div class="mb-6">
                                <label for="email" class="form-label">Email</label>
                                <input type="text" class="form-control" id="email" name="email"
                                    placeholder="Enter your email or username" autofocus required />
                            </div>
                            <div class="mb-6">
                                <button class="btn btn-primary d-grid w-100" type="submit" id="submitBtn">Send Password
                                    Reset Link</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- / Content -->

        <!-- Core JS -->
        <!-- build:js assets/vendor/js/core.js -->

        <script src="{{ asset('admin/assets/vendor/libs/jquery/jquery.js') }}"></script>
        <script src="{{ asset('admin/assets/vendor/libs/popper/popper.js') }}"></script>
        <script src="{{ asset('admin/assets/vendor/js/bootstrap.js') }}"></script>
        <script src="{{ asset('admin/assets/vendor/libs/node-waves/node-waves.js') }}"></script>
        <script src="{{ asset('admin/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
        <script src="{{ asset('admin/assets/vendor/libs/hammer/hammer.js') }}"></script>
        <script src="{{ asset('admin/assets/vendor/libs/i18n/i18n.js') }}"></script>
        <script src="{{ asset('admin/assets/vendor/libs/typeahead-js/typeahead.js') }}"></script>
        <script src="{{ asset('admin/assets/vendor/js/menu.js') }}"></script>

        <!-- endbuild -->

        <!-- Vendors JS -->
        <script src="{{ asset('admin/assets/vendor/libs/@form-validation/popular.js') }}"></script>
        <script src="{{ asset('admin/assets/vendor/libs/@form-validation/bootstrap5.js') }}"></script>
        <script src="{{ asset('admin/assets/vendor/libs/@form-validation/auto-focus.js') }}"></script>

        <!-- Main JS -->
        <script src="{{ asset('admin/assets/js/main.js') }}"></script>

        <!-- Page JS -->
        <script src="{{ asset('admin/assets/js/pages-auth.js') }}"></script>

        <script>
            function showLoader() {
                const submitButton = document.getElementById('submitBtn');
                submitButton.disabled = true;
                submitButton.innerText = 'Sending...';
            }
        </script>
        @livewireScripts
</body>

</html>
