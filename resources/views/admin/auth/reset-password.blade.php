<!doctype html>

<html
  lang="en"
  class="light-style layout-wide customizer-hide"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path="/admin/assets/"
  data-template="vertical-menu-template"
  data-style="light">
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>Login Basic | Celergen Swiss</title>

    <meta name="description" content="" />

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

    <link rel="stylesheet" href="{{ asset('/admin/assets/vendor/css/rtl/core.css') }}" class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{ asset('/admin/assets/vendor/css/rtl/theme-default.css') }}" class="template-customizer-theme-css" />

    <link rel="stylesheet" href="{{ asset('/admin/assets/css/demo.css') }}" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{ asset('/admin/assets/vendor/libs/node-waves/node-waves.css') }}" />

    <link rel="stylesheet" href="{{ asset('/admin/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />
    <link rel="stylesheet" href="{{ asset('/admin/assets/vendor/libs/typeahead-js/typeahead.css') }}" />
    <!-- Vendor -->


    <!-- Page CSS -->
    <!-- Page -->
    <link rel="stylesheet" href="{{ asset('/admin/assets/vendor/css/pages/page-auth.css') }}" />

    <!-- Helpers -->
    <script src="{{ asset('/admin/assets/vendor/js/helpers.js') }}"></script>

    <!--? Template customizer: To hide customizer set displayCustomizer value false in config.js.  -->
    <script src="{{ asset('/admin/assets/vendor/js/template-customizer.js') }}"></script>

    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="{{ asset('/admin/assets/js/config.js') }}"></script>

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
                                    src="{{ asset('/admin/assets/img/branding/Celergen-Logo.png') }}"
                                    alt="Celergen Swiss" width="auto" height="40">
                            </a>
                        </div>
                        <h4 class="mb-1">Reset Password</h4>
                        <p class="mb-6">Please enter your new password</p>

                        <form id="formAuthentication" class="mb-4" method="POST"
                            action="{{ route('admin.password.update') }}">
                            @csrf
                            <input type="hidden" name="token" value="{{ $token }}">

                            <div class="mb-6">
                                <label for="email" class="form-label">E-Mail Address</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                    id="email" name="email" value="{{ $email ?? old('email') }}" required
                                    autocomplete="email" autofocus>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="mb-6 form-password-toggle">
                                <label class="form-label" for="password">New Password</label>
                                <div class="input-group input-group-merge">
                                    <input type="password" id="password"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        required autocomplete="new-password"
                                        placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                        aria-describedby="password" />
                                    <span class="input-group-text cursor-pointer"><i class="ti ti-eye-off"></i></span>
                                </div>
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="mb-6 form-password-toggle">
                                <label class="form-label" for="password-confirm">Confirm Password</label>
                                <div class="input-group input-group-merge">
                                    <input type="password" id="password-confirm" class="form-control"
                                        name="password_confirmation" required autocomplete="new-password"
                                        placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" />
                                    <span class="input-group-text cursor-pointer"><i class="ti ti-eye-off"></i></span>
                                </div>
                            </div>

                            <div class="mb-6">
                                <button class="btn btn-primary d-grid w-100" type="submit">Reset Password</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- / Content -->

    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->

    <script src="{{ asset('/admin/assets/vendor/libs/jquery/jquery.js') }}"></script>
    <script src="{{ asset('/admin/assets/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ asset('/admin/assets/vendor/js/bootstrap.js') }}"></script>
    <script src="{{ asset('/admin/assets/vendor/libs/node-waves/node-waves.js') }}"></script>
    <script src="{{ asset('/admin/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('/admin/assets/vendor/libs/hammer/hammer.js') }}"></script>
    <script src="{{ asset('/admin/assets/vendor/libs/i18n/i18n.js') }}"></script>
    <script src="{{ asset('/admin/assets/vendor/libs/typeahead-js/typeahead.js') }}"></script>
    <script src="{{ asset('/admin/assets/vendor/js/menu.js') }}"></script>

    <!-- endbuild -->

    <!-- Vendors JS -->
    <script src="{{ asset('/admin/assets/vendor/libs/@form-validation/popular.js') }}"></script>
    <script src="{{ asset('/admin/assets/vendor/libs/@form-validation/bootstrap5.js') }}"></script>
    <script src="{{ asset('/admin/assets/vendor/libs/@form-validation/auto-focus.js') }}"></script>

    <!-- Main JS -->
    <script src="{{ asset('/admin/assets/js/main.js') }}"></script>

    <!-- Page JS -->
    <script src="{{ asset('/admin/assets/js/pages-auth.js') }}"></script>
    @livewireScripts
  </body>
</html>



