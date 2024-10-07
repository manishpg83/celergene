<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Home')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>

<body class="bg-gray-50">

    <!-- Navbar -->
    <nav class="bg-white shadow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 mt-2">
                <div class="flex mt-2">
                    <div class="flex-shrink-0">
                        <a href="#" class="text-2xl font-bold text-gray-900">Celergen</a>
                    </div>
                    <div class="hidden mt-2 md:flex md:space-x-10 ml-10">
                        <a href="#what-we-provide" class="text-gray-900 hover:text-gray-600">What We Provide</a>
                        <a href="#testimonials" class="text-gray-900 hover:text-gray-600">Testimonials</a>
                        <a href="#contact" class="text-gray-900 hover:text-gray-600">Contact Us</a>
                    </div>
                </div>
                <div class="hidden md:flex md:items-center">
                    <a href="{{ route('admin.login') }}" class="bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-500">
                        Login
                    </a>
                </div>

                <!-- Mobile menu button -->
                <div class="-mr-2 flex md:hidden">
                    <button id="mobile-menu-button" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-600 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-100 focus:ring-gray-500" aria-controls="mobile-menu" aria-expanded="false">
                        <span class="sr-only">Open main menu</span>
                        <svg class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
                        </svg>
                        <svg class="hidden h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <!-- Mobile menu, show/hide based on menu state -->
    <div class="md:hidden" id="mobile-menu" style="display: none;">
        <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
            <a href="#what-we-provide" class="text-gray-900 hover:text-gray-600 block">What We Provide</a>
            <a href="#testimonials" class="text-gray-900 hover:text-gray-600 block">Testimonials</a>
            <a href="#contact" class="text-gray-900 hover:text-gray-600 block">Contact Us</a>
            <a href="{{ route('admin.login') }}" class="bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-500 block text-center">
                Login
            </a>
        </div>
    </div>

    <!-- Hero Section -->
    <header class="bg-blue-600 text-white">
        <div class="max-w-7xl mx-auto px-4 py-20 text-center">
            <h1 class="text-5xl font-bold">Welcome to Celergen</h1>
            <p class="mt-4 text-xl">Your one-stop shop for all your needs!</p>
            <a href="#products"
                class="mt-8 inline-block bg-white text-blue-600 py-2 px-4 rounded-full font-semibold hover:bg-gray-200">Shop
                Now</a>
        </div>
    </header>

    <!-- What We Provide -->
    <section id="what-we-provide" class="py-16">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <h2 class="text-3xl font-bold mb-8">What We Provide</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white p-6 rounded-lg shadow">
                    <h3 class="text-lg font-semibold">Wide Selection</h3>
                    <p class="mt-2">Explore a variety of products across all categories.</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow">
                    <h3 class="text-lg font-semibold">Quality Assurance</h3>
                    <p class="mt-2">We guarantee the quality of all our products.</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow">
                    <h3 class="text-lg font-semibold">Customer Support</h3>
                    <p class="mt-2">Get help whenever you need it with our 24/7 support.</p>
                </div>
            </div>
        </div>
    </section>
    <!-- Testimonials -->
    <section id="testimonials" class="bg-gray-200 py-16">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <h2 class="text-3xl font-bold mb-8">Testimonials</h2>
            <div class="flex flex-col md:flex-row justify-center space-y-4 md:space-y-0 md:space-x-8">
                <div class="bg-white p-6 rounded-lg shadow">
                    <p>"E-Commoers has changed my shopping experience for the better!"</p>
                    <p class="mt-2 font-semibold">- Sarah J.</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow">
                    <p>"Amazing products and fantastic customer service!"</p>
                    <p class="mt-2 font-semibold">- Mark T.</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow">
                    <p>"I always find what I need and more at E-Commoers!"</p>
                    <p class="mt-2 font-semibold">- Emily R.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-white py-4">
        <div class="max-w-7xl mx-auto text-center">
            <p class="text-gray-600">© 2024 E-Commoers. All rights reserved.</p>
        </div>
    </footer>

    @livewireScripts

    <script>
        // Toggle mobile menu
        document.getElementById('mobile-menu-button').addEventListener('click', function() {
            const menu = document.getElementById('mobile-menu');
            menu.style.display = menu.style.display === 'none' || menu.style.display === '' ? 'block' : 'none';
        });
    </script>
</body>

</html>
