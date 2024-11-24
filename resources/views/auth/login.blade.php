<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.1.2/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-cover bg-center h-screen flex items-center justify-center" style="background-image: url('/images/background.jpg');">

    <!-- Form Container -->
    <div class="bg-white bg-opacity-90 p-8 rounded-lg shadow-lg w-full max-w-md text-center">

        <!-- Logo or App Name -->
        <h2 class="text-3xl font-bold text-gray-800 mb-6">Log in to ShareIT</h2>

        <!-- Description -->
        <p class="text-gray-600 mb-6">
            Sign in to access to view content and connect with the community.
        </p>

        <!-- Login Form -->
        <form method="POST" action="{{ route('login') }}">
            @csrf
            
            <!-- Email Address -->
            <div class="mb-4 text-left">
                <label for="email" class="block text-gray-700 font-semibold">Email</label>
                <input id="email" type="email" name="email" required autofocus autocomplete="username"
                       class="w-full mt-2 p-3 border rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500" />
            </div>

            <!-- Password -->
            <div class="mb-4 text-left">
                <label for="password" class="block text-gray-700 font-semibold">Password</label>
                <input id="password" type="password" name="password" required autocomplete="current-password"
                       class="w-full mt-2 p-3 border rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500" />
            </div>

            <!-- Remember Me Checkbox -->
            <div class="flex items-center justify-between mb-6">
                <label class="flex items-center text-sm text-gray-600">
                    <input type="checkbox" name="remember" class="mr-2 rounded text-indigo-600 focus:ring-indigo-500">
                    Remember me
                </label>

                <!-- Forgot Password Link -->
                <a href="{{ route('password.request') }}" class="text-sm text-indigo-600 hover:underline">
                    Forgot your password?
                </a>
            </div>

            <!-- Login Button -->
            <button type="submit" class="w-full px-6 py-3 bg-indigo-600 text-white font-semibold rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                Log In
            </button>
        </form>

        <!-- Sign-Up Prompt -->
        <p class="mt-6 text-gray-600">
            Don't have an account?
            <a href="{{ route('register') }}" class="text-indigo-600 font-semibold hover:underline">Sign Up</a>
        </p>
    </div>

</body>
</html>
