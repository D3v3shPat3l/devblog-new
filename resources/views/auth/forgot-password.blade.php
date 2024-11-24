<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.1.2/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-cover bg-center h-screen flex items-center justify-center" style="background-image: url('/images/background.jpg');">

    <!-- Form Container -->
    <div class="bg-white bg-opacity-90 p-8 rounded-lg shadow-lg w-full max-w-md text-center">

        <!-- App Name or Title -->
        <h2 class="text-3xl font-bold text-gray-800 mb-6">Forgot Your Password?</h2>

        <!-- Description -->
        <p class="text-gray-600 mb-6">
            Enter your email address and we'll send you a link to reset your password.
        </p>

        <!-- Forgot Password Form -->
        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <!-- Email Address -->
            <div class="mb-4 text-left">
                <label for="email" class="block text-gray-700 font-semibold">Email</label>
                <input id="email" type="email" name="email" required autofocus autocomplete="email"
                       class="w-full mt-2 p-3 border rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500" />
            </div>

            <!-- Send Reset Link Button -->
            <button type="submit" class="w-full px-6 py-3 bg-indigo-600 text-white font-semibold rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                Send Password Reset Link
            </button>
        </form>

        <!-- Log In Prompt -->
        <p class="mt-6 text-gray-600">
            Remembered your password?
            <a href="{{ route('login') }}" class="text-indigo-600 font-semibold hover:underline">Log In</a>
        </p>
    </div>

</body>
</html>
