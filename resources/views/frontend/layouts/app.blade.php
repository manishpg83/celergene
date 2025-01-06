<!DOCTYPE html>

<html lang="en">

<head>
    <!-- Title -->
    <title>{{ isset($pageTitle) ? $pageTitle . ' —' : '' }} {{ isset($siteTitle) ? $siteTitle : 'Celergen' }}</title>

    <!-- Meta -->
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    {{--     <meta name="author" content="IndianCoder" />
    <meta name="robots" content="index, follow" />
    <meta name="keywords"
        content="android, ios, template, ui kit, app, glamour, delivery, skincare template, elegance, grace, luxury, beauty eCommerce, fashion, ios, material design, order, 
      shopping, store, web app, Gaya, fashion app, fashion template, flair app, apparel app, fashion UI,fashion design, app template, fashion store, responsive design, fashion showcase, modern 
      UI, fashion technology, e-shop, beauty eCommerce web, eCommerce Website, minimal shop, online shop, woocommerce, online beauty shopping, glower, user interface, user experience, Design Elements,
      Trendy, Stylish, User-Friendly, Navigation, Product Display, Branding, Development, Visual Design, Mobile UI Elements, UI Kit for Online Store, UX/UI, UI/UX, Website, Web Design" />
    <meta name="description"
        content="Elevate your online retail presence with Glower Beauty & Shopping eCommerce HTML Template. Crafted with precision, this responsive and feature-rich template 
      offers a seamless and visually stunning shopping experience. Explore a world of possibilities with modern design elements, intuitive navigation, and customizable features. Transform your website 
      into a dynamic online storefront where style meets functionality, providing a captivating and user-friendly eCommerce journey for beauty enthusiasts and shoppers alike." />
    <meta property="og:title" content="Glower: Shop & eCommerce HTML Template | IndianCoder" />
    <meta property="og:description"
        content="Elevate your online retail presence with Glower Beauty & Shopping eCommerce HTML Template. Crafted with precision, this responsive and feature-rich
      template offers a seamless and visually stunning shopping experience. Explore a world of possibilities with modern design elements, intuitive navigation, and customizable features. Transform 
      your website into a dynamic online storefront where style meets functionality, providing a captivating and user-friendly eCommerce journey for beauty enthusiasts and shoppers alike." />
    <meta property="og:image" content="https://glower.indiankoder.com/xhtml/social-image.png" />
    <meta name="format-detection" content="telephone=no" />
    <meta name="twitter:title" content="Glower: Shop & eCommerce HTML Template | IndianCoder" />
    <meta name="twitter:description"
        content="Elevate your online retail presence with Glower Beauty & Shopping eCommerce HTML Template. Crafted with precision, this responsive and feature-rich 
      template offers a seamless and visually stunning shopping experience. Explore a world of possibilities with modern design elements, intuitive navigation, and customizable features. Transform your
      website into a dynamic online storefront where style meets functionality, providing a captivating and user-friendly eCommerce journey for beauty enthusiasts and shoppers alike." />
    <meta name="twitter:image" content="https://glower.indiankoder.com/xhtml/social-image.png" />
    <meta name="twitter:card" content="summary_large_image" /> --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- FAVICONS ICON -->
    <link rel="icon" type="image/x-icon" href="images/favicon.png" />

    <!-- MOBILE SPECIFIC -->
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700" rel="stylesheet" />
    <!-- STYLESHEETS -->
    <link rel="stylesheet" type="text/css" href="{{ asset('/frontend/css/globle.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('/frontend/css/test.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('/frontend/css/register.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('/frontend/css/aos.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('/frontend/css/header-footer.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('/frontend/css/font-awesome.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('/frontend/css/common.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('/frontend/css/custom.css') }}" />
    {{-- <link rel="stylesheet" type="text/css" href="{{ asset('/frontend/css/shoppingcart.css') }}" /> --}}
    {{-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" /> --}}

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
    {{-- <link rel="stylesheet" type="text/css" href="css/custom.css"> --}}

    <!-- Favicon -->
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

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
        }); // JavaScript Document

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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
    </script>
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

    <script src="{{ asset('/frontend/js/test.js') }}"></script>
    <script src="{{ asset('/frontend/js/aos.js') }}"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.3.26/jquery.form-validator.min.js"></script>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
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
    
        function SwitchAddress(ID)
        {
            var CurControl = $('#ship_address');
            CurControl.css("display" , (ID.checked ? "none" : "block"));
        }
        function ValidateFormInputs()
        {
            var addSame = document.getElementById('add_same').checked;
            var CurControl = null;
            for (var i = 0; i < ControlArray.length; i++)
            {
    
                CurControl = document.getElementById(ControlArray[i][0]);
                //alert(CurControl[i][0]);
                if (CurControl != null)
                {
    
                    if (ControlArray[i][0].substring(0, 3) != "bil" && addSame)
                        continue;
                    if (ControlArray[i][0] == 'bill_email')
                    {
                        if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,6})+$/.test(CurControl.value) == false)
                        {
                            alert("Please key in valid email address.");
                            CurControl.focus();
                            CurControl.style.backgroundColor = '#F3F781';
                            return false;
                        }
                    }
                    if (CurControl.value == "" && ControlArray[i][1] != '')
                    {
                        alert(ControlArray[i][1]);
                        CurControl.focus();
                        CurControl.style.backgroundColor = '#F3F781';  //'#F8E0F7' -- Light Pink;
                        return false;
                    } else
                    {
                        CurControl.style.backgroundColor = '#FFFFFF';
                    }
                }
            }
            return true;
        }
    
    
        function UpdateTotals(mode, itembox)
        {
            // var cart_count_mobile = document.getElementById("mobile-cart").getElementsByTagName("span")[0];
            // var cart_count_desktop = document.getElementById("desktop-cart").getElementsByTagName("span")[0];
            var uni_a = document.getElementById('unitprice_' + itembox).value.split(" ");
            var nett_a = document.getElementById('nettotal_text').value.split(" ");
            var nett_value = parseInt(nett_a[1].replace(',', ''));
            var uni = parseInt(uni_a[1].replace(',', ''));
            console.log(nett_value);
            var qty = document.getElementById('quantity_' + itembox);
            var net = document.getElementById('netprice_' + itembox);
            var net2 = document.getElementById('netprice2_' + itembox);
            var sub_text = document.getElementById('subtotal_text');
            var nett_text = document.getElementById('nettotal_text');
            var sub = document.getElementById('subtotal');
            var nett = document.getElementById('nettotal');
    
            if (qty != null && uni != null && net != null && sub != null)
            {
                net.value = "US$ " + (parseInt(qty.value) * parseInt(uni)).toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
                net2.value = "US$ " + (parseInt(qty.value) * parseInt(uni)).toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
                if (mode == "+") {
                    sub_text.value = nett_text.value = "US$ " + (parseInt(nett_value) + parseInt(uni)).toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
                    sub.value = nett.value = parseInt(nett_value) + parseInt(uni);
                    
                    // cart_count_desktop.innerHTML = parseInt(cart_count_desktop.innerHTML) + 1;
                    // cart_count_mobile.innerHTML = parseInt(cart_count_mobile.innerHTML) + 1;
                }
                if (mode == "-") {
                    sub_text.value = nett_text.value = "US$ " + (parseInt(nett_value) - parseInt(uni)).toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
                    sub.value = nett.value = parseInt(nett_value) - parseInt(uni);
                    // cart_count_desktop.innerHTML = parseInt(cart_count_desktop.innerHTML) - 1;
                    // cart_count_mobile.innerHTML = parseInt(cart_count_mobile.innerHTML) - 1;
                }
            }
        }
        function OnQuantityChanged(mode, itembox)
        {
            var qty = document.getElementById('quantity_' + itembox);
            var qty2 = document.getElementById('quantity2_' + itembox);
            var Item = document.getElementById("item_" + itembox);
            var sub = document.getElementById("submitbutton");
            if (qty != null && Item != null)
            {
                var qe = qty.value.split(" ");
                console.log(itembox)
                var cur = qty.value;
                if (mode == "+")
                {
                    Item.value = qty.value = qty2.value = parseInt(cur) + 1;
                    UpdateTotals(mode, itembox);
                    console.log(window.Livewire);

                    console.log('Dispatching cart update event');
                    Livewire.dispatch('cartUpdated', { 
                        itemId: itembox, 
                        quantity: parseInt(qty.value) 
                    });


                    if (sub != null)
                        sub.disabled = false;
    
                } else
                {
                    if (parseInt(cur) >= 1)
                    {
                        Item.value = qty.value = qty2.value = parseInt(cur) - 1;
                        UpdateTotals(mode, itembox);
                    }
                    if (parseInt(cur) - 1 == 0)
                    {
                        //Disable Proceed
                        if (sub != null)
                            sub.disabled = true;
                    }
                    Livewire.dispatch('cartUpdated', { 
                        itemId: itembox, 
                        quantity: parseInt(qty.value) 
                    });
                   
                }
                
            }
        }
    </script>
    <script>
        function showDivs(start)
        {
            var div;
            while ((div = document.getElementById('div' + start)) !== false)
            {
                div.style.display = (div.style.display == 'none') ? '' : 'none';
                start++;
            }
        }
    </script>
</body>

</html>
