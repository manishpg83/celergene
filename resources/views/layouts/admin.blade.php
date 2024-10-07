<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="bg-custom-bg">
    <div class="flex h-screen overflow-hidden">
        @include('layouts.sidebar')
        <div class="flex flex-col flex-1 overflow-hidden">
            @include('layouts.navbar')
            <main class="flex-1 mt-2  overflow-x-hidden overflow-y-auto bg-custom-bg p-2">
                <div class="container mx-auto py-8">
                    @yield('content')
                </div>
            </main>
        </div>
    </div>
    @livewireScripts
</body>
</html>
