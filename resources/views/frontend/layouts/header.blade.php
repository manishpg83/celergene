<section>
    <header class="site-header mo-left header style-1 header-transparent">
        <div id="header" class="header container-fluid expand-header">
            <a class="logo d-none d-lg-block" href="https://celergenswiss.azurewebsites.net"><img id="headerlogo"
                    class="expand-logo"
                    src="https://cdn2-bread6hkcwg3dyar.z01.azurefd.net/celergenswiss/images/common/cropped-celergen-logo.png"
                    alt="logo" width="240" /></a>
            <!-- entire menu -->
            <div id="menu-wrap" class="flex-column menu-container">
                <!-- menubar1 -->
                <div id="menubar1" class="menubar1 d-lg-block d-none">
                    <nav class="nav navbar-expand-lg justify-content-end pb-2 pt-2">
                        <ul class="navbar-nav align-items-center">
                            <li class="nav-item pe-4">
                                <a class="nav-link bg-blue align-self-center text-white rounded-5 py-1 px-lg-3"
                                    aria-current="page" href="blog.php" style="background-color: #002d59;">
                                    Celergen's Blog
                                </a>
                            </li>
                            <li class="nav-item dropdown pe-4">
                                @auth
                                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        {{ Auth::user()->name ?? Auth::user()->first_name }}
                                    </a>

                                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                        <li><a class="dropdown-item" href="{{ route('myaccount') }}">My Account</a></li>
                                        <li>
                                            <a class="dropdown-item" href="#"
                                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                                Logout
                                            </a>

                                            <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                                class="d-none">
                                                @csrf
                                            </form>

                                        </li>
                                    </ul>
                                @else
                                    <a class="nav-link" aria-current="page" href="{{ route('login') }}">
                                        My Account
                                    </a>
                                @endauth
                            </li>


                            <!-- to be removed
      <li class="nav-item pe-4">
      <a class="nav-link" aria-current="page" href="admin/blog-list.php">admin</a>
      </li> -->
                            <!-- to be removed -->
                            <li class="nav-item pe-3">
                                <a class="nav-link" aria-current="page" href="https://www.facebook.com/CelergenSwiss"
                                    target="_blank">
                                    <img src="https://cdn2-bread6hkcwg3dyar.z01.azurefd.net/celergenswiss/images/common/ic_fb.png"
                                        alt="" class="src" />
                                </a>
                            </li>

                            <li class="nav-item pe-3">
                                <a class="nav-link" aria-current="page" href="https://www.instagram.com/celergeneurope"
                                    target="_blank">
                                    <img src="https://cdn2-bread6hkcwg3dyar.z01.azurefd.net/celergenswiss/images/common/ic_instagram.png"
                                        alt="" class="src" />
                                </a>
                            </li>

                            <li class="nav-item pe-3">
                                <a class="nav-link" aria-current="page" href="https://twitter.com/CelergenSocial"
                                    target="_blank">
                                    <img src="https://cdn2-bread6hkcwg3dyar.z01.azurefd.net/celergenswiss/images/common/ic_twitter.png"
                                        alt="" class="src" />
                                </a>
                            </li>
                            <li class="nav-item pe-3">
                                <a class="nav-link" aria-current="page" href="index.php">
                                    <img src="https://cdn2-bread6hkcwg3dyar.z01.azurefd.net/celergenswiss/images/common/download.png"
                                        alt="" /></a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link pe-0" aria-current="page" href="https://celergenswiss.com/th/"
                                    target="_blank">
                                    <img src="https://cdn2-bread6hkcwg3dyar.z01.azurefd.net/celergenswiss/images/common/Thai.png"
                                        alt="" class="" />
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
                <!-- menubar1 end -->
                <!-- menubar2 -->
                <div id="menubar2" class="top-0 float-end w-100 menubar2-border">
                    <nav class="navbar nav navbar-expand-lg justify-content-end py-1 py-md-2">
                        <!-- mobie menubar -->
                        <div class="container-fluid pe-0 pt-1 justify-content-between d-block d-lg-none">
                            <div class="navbar nav py-0">
                                <div>
                                    <a href="https://celergenswiss.azurewebsites.net/"><img id="headerlogo1"
                                            class="expand-logo"
                                            src="https://cdn2-bread6hkcwg3dyar.z01.azurefd.net/celergenswiss/images/common/cropped-celergen-logo.png"
                                            alt="logo" width="200" /></a>
                                </div>
                                <div class="align-items-end">
                                    <ul class="navbar-nav flex-row">
                                        <li class="nav-item me-2">
                                            <a href="https://store.celergenswiss.com/login.php" class="px-2 pb-2 pt-1">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28"
                                                    viewBox="0 0 20 20" fill="none">
                                                    <path
                                                        d="M10 10C12.2091 10 14 8.20914 14 6C14 3.79086 12.2091 2 10 2C7.79086 2 6 3.79086 6 6C6 8.20914 7.79086 10 10 10Z"
                                                        stroke="black" stroke-width="1.5" stroke-linecap="round"
                                                        stroke-linejoin="round"></path>
                                                    <path
                                                        d="M3.3335 18.3333C3.3335 16.6667 5.00016 15 6.66683 15H13.3335C15.0002 15 16.6668 16.6667 16.6668 18.3333"
                                                        stroke="black" stroke-width="1.5" stroke-linecap="round"
                                                        stroke-linejoin="round"></path>
                                                </svg>
                                            </a>
                                        </li>

                                        <li class="nav-item me-3 position-relative">
                                            <a href="{{ route('cart') }}" class="p-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 20 20" fill="none">
                                                    <g clip-path="url(#clip0_67_234)">
                                                        <path
                                                            d="M7.49984 18.3334C7.96007 18.3334 8.33317 17.9603 8.33317 17.5001C8.33317 17.0398 7.96007 16.6667 7.49984 16.6667C7.0396 16.6667 6.6665 17.0398 6.6665 17.5001C6.6665 17.9603 7.0396 18.3334 7.49984 18.3334Z"
                                                            stroke="black" stroke-width="1.5" stroke-linecap="round"
                                                            stroke-linejoin="round"></path>
                                                        <path
                                                            d="M16.6668 18.3334C17.1271 18.3334 17.5002 17.9603 17.5002 17.5001C17.5002 17.0398 17.1271 16.6667 16.6668 16.6667C16.2066 16.6667 15.8335 17.0398 15.8335 17.5001C15.8335 17.9603 16.2066 18.3334 16.6668 18.3334Z"
                                                            stroke="black" stroke-width="1.5" stroke-linecap="round"
                                                            stroke-linejoin="round"></path>
                                                        <path
                                                            d="M0.833496 0.833252H4.16683L6.40016 11.9916C6.47637 12.3752 6.68509 12.7199 6.98978 12.9652C7.29448 13.2104 7.67575 13.3407 8.06683 13.3333H16.1668C16.5579 13.3407 16.9392 13.2104 17.2439 12.9652C17.5486 12.7199 17.7573 12.3752 17.8335 11.9916L19.1668 4.99992H5.00016"
                                                            stroke="black" stroke-width="1.5" stroke-linecap="round"
                                                            stroke-linejoin="round"></path>
                                                    </g>
                                                    <defs>
                                                        <clipPath id="clip0_67_234">
                                                            <rect width="20" height="20" fill="white">
                                                            </rect>
                                                        </clipPath>
                                                    </defs>
                                                </svg>
                                                <livewire:frontend.cart-count />
                                            </a>
                                        </li>

                                        <li class="nav-item">
                                            <a class="navbar-toggler p-2" data-bs-toggle="offcanvas"
                                                data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar"
                                                style="border: none">
                                                <img src="https://cdn2-bread6hkcwg3dyar.z01.azurefd.net/celergenswiss/images/common/ic_burger.png"
                                                    alt="" class="burger-menu" />
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <!-- mobie menubar end -->

                        <div class="offcanvas offcanvas-end border-0" tabindex="-1" id="offcanvasNavbar"
                            aria-labelledby="offcanvasNavbarLabel">
                            <div class="mobile-menubar">
                                <a class="d-block d-lg-none mx-auto text-center p-4 mb-4" href="#"><img
                                        src="https://cdn2-bread6hkcwg3dyar.z01.azurefd.net/celergenswiss/images/common/cropped-celergen-logo.png"
                                        alt="logo" width="120" /></a>
                                <ul class="navbar-nav justify-content-end sidbar-main-menu text-end">
                                    <li class="nav-item mx-xl-2 mx-lg-0 py-xl-2 dropdown">
                                        <a class="nav-link px-xl-3 px-lg-2 dropdown sidbar-main-item"
                                            href="{{ route('home') }}">
                                            HOME</a>
                                    </li>

                                    <li
                                        class="nav-item mx-xl-2 mx-lg-0 py-xl-2 dropdown menu-item-has-children sidbar-main-item">
                                        <a id="main-menu1" onclick="toggleClass1()"
                                            class="nav-link px-xl-3 px-lg-2 dropdown text-blue" href="#">
                                            <span id="plusicon1"
                                                class="fa fa-plus d-lg-none bg-blue text-white p-1 me-2 float-start"></span>
                                            WHAT IS CELERGEN?
                                        </a>
                                        <ul class="dropdown-menu1 sub-menu" id="sub-menu1">
                                            <li>
                                                <a class="dropdown-item ps-2" href="{{ route('about') }}">
                                                    ABOUT CELERGEN
                                                </a>
                                            </li>
                                            <li>
                                                <hr class="dropdown-divider d-lg-block d-none" />
                                            </li>
                                            <li>
                                                <a class="dropdown-item ps-2" href="{{ route('serumroyale') }}">
                                                    SERUM ROYALE
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li
                                        class="nav-item mx-xl-2 mx-lg-0 py-xl-2 dropdown dropdown menu-item-has-children sidbar-main-item">
                                        <a id="main-menu2" onclick="toggleClass2()"
                                            class="nav-link px-xl-3 px-lg-2 dropdown" href="#">
                                            <span id="plusicon2"
                                                class="fa fa-plus d-lg-none bg-blue text-white p-1 me-2 float-start"></span>
                                            BENEFITS
                                        </a>
                                        <ul class="dropdown-menu1 sub-menu" id="sub-menu2">
                                            <li>
                                                <a class="dropdown-item ps-2" href="{{ route('energyandvitality') }}">
                                                    ENERGY AND VITALITY
                                                </a>
                                            </li>
                                            <li>
                                                <hr class="dropdown-divider d-lg-block d-none" />
                                            </li>
                                            <li>
                                                <a class="dropdown-item ps-2" href="{{ route('joinpainreduction') }}">
                                                    JOIN PAIN REDUCTION
                                                </a>
                                            </li>
                                            <li>
                                                <hr class="dropdown-divider d-lg-block d-none" />
                                            </li>
                                            <li>
                                                <a class="dropdown-item ps-2" href="{{ route('moodelevation') }}">
                                                    MOOD ELEVATION
                                                </a>
                                            </li>
                                            <li>
                                                <hr class="dropdown-divider d-lg-block d-none" />
                                            </li>
                                            <li>
                                                <a class="dropdown-item ps-2"
                                                    href="{{ route('staminaandrecovery') }}">
                                                    STAMINA AND RECOVERY
                                                </a>
                                            </li>
                                            <li>
                                                <hr class="dropdown-divider d-lg-block d-none" />
                                            </li>
                                            <li>
                                                <a class="dropdown-item ps-2"
                                                    href="{{ route('beautyenhancement') }}">
                                                    BEAUTY ENHANCEMENT
                                                </a>
                                            </li>
                                            <li>
                                                <hr class="dropdown-divider d-lg-block d-none" />
                                            </li>
                                            <li>
                                                <a class="dropdown-item ps-2" href="{{ route('increaselibido') }}">
                                                    INCREASE LIBIDO
                                                </a>
                                            </li>
                                            <li>
                                                <hr class="dropdown-divider d-lg-block d-none" />
                                            </li>
                                            <li>
                                                <a class="dropdown-item ps-2"
                                                    href="{{ route('lowersglycmicindex') }}">
                                                    LOWERS GLYCEMIC INDEX
                                                </a>
                                            </li>
                                        </ul>
                                    </li>

                                    <li class="nav-item mx-xl-2 mx-lg-0 py-xl-2 dropdown">
                                        <a class="nav-link px-xl-4 px-lg-2 sidbar-main-item"
                                            href="{{ route('clinicalstudies') }}">
                                            CLINICAL STUDIES</a>
                                    </li>

                                    <li
                                        class="nav-item mx-xl-2 mx-lg-0 py-xl-2 dropdown dropdown menu-item-has-children sidbar-main-item">
                                        <a id="main-menu3" onclick="toggleClass3()"
                                            class="nav-link px-xl-3 px-lg-2 dropdown" href="#">
                                            <span id="plusicon3"
                                                class="fa fa-plus d-lg-none bg-blue text-white p-1 me-2 float-start"></span>
                                            SUCCESS STORIES
                                        </a>
                                        <ul class="dropdown-menu1 sub-menu" id="sub-menu3">
                                            <li>
                                                <a class="dropdown-item ps-2" href="{{ route('celergenreviews') }}">
                                                    CELERGEN REVIEWS
                                                </a>
                                            </li>
                                            <li>
                                                <hr class="dropdown-divider d-lg-block d-none" />
                                            </li>
                                            <li>
                                                <a class="dropdown-item ps-2" href="{{ route('celergenvideo') }}">
                                                    CELERGEN VIDEO
                                                </a>
                                            </li>
                                            <li>
                                                <hr class="dropdown-divider d-lg-block d-none" />
                                            </li>
                                            <li>
                                                <a class="dropdown-item ps-2" href="{{ route('celergenfeatures') }}">
                                                    CELERGEN FEATURES
                                                </a>
                                            </li>
                                        </ul>
                                    </li>

                                    <li class="nav-item mx-xl-2 mx-lg-0 py-xl-2 dropdown dropdown">
                                        <a class="nav-link px-xl-4 px-lg-2 dropdown" href="{{ route('cart') }}">
                                            ORDER HERE
                                        </a>
                                    </li>

                                    <li
                                        class="nav-item ms-xl-2 mx-lg-0 py-2 dropdown d-lg-block d-none position-relative">
                                        <a class="nav-link d-lg-block d-none pt-1" href="{{ route('cart') }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                viewBox="0 0 20 20" fill="none">
                                                <g clip-path="url(#clip0_67_234)">
                                                    <path
                                                        d="M7.49984 18.3334C7.96007 18.3334 8.33317 17.9603 8.33317 17.5001C8.33317 17.0398 7.96007 16.6667 7.49984 16.6667C7.0396 16.6667 6.6665 17.0398 6.6665 17.5001C6.6665 17.9603 7.0396 18.3334 7.49984 18.3334Z"
                                                        stroke="black" stroke-width="1.5" stroke-linecap="round"
                                                        stroke-linejoin="round"></path>
                                                    <path
                                                        d="M16.6668 18.3334C17.1271 18.3334 17.5002 17.9603 17.5002 17.5001C17.5002 17.0398 17.1271 16.6667 16.6668 16.6667C16.2066 16.6667 15.8335 17.0398 15.8335 17.5001C15.8335 17.9603 16.2066 18.3334 16.6668 18.3334Z"
                                                        stroke="black" stroke-width="1.5" stroke-linecap="round"
                                                        stroke-linejoin="round"></path>
                                                    <path
                                                        d="M0.833496 0.833252H4.16683L6.40016 11.9916C6.47637 12.3752 6.68509 12.7199 6.98978 12.9652C7.29448 13.2104 7.67575 13.3407 8.06683 13.3333H16.1668C16.5579 13.3407 16.9392 13.2104 17.2439 12.9652C17.5486 12.7199 17.7573 12.3752 17.8335 11.9916L19.1668 4.99992H5.00016"
                                                        stroke="black" stroke-width="1.5" stroke-linecap="round"
                                                        stroke-linejoin="round"></path>
                                                </g>
                                                <defs>
                                                    <clipPath id="clip0_67_234">
                                                        <rect width="20" height="20" fill="white"></rect>
                                                    </clipPath>
                                                </defs>
                                            </svg>
                                            <livewire:frontend.cart-count />
                                        </a>
                                    </li>


                                    <li
                                        class="nav-item mx-xl-2 mx-lg-0 py-xl-2 dropdown d-lg-none d-md-block dropdown">
                                        <a class="nav-link px-xl-3 px-lg-2 dropdown" href="blog.php">
                                            CELERGEN'S BLOG</a>
                                    </li>
                                </ul>
                            </div>

                            <div class="position-absolute w-100 bottom-0 d-block d-lg-none">
                                <div class="p-2 position-absolute bottom-0 border-top bg-white w-100">
                                    <ul id="mobile-social" class="p-0 m-0 float-end">
                                        <li class="p-2 d-inline">
                                            <a href="https://twitter.com/CelergenSocial" target="_blank"><img
                                                    src="https://cdn2-bread6hkcwg3dyar.z01.azurefd.net/celergenswiss/images/common/ic_twitter_27.png"
                                                    width="20px" alt="Celergen Switzerland Twitter"
                                                    class="twitter" /></a>
                                        </li>
                                        <li class="p-2 d-inline">
                                            <a href="https://www.instagram.com/celergeneurope" target="_blank"><img
                                                    src="https://cdn2-bread6hkcwg3dyar.z01.azurefd.net/celergenswiss/images/common/ic_instagram_27.png"
                                                    width="20px" alt="Celergen Switzerland Instagram"
                                                    class="twitter" /></a>
                                        </li>
                                        <li class="p-2 d-inline">
                                            <a href="https://www.facebook.com/CelergenSwiss" target="_blank"><img
                                                    src="https://cdn2-bread6hkcwg3dyar.z01.azurefd.net/celergenswiss/images/common/ic_fb_27.png"
                                                    width="20px" alt="Celergen Switzerland Facebook"
                                                    class="facebook" /></a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </nav>
                </div>
                <!-- menubar2 end -->
            </div>
            <!-- entire menu end -->
        </div>
    </header>
</section>
