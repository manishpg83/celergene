<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Registration')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>

<body class="bg-gray-100">
    <div class="min-h-screen flex items-center justify-center bg-gray-100">
        <div class="max-w-md w-full space-y-8 p-8 bg-white rounded-xl shadow-md">
            <div class="text-center">
                <h2 class="mt-6 text-3xl font-extrabold text-gray-900">Register to Celergen! 👋</h2>
                <p class="mt-2 text-sm text-gray-600">Create a new account to start the adventure</p>
            </div>
            <form class="mt-8 space-y-6" method="POST" action="{{ route('admin.register') }}">
                @csrf
                <div class="rounded-md shadow-sm">
                    <!-- Name Input -->
                    <div class="mb-3">
                        <label for="name" class="block text-sm font-medium text-gray-700">Full Name</label>
                        <input id="name" name="name" type="text" value="{{ old('name') }}" required
                            class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-t-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                            placeholder="Enter your full name">
                        @error('name')
                            <span class="text-red-500 text-sm mt-1 block">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <!-- Email Input -->
                    <div class="mb-3">
                        <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
                        <input id="email" name="email" type="email" value="{{ old('email') }}" required
                            class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                            placeholder="Enter your email">
                        @error('email')
                            <span class="text-red-500 text-sm mt-1 block">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <!-- Password Input -->
                    <div class="mb-3">
                        <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                        <input id="password" name="password" type="password" required
                            class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-b-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                            placeholder="Enter your password">
                        @error('password')
                            <span class="text-red-500 text-sm mt-1 block">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <!-- Confirm Password Input -->
                    <div class="mb-3">
                        <label for="password-confirm" class="block text-sm font-medium text-gray-700">Confirm
                            Password</label>
                        <input id="password-confirm" name="password_confirmation" type="password" required
                            class="appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-b-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                            placeholder="Confirm your password">
                    </div>
                </div>

                <div>
                    <button type="submit"
                        class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Register
                    </button>
                </div>
            </form>

            <div class="text-center">
                <p class="text-sm text-gray-600">Already have an account? <a href="{{ route('admin.login') }}"
                        class="font-medium text-indigo-600 hover:text-indigo-500">Sign in</a></p>
            </div>
        </div>
    </div>

    @livewireScripts
</body>

</html>
