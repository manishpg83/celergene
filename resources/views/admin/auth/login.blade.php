<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Welcome to ' . config('app.name') . '!')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>

<body class="bg-gray-100">
    <div class="min-h-screen flex items-center justify-center bg-gray-100">
        <div class="max-w-md w-full space-y-8 p-10 bg-white rounded-xl shadow-md">
                <div class="text-center">
                    <p class="mt-6 text"><img style="display: inline;" src="{{asset('admin/assets/img/logo.png')}}" alt=""></p>
                    <h2 class="mt-6 text-3xl font-extrabold text-gray-900">Welcome to {{config('app.name')}}!</h2>
                    <p class="mt-2 text-sm text-gray-600">Please sign-in to your account and start the adventure</p>
                </div>
                <form class="mt-8 space-y-6" method="POST" action="{{ route('admin.login') }}">
                    @csrf
                    <div class="rounded-md shadow-sm -space-y-px">
                        <div class="mb-3">
                            <label for="email" class="block text-sm font-medium text-gray-700">Email or Username</label>
                            <input type="text" id="email" name="email" required
                                class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-t-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                                placeholder="Enter your email or username">
                        </div>
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                            <input type="password" id="password" name="password" required
                                class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-b-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                                placeholder="Password">
                        </div>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <input id="remember_me" name="remember_me" type="checkbox"
                                class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                            <label for="remember_me" class="ml-2 block text-sm text-gray-900">Remember Me</label>
                        </div>
                        <div class="text-sm">
                            <a href="#" class="font-medium text-indigo-600 hover:text-indigo-500">Forgot Password?</a>
                        </div>
                    </div>

                    <div>
                        <button type="submit"
                            class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Login
                        </button>
                    </div>
                </form>

                <!-- <div class="text-center">
                    <p class="text-sm text-gray-600">New on our platform? <a href="#" class="font-medium text-indigo-600 hover:text-indigo-500">Create an account</a></p>
                </div>
                <div class="flex justify-center space-x-4">
                    <a href="#" class="text-gray-600">Facebook</a>
                    <a href="#" class="text-gray-600">Twitter</a>
                    <a href="#" class="text-gray-600">Google</a>
                </div> -->
            </div>
        </div>

        @livewireScripts
</body>

</html>
