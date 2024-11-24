<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ShareIT</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.1.2/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-cover bg-center flex items-center justify-center h-screen" style="background-image: url('/images/background.jpg');">
    <div class="bg-white bg-opacity-80 p-8 rounded-lg shadow-lg max-w-md text-center">
        <!-- Logo or App Name -->
        <h1 class="text-4xl font-bold text-gray-800 mb-6">Welcome to ShareIT</h1>

        <!-- Description -->
        <p class="text-gray-600 mb-6">
            Discover and share amazing content with others. Join us to post, comment, and interact with a vibrant community!
        </p>

        <!-- Login and Sign-Up Buttons -->
        <div class="flex justify-center space-x-4">
            <!-- Login Button -->
            <a href="{{ route('login') }}" class="px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">
                Log In
            </a>

            <!-- Sign-Up Button -->
            <a href="{{ route('register') }}" class="px-6 py-2 bg-gray-300 text-gray-800 rounded-lg hover:bg-gray-400">
                Sign Up
            </a>
        </div>
    </div>
</body>
</html>
