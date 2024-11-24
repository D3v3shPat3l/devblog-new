<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.1.2/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-cover bg-center flex flex-col items-center min-h-screen" style="background-image: url('/images/background.jpg');">

    <!-- Logout Button and Notifications -->
    <div class="w-full max-w-2xl flex justify-between p-4">
        <!-- Notifications Dropdown -->
        <div class="relative">
            <button class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700" id="notificationDropdown">
                Notifications
                @if(auth()->user()->unreadNotifications->count())
                    <span class="bg-red-500 text-white rounded-full px-2">{{ auth()->user()->unreadNotifications->count() }}</span>
                @endif
            </button>
            <div class="absolute right-0 mt-2 w-64 bg-white border rounded-lg shadow-lg" style="display: none;" id="notificationMenu">
                <div class="py-2">
                    @forelse(auth()->user()->unreadNotifications as $notification)
                        <div class="px-4 py-2 border-b">
                            <p>
                                <strong>{{ $notification->data['commenter_name'] ?? $notification->data['liker_name'] }}</strong>
                                @if(isset($notification->data['comment_content']))
                                    commented on <strong>{{ $notification->data['post_title'] }}</strong>:
                                    <p>{{ $notification->data['comment_content'] }}</p>
                                @else
                                    liked your post <strong>{{ $notification->data['post_title'] }}</strong>.
                                @endif
                            </p>
                            <p class="text-xs text-gray-500">{{ $notification->created_at->diffForHumans() }}</p>
                        </div>
                    @empty
                        <p class="px-4 py-2 text-gray-600">No new notifications</p>
                    @endforelse
                </div>
                <!-- Mark all as read button -->
                <form action="{{ route('notifications.markAsRead') }}" method="POST" class="p-2 text-center">
                    @csrf
                    <button type="submit" class="text-blue-600 hover:underline">Mark all as read</button>
                </form>
            </div>
        </div>

        <!-- Logout Button -->
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                Log Out
            </button>
        </form>
    </div>

    <!-- Main Dashboard Content -->
    <div class="bg-white bg-opacity-90 p-8 rounded-lg shadow-lg max-w-2xl w-full mt-10">
        <h1 class="text-3xl font-bold text-gray-800 mb-4 text-center">Welcome to Your Dashboard, {{ auth()->user()->name }}!</h1>
        <p class="text-gray-600 text-center mb-6">Share your thoughts and engage with the community!</p>

        <!-- Post Creation Form -->
        <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data" class="mb-6">
            @csrf
            <div class="mb-4">
                <input type="text" name="title" class="w-full p-2 border border-gray-300 rounded-lg" placeholder="Post title" required>
                @error('title')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-4">
                <textarea name="content" rows="3" class="w-full p-2 border border-gray-300 rounded-lg" placeholder="What's on your mind?" required></textarea>
                @error('content')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="mb-4">
                <input type="file" name="image" accept="image/*" class="w-full p-2 border border-gray-300 rounded-lg">
                @error('image')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            <button type="submit" class="w-full py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">
                Post
            </button>
        </form>

        <!-- Display Posts and Comments -->
        <div>
            @foreach($posts as $post)
                <div class="bg-gray-100 p-4 rounded-lg shadow mb-6">
                    <h2 class="text-xl font-semibold text-gray-800">{{ $post->title }}</h2>
                    @if($post->image)
                        <img src="{{ asset('storage/' . $post->image) }}" alt="Post Image" class="w-full h-64 object-cover mt-2 rounded-lg">
                    @endif
                    <p class="text-gray-700">{{ $post->content }}</p>
                    <p class="text-sm text-gray-500 mt-2">
                        Posted by 
                        <a href="{{ route('users.show', $post->user->id) }}" class="text-indigo-600 hover:underline">{{ $post->user->name }}</a> 
                        on {{ $post->created_at->format('M d, Y') }}
                    </p>

                    <!-- Like Button and Count -->
                    <div class="mt-2 flex items-center space-x-2">
                        <form action="{{ route('posts.like', $post) }}" method="POST">
                            @csrf
                            <button type="submit" class="px-4 py-2 rounded-lg 
                                {{ $post->likes->contains('user_id', auth()->id()) ? 'bg-red-500 text-white' : 'bg-gray-300 text-gray-800' }}">
                                {{ $post->likes->contains('user_id', auth()->id()) ? 'Unlike' : 'Like' }}
                            </button>
                        </form>
                        <span>{{ $post->likes()->count() }} likes</span>
                    </div>

                    <!-- Comments Section -->
                    <div class="mt-4">
                        <h3 class="text-lg font-semibold text-gray-800">Comments</h3>
                        @foreach($post->comments as $comment)
                            <div class="bg-white p-2 mt-2 rounded-lg shadow-sm">
                                <p class="text-gray-700">{{ $comment->content }}</p>
                                <p class="text-xs text-gray-500">Commented by 
                                    <a href="{{ route('users.show', $comment->user->id) }}" class="text-indigo-600 hover:underline">{{ $comment->user->name }}</a> 
                                    on {{ $comment->created_at->format('M d, Y') }}
                                </p>

                                <!-- Delete Comment Option -->
                                @if(auth()->user()->id === $comment->user_id || auth()->user()->hasRole('admin'))
                                    <form action="{{ route('comments.destroy', $comment->id) }}" method="POST" class="mt-2" onsubmit="return confirm('Are you sure you want to delete this comment?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800">
                                            Delete Comment
                                        </button>
                                    </form>
                                @endif
                            </div>
                        @endforeach
                    </div>

                    <!-- Comment Form -->
                    <form action="{{ route('comments.store', $post->id) }}" method="POST" class="mt-4">
                        @csrf
                        <textarea name="content" rows="2" class="w-full p-2 border border-gray-300 rounded-lg" placeholder="Write a comment..." required></textarea>
                        <button type="submit" class="w-full mt-2 py-2 bg-gray-300 text-gray-800 rounded-lg hover:bg-gray-400">
                            Comment
                        </button>
                    </form>

                    <!-- Edit and Delete Buttons -->
                    @if(auth()->user()->hasRole('admin') || auth()->user()->id == $post->user_id)
                        <div class="flex space-x-2 mt-4">
                            <a href="{{ route('posts.edit', $post->id) }}" class="px-4 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600">
                                Edit
                            </a>
                            <form action="{{ route('posts.destroy', $post->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                                    Delete
                                </button>
                            </form>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>

        <!-- Pagination Links -->
        <div class="mt-6">
            {{ $posts->links() }} 
        </div>
    </div>

    <script>
        document.getElementById('notificationDropdown').addEventListener('click', function() {
            var menu = document.getElementById('notificationMenu');
            menu.style.display = menu.style.display === 'none' ? 'block' : 'none';
        });
    </script>
</body>
</html>
