<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirm Password</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.1.2/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-cover bg-center h-screen flex items-center justify-center" style="background-image: url('/images/background.jpg');">

    <!-- Form Container -->
    <div class="bg-white bg-opacity-90 p-8 rounded-lg shadow-lg w-full max-w-md text-center">

        <!-- Confirmation Message -->
        <div class="mb-4 text-sm text-gray-600">
            {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
        </div>

        <!-- Confirmation Form -->
        <form method="POST" action="{{ route('password.confirm') }}">
            @csrf

            <!-- Password -->
            <div class="mb-4 text-left">
                <label for="password" class="block text-gray-700 font-semibold">{{ __('Password') }}</label>
                <input id="password" type="password" name="password" required autocomplete="current-password"
                       class="w-full mt-2 p-3 border rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500" />
                @error('password')
                    <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                @enderror
            </div>

            <div class="flex justify-end mt-4">
                <button type="submit" class="px-6 py-2 bg-indigo-600 text-white font-semibold rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    {{ __('Confirm') }}
                </button>
            </div>
        </form>
    </div>

</body>
</html>
