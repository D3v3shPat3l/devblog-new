<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.1.2/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-cover bg-center h-screen flex items-center justify-center" style="background-image: url('/images/background.jpg');">

    <!-- Form Container -->
    <div class="bg-white bg-opacity-90 p-8 rounded-lg shadow-lg w-full max-w-md text-center">

        <!-- App Name or Title -->
        <h2 class="text-3xl font-bold text-gray-800 mb-6">Join ShareIT</h2>

        <!-- Description -->
        <p class="text-gray-600 mb-6">
            Create an account to start sharing and connecting with the community.
        </p>

        <!-- Sign Up Form -->
        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Name -->
            <div class="mb-4 text-left">
                <label for="name" class="block text-gray-700 font-semibold">Name</label>
                <input id="name" type="text" name="name" required autofocus
                       class="w-full mt-2 p-3 border rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500" />
                @error('name')
                    <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                @enderror
            </div>

            <!-- Email Address -->
            <div class="mb-4 text-left">
                <label for="email" class="block text-gray-700 font-semibold">Email</label>
                <input id="email" type="email" name="email" required autocomplete="username"
                       class="w-full mt-2 p-3 border rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500" />
                @error('email')
                    <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                @enderror
            </div>

            <!-- Password -->
            <div class="mb-4 text-left">
                <label for="password" class="block text-gray-700 font-semibold">Password</label>
                <input id="password" type="password" name="password" required autocomplete="new-password"
                       class="w-full mt-2 p-3 border rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500" />
                @error('password')
                    <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                @enderror
            </div>

            <!-- Confirm Password -->
            <div class="mb-6 text-left">
                <label for="password_confirmation" class="block text-gray-700 font-semibold">Confirm Password</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                       class="w-full mt-2 p-3 border rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500" />
                @error('password_confirmation')
                    <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                @enderror
            </div>

            <!-- Sign Up Button -->
            <button type="submit" class="w-full px-6 py-3 bg-indigo-600 text-white font-semibold rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                Sign Up
            </button>
        </form>

        <!-- Log In Prompt -->
        <p class="mt-6 text-gray-600">
            Already have an account?
            <a href="{{ route('login') }}" class="text-indigo-600 font-semibold hover:underline">Log In</a>
        </p>
    </div>

</body>
</html>
