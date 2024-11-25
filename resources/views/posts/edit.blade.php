<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Post</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.1.2/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-cover bg-center flex flex-col items-center min-h-screen" style="background-image: url('/images/background.jpg');">
    
    <!-- Logout Button -->
    <div class="w-full max-w-2xl flex justify-end p-4">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                Log Out
            </button>
        </form>
    </div>

    <!-- Main Edit Post Content -->
    <div class="bg-white bg-opacity-90 p-8 rounded-lg shadow-lg max-w-2xl w-full mt-16"> <!-- Added mt-16 for margin-top -->
        <h1 class="text-3xl font-bold text-gray-800 mb-4 text-center">Edit Post</h1>
        
        <!-- Edit Form -->
        <form action="{{ route('posts.update', $post->id) }}" method="POST" class="mb-6">
            @csrf
            @method('PATCH')
            <div class="mb-4">
                <input type="text" name="title" class="w-full p-2 border border-gray-300 rounded-lg" value="{{ old('title', $post->title) }}" placeholder="Post title" required>
            </div>
            <div class="mb-4">
                <textarea name="content" rows="5" class="w-full p-2 border border-gray-300 rounded-lg" placeholder="What's on your mind?" required>{{ old('content', $post->content) }}</textarea>
            </div>
            <button type="submit" class="w-full py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">
                Update Post
            </button>
        </form>
    </div>
</body>
</html>