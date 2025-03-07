<!DOCTYPE html>

<html lang="en">

<head>
    <!-- Title -->
    <title>{{ isset($pageTitle) ? $pageTitle . ' —' : '' }} {{ isset($siteTitle) ? $siteTitle : 'Celergen' }}</title>
    <!-- Meta -->
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- FAVICONS ICON -->
    <link rel="icon" type="image/x-icon" href="images/favicon.png" />
    <!-- MOBILE SPECIFIC -->
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700" rel="stylesheet" />
    <!-- STYLESHEETS -->
    <link rel="stylesheet" type="text/css" href="{{ asset('/frontend/css/owl.carousel.min.css') }}" />
    <link rel="stylesheet"
        href="https://cdn2-bread6hkcwg3dyar.z01.azurefd.net/celergenswiss/css/owl.theme.default.min.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('/frontend/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('/frontend/css/globle.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('/frontend/css/test.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('/frontend/css/register.css') }}" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="{{ asset('/frontend/css/aos.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('/frontend/css/header-footer.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('/frontend/css/font-awesome.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('/frontend/css/common.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('/frontend/css/custom.css') }}" />
    <!-- Custom Stylesheet -->
    <link class="main-css" rel="stylesheet" type="text/css" href="{{ asset('/frontend/css/style.css') }}" />
    <link href="//cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.3.26/theme-default.min.css" rel="stylesheet"
        type="text/css" />
    <!-- GOOGLE FONTS-->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;700&family=Roboto:wght@100;300;400;500;700;900&display=swap"
        rel="stylesheet" />
    <script src="{{ asset('/frontend/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('/frontend/js/jquery-3.7.0.min.js') }}"></script>
    <script src="{{ asset('/frontend/js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('/frontend/js/dashboard-account.js') }}"></script>

    <!-- Favicon -->
    @livewireStyles
    @stack('styles')
    <style>
        .mt-8 {
            margin-top: 8rem !important;
        }

        .form-group select {
            width: 100%;
            height: 46px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .bg-light-1{
            background-color: #f5f5f5;
        }
    </style>
</head>

<body>
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">

            <div class="layout-page">
                @include('frontend.layouts.header')
                <section class="margin-top">

                </section>
                <div class="content-wrapper">
                    @yield('content')

                    @include('frontend.layouts.footer')

                    <div class="content-backdrop fade"></div>
                </div>
            </div>
        </div>

        <div class="layout-overlay layout-menu-toggle"></div>

        <div class="drag-target"></div>
    </div>

    @livewireScripts
    <script src="https://cdn2-bread6hkcwg3dyar.z01.azurefd.net/celergenswiss/js/header.js"></script>
    <script>
        function toggleClass1() {
            var screensize = screen.width;
            var dropmenu1 = document.getElementById("sub-menu1");
            var mainmenu1 = document.getElementById("main-menu1");
            if (screensize < 991) {
                dropmenu1.classList.toggle("show");
                mainmenu1.classList.toggle("active");
            }

            var plusicon1 = document.getElementById("plusicon1");
            if (plusicon1.classList.contains("fa-plus")) {
                plusicon1.classList.remove("fa-plus");
                plusicon1.classList.add("fa-minus");
            } else {
                plusicon1.classList.remove("fa-minus");
                plusicon1.classList.add("fa-plus");
            }
        }

        function toggleClass2() {
            var screensize = screen.width;
            var dropmenu2 = document.getElementById("sub-menu2");
            var mainmenu2 = document.getElementById("main-menu2");
            if (screensize < 991) {
                dropmenu2.classList.toggle("show");
                mainmenu2.classList.toggle("active");
            }
            var plusicon2 = document.getElementById("plusicon2");
            if (plusicon2.classList.contains("fa-plus")) {
                plusicon2.classList.remove("fa-plus");
                plusicon2.classList.add("fa-minus");
            } else {
                plusicon2.classList.remove("fa-minus");
                plusicon2.classList.add("fa-plus");
            }
        }

        function toggleClass3() {
            var screensize = screen.width;
            var dropmenu3 = document.getElementById("sub-menu3");
            var mainmenu3 = document.getElementById("main-menu4");
            if (screensize < 991) {
                dropmenu3.classList.toggle("show");
                mainmenu3.classList.toggle("active");
            }

            if (plusicon3.classList.contains("fa-plus")) {
                plusicon3.classList.remove("fa-plus");
                plusicon3.classList.add("fa-minus");
            } else {
                plusicon3.classList.remove("fa-minus");
                plusicon3.classList.add("fa-plus");
            }
        }

        $(document).ready(function() {
            $(window).scroll(function() {
                if ($(this).scrollTop() > 50) {
                    $("#header").removeClass("expand-header");
                    $("#header").addClass("shrink-header");
                    $("#menubar1").addClass("menubar1-hide");
                    $("#menubar2").removeClass("menubar2-border");
                    $("#headerlogo").addClass("shrink-logo");
                    $("#headerlogo").removeClass("expand-logo");
                    $("#menu-wrap").removeClass("menu-container");
                    $("#menu-wrap").addClass("menu-container-p0");
                } else {
                    $("#header").removeClass("shrink-header");
                    $("#header").addClass("expand-header");
                    $("#menubar1").removeClass("menubar1-hide");
                    $("#menubar2").addClass("menubar2-border");
                    $("#headerlogo").removeClass("shrink-logo");
                    $("#headerlogo").addClass("expand-logo");
                    $("#menu-wrap").removeClass("menu-container-p0");
                    $("#menu-wrap").addClass("menu-container");
                }
            });
        });

        document.querySelector("form").addEventListener("submit", function(event) {
            const day = document.getElementById("dob_day").value;
            const month = document.getElementById("dob_month").value;
            const year = document.getElementById("dob_year").value;

            if (!day || !month || !year) {
                event.preventDefault();
                alert("Please select a valid Date of Birth.");
            }
        });
    </script>
    <script>
        $('.benefits-review').owlCarousel({
            dots: false,
            autoplay: false,
            mouseDrag: false,
            autoheight: false,
            items: 1,
            loop: true,
            margin: 60,
            nav: true,
            navText: [
                '<a class="prev-btn" aria-hidden="true"><img src="https://cdn2-bread6hkcwg3dyar.z01.azurefd.net/celergenswiss/images/common/ic_left_arrow_white.png"/></a>',
                '<a class="next-btn" aria-hidden="true"><img src="https://cdn2-bread6hkcwg3dyar.z01.azurefd.net/celergenswiss/images/common/ic_right_arrow_white.png"/></a>'
            ]
        })
    </script>
    <!-- GLOBAL-JS -->
    <script src="{{ asset('/frontend/vendor/global/global.min.js') }}"></script>
    <!-- GLOBAL-JS -->
    <script src="{{ asset('/frontend/vendor/magnific-popup/magnific-popup.js') }}"></script>
    <!-- MAGNIFIC POPUP JS -->
    <script src="{{ asset('/frontend/vendor/masonry/masonry-4.2.2.js') }}"></script>
    <!-- MASONRY -->
    <script src="{{ asset('/frontend/vendor/masonry/isotope.pkgd.min.js') }}"></script>
    <!-- ISOTOPE -->
    <script src="{{ asset('/frontend/vendor/countdown/jquery.countdown.js') }}"></script>
    <!-- COUNTDOWN FUCTIONS  -->
    <script src="{{ asset('/frontend/vendor/wnumb/wNumb.js') }}"></script>
    <!-- WNUMB -->
    <script src="{{ asset('/frontend/vendor/nouislider/nouislider.min.js') }}"></script>
    <!-- NOUSLIDER MIN JS-->
    <script src="{{ asset('/frontend/js/dz.carousel.js') }}"></script>
    <!-- DZ CAROUSEL JS -->
    <script src="{{ asset('/frontend/js/dz.ajax.js') }}"></script>
    <!-- AJAX -->
    <script src="{{ asset('/frontend/js/custom.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script src="{{ asset('/frontend/js/test.js') }}"></script>
    <script src="{{ asset('/frontend/js/aos.js') }}"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.3.26/jquery.form-validator.min.js"></script>
    <!-- CUSTOM JS -->

    @yield('scripts')
    <script type="text/javascript">
        var ControlArray = [
            ['bill_firstname', 'You can\'t Leave First Name empty.', '', 'info'],
            ['bill_address1', 'You can\'t Leave Billing Address1 empty.', '', ''],
            ['bill_zip', 'You can\'t Leave Postalcode Empty.', '', ''],
            ['bill_country', 'Please Select Country from List', '', ''],
            ['bill_city', 'Please Select City from List', '', ''],
            ['bill_phone', 'Please Enter Phone no.', '', ''],
            ['bill_email', 'Please Enter a valid email id.', '', ''],
            ['firstname', 'You can\'t Leave First Name empty.', '', 'info'],
            ['address1', 'You can\'t Leave Shipping Address1 empty.', '', ''],
            ['zip', 'You can\'t Leave Postalcode Empty.', '', ''],
            ['country', 'Please Select Country from List', '', ''],
            ['phone', 'Please Enter Phone no.', '', ''],
            ['email', 'Please Enter a valid email id.', '', ''],
            ['city', 'Please Select City from List', '', '']
        ];

        function SwitchAddress(ID) {
            var CurControl = $('#ship_address');
            if (ID.checked) {
                CurControl.hide();
            } else {
                CurControl.show();
            }
        }

        $(document).ready(function() {
            var checkbox = $('#add_same')[0];
            SwitchAddress(checkbox);
        });

        function ValidateFormInputs() {
            var addSame = document.getElementById('add_same').checked;
            var CurControl = null;
            for (var i = 0; i < ControlArray.length; i++) {

                CurControl = document.getElementById(ControlArray[i][0]);
                if (CurControl != null) {

                    if (ControlArray[i][0].substring(0, 3) != "bil" && addSame)
                        continue;
                    if (ControlArray[i][0] == 'bill_email') {
                        if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,6})+$/.test(CurControl.value) == false) {
                            alert("Please key in valid email address.");
                            CurControl.focus();
                            CurControl.style.backgroundColor = '#F3F781';
                            return false;
                        }
                    }
                    if (CurControl.value == "" && ControlArray[i][1] != '') {
                        alert(ControlArray[i][1]);
                        CurControl.focus();
                        CurControl.style.backgroundColor = '#F3F781';
                        return false;
                    } else {
                        CurControl.style.backgroundColor = '#FFFFFF';
                    }
                }
            }
            return true;
        }
    </script>
    <script>
        function UpdateTotals(mode, itembox) {
            var qty = document.getElementById('quantity_' + itembox);
            var qty2 = document.getElementById('quantity2_' + itembox);
            var netprice = document.getElementById('netprice_' + itembox);
            var netprice2 = document.getElementById('netprice2_' + itembox);
            var unitprice = document.getElementById('unitprice_' + itembox);

            if (qty && netprice && unitprice) {
                var unit = parseFloat(unitprice.value.replace('US$ ', '')) || 0;
                var quantity = parseInt(qty.value) || 0;

                var calculatedNetPrice = (unit * quantity).toFixed(2);
                netprice.value = calculatedNetPrice;
                if (netprice2) {
                    netprice2.value = calculatedNetPrice;
                }
            }

            if (qty2) {
                qty2.value = qty.value;
            }

            var subtotal = 0;
            var items = ['CEL', 'SER', 'PK1'];
            items.forEach(function(item) {
                var itemNetPrice = document.getElementById('netprice_' + item);
                if (itemNetPrice) {
                    subtotal += parseFloat(itemNetPrice.value) || 0;
                }
            });

            document.getElementById('subtotal_text').value = 'US$ ' + subtotal.toFixed(2);
            document.getElementById('nettotal_text').value = 'US$ ' + subtotal.toFixed(2);

            updateCartStorage();
        }

        function OnQuantityChanged(mode, itembox) {
            var qty = document.getElementById('quantity_' + itembox);
            if (qty) {
                var currentQty = parseInt(qty.value) || 0;
                if (mode === '+') {
                    currentQty++;
                } else if (mode === '-' && currentQty > 0) {
                    currentQty--;
                }
                qty.value = currentQty;

                UpdateTotals(mode, itembox);
            }
        }

        function updateCartStorage() {
            var items = ['CEL', 'SER', 'PK1'];
            var cart = {};

            items.forEach(function(item) {
                var qty = document.getElementById('quantity_' + item);
                var unitPrice = document.getElementById('unitprice_' + item);
                var netPrice = document.getElementById('netprice_' + item);

                if (qty && parseInt(qty.value) > 0) {
                    cart[item] = {
                        id: item,
                        quantity: parseInt(qty.value),
                        price: parseFloat(unitPrice.value.replace('US$ ', '')) || 0,
                        netPrice: parseFloat(netPrice.value) || 0,
                        name: getProductName(item)
                    };
                }
            });

            localStorage.setItem('cart', JSON.stringify(cart));
            if (window.Livewire) {
                Livewire.dispatch('cartUpdated', {
                    itemId: 'CEL',
                    quantity: 3
                });
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            var savedCart = localStorage.getItem('cart');
            if (savedCart) {
                var cart = JSON.parse(savedCart);
                for (var item in cart) {
                    var qty = document.getElementById('quantity_' + item);
                    var qty2 = document.getElementById('quantity2_' + item);
                    if (qty) {
                        qty.value = cart[item].quantity;
                        if (qty2) {
                            qty2.value = cart[item].quantity;
                        }
                        UpdateTotals('+', item);
                    }
                }
            }
        });

        function getProductName(itembox) {
            const productNames = {
                'CEL': 'Celergen',
                'SER': 'Serum Royale',
                'PK1': 'CELERGEN & SERUM ROYALE'
            };
            return productNames[itembox] || 'Unknown Product';
        }
    </script>
    <script>
        Livewire.on('show-thank-you-modal', () => {
            console.log("Thank you modal event triggered!");
            $('#thankYouModal').modal('show');
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const cartData = JSON.parse(localStorage.getItem('cart') || '{}');

            Livewire.dispatch('cartDataReceived', cartData);
        });
    </script>
    <script>
        function showDivs(start) {
            var div;
            while ((div = document.getElementById('div' + start)) !== false) {
                div.style.display = (div.style.display == 'none') ? '' : 'none';
                start++;
            }
        }
    </script>
    <script>
        $(document).ready(function() {
            var aboutslider = $('.about-slider');

            aboutslider.owlCarousel({
                items: 1,
                loop: false,
                margin: 0,
                dots: false,
                autoplay: false,
                mouseDrag: false,
                touchDrag: false,
                pullDrag: false,
                URLhashListener: true,
                startPosition: 'URLHash'
            });

            aboutslider.on("changed.owl.carousel", function(event) {
                var itemno = event.item.index;
                if (itemno === 0) {
                    setActiveButton('#aboutbtn1');
                } else if (itemno === 1) {
                    setActiveButton('#aboutbtn2');
                } else if (itemno === 2) {
                    setActiveButton('#aboutbtn3');
                }
            });

            $('#aboutbtn1').on('click', function(e) {
                e.preventDefault();
                aboutslider.trigger('to.owl.carousel', [0]);
            });

            $('#aboutbtn2').on('click', function(e) {
                e.preventDefault();
                aboutslider.trigger('to.owl.carousel', [1]);
            });

            $('#aboutbtn3').on('click', function(e) {
                e.preventDefault();
                aboutslider.trigger('to.owl.carousel', [2]);
            });

            function setActiveButton(activeButtonId) {
                $('.aboutcelergen-btn, .aboutactive-btn').removeClass('aboutactive-btn').addClass(
                    'aboutcelergen-btn');
                $(activeButtonId).removeClass('aboutcelergen-btn').addClass('aboutactive-btn');
            }

            var url = window.location.href;
            var hash = url.substring(url.indexOf("#") + 1);
            if (hash == 'aboutbtn1') {
                setActiveButton('#aboutbtn1');
            }
            if (hash == 'aboutbtn2') {
                setActiveButton('#aboutbtn2');
            }
            if (hash == 'aboutbtn3') {
                setActiveButton('#aboutbtn3');
            }
        });
    </script>
</body>

</html>
