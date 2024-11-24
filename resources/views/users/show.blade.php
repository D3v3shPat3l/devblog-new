<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $user->name }}'s Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.1.2/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-cover bg-center flex flex-col items-center min-h-screen" style="background-image: url('/images/background.jpg');">

<!-- Roles Dropdown Section -->
<div class="w-full max-w-2xl flex justify-between p-4">
    <div class="relative">
        <button id="rolesButton" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
            Roles
        </button>
        <div id="rolesDropdown" class="absolute bg-white border rounded-lg shadow-lg mt-2 right-0 w-48 hidden">
            <button class="block px-4 py-2 text-gray-700 hover:bg-gray-100 w-full text-left" onclick="changeRole('Admin')">Admin</button>
            <button class="block px-4 py-2 text-gray-700 hover:bg-gray-100 w-full text-left" onclick="changeRole('Editor')">Editor</button>
            <button class="block px-4 py-2 text-gray-700 hover:bg-gray-100 w-full text-left" onclick="changeRole('Viewer')">Viewer</button>
        </div>
    </div>
</div>

<!-- Profile Content -->
<div class="bg-white bg-opacity-90 p-8 rounded-lg shadow-lg max-w-2xl w-full">
    <h1 class="text-3xl font-bold text-gray-800 mb-4 text-center">{{ $user->name }}'s History</h1>

    <!-- Posts Section -->
    <h2 class="text-2xl font-semibold text-gray-800 mb-4">Posts</h2>
    @if($posts->isEmpty())
        <p class="text-gray-600 text-center">No posts found.</p>
    @else
        @foreach($posts as $post)
            <div class="bg-gray-100 p-4 rounded-lg shadow mb-6">
                <h3 class="text-xl font-semibold text-gray-800">{{ $post->title }}</h3>
                <p class="text-gray-700">{{ $post->content }}</p>
                <p class="text-sm text-gray-500 mt-2">Posted on {{ $post->created_at->format('M d, Y') }}</p>

                <!-- Display Post Image -->
                @if($post->image)
                    <img src="{{ asset('storage/' . $post->image) }}" alt="Post Image" class="w-full h-64 object-cover mt-2 rounded-lg">
                @endif

                <!-- Edit and Delete Buttons -->
                <div class="mt-4 flex space-x-2 role-dependent">
                    @if(auth()->user()->id === $post->user_id || auth()->user()->hasRole('admin'))
                        <a href="{{ route('posts.edit', $post->id) }}" class="px-4 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 edit-button">
                            Edit
                        </a>
                        <form action="{{ route('posts.destroy', $post->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this post?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 delete-button">
                                Delete
                            </button>
                        </form>
                    @endif
                </div>

                <!-- Comments Section -->
                <div class="mt-4">
                    <h4 class="text-lg font-semibold text-gray-800">Comments</h4>
                    @if($post->comments->isEmpty())
                        <p class="text-gray-600">No comments yet.</p>
                    @else
                        @foreach($post->comments as $comment)
                            <div class="bg-white p-2 mt-2 rounded-lg shadow-sm">
                                <p class="text-gray-700">{{ $comment->content }}</p>
                                <p class="text-xs text-gray-500">Commented on {{ $comment->created_at->format('M d, Y') }}</p>
                                @if(auth()->user()->id === $comment->user_id || auth()->user()->hasRole('admin'))
                                    <form action="{{ route('comments.destroy', $comment->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this comment?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800 mt-2 edit-delete">
                                            Delete Comment
                                        </button>
                                    </form>
                                @endif
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        @endforeach
    @endif

    <!-- Comments Section -->
    <h2 class="text-2xl font-semibold text-gray-800 mt-8 mb-4">All Comments</h2>
    @if($comments->isEmpty())
        <p class="text-gray-600 text-center">No comments found.</p>
    @else
        @foreach($comments as $comment)
            <div class="bg-gray-100 p-4 rounded-lg shadow mb-6">
                <p class="text-gray-700">{{ $comment->content }}</p>
                <p class="text-xs text-gray-500">Commented on {{ $comment->created_at->format('M d, Y') }}</p>
            </div>
        @endforeach
    @endif
</div>

<!-- JavaScript Section -->
<script>
    // Toggle the roles dropdown
    document.getElementById('rolesButton').addEventListener('click', function () {
        const dropdown = document.getElementById('rolesDropdown');
        dropdown.classList.toggle('hidden');
    });

    // Change role and display a popup message
    function changeRole(role) {
        alert(`Role changed to ${role}`);
        const dropdown = document.getElementById('rolesDropdown');
        dropdown.classList.add('hidden'); // Close dropdown after selection

        // Hide or show buttons based on role
        const editButtons = document.querySelectorAll('.edit-button');
        const deleteButtons = document.querySelectorAll('.delete-button');

        if (role === 'Editor') {
            // Show only Edit buttons
            editButtons.forEach(button => button.classList.remove('hidden'));
            deleteButtons.forEach(button => button.classList.add('hidden'));
        } else if (role === 'Viewer') {
            // Hide all Edit and Delete buttons
            editButtons.forEach(button => button.classList.add('hidden'));
            deleteButtons.forEach(button => button.classList.add('hidden'));
        } else {
            // Show both Edit and Delete buttons for Admin or other roles
            editButtons.forEach(button => button.classList.remove('hidden'));
            deleteButtons.forEach(button => button.classList.remove('hidden'));
        }
    }

    // Close the dropdown if clicked outside
    window.addEventListener('click', function (e) {
        const dropdown = document.getElementById('rolesDropdown');
        const button = document.getElementById('rolesButton');
        if (!dropdown.contains(e.target) && !button.contains(e.target)) {
            dropdown.classList.add('hidden');
        }
    });
</script>

</body>
</html>
