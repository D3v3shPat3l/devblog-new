<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    // Show the dashboard page with all posts and comments
    public function index()
    {
        $posts = Post::with(['comments.user', 'user'])->latest()->paginate(3);
        return view('dashboard', compact('posts'));
    }

    // Store a new post
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string|max:500',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public');
        }

        Post::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'content' => $request->content,
            'image' => $imagePath,
        ]);

        return redirect()->route('dashboard')->with('success', 'Post created successfully');
    }

    // Show the edit post form
    public function edit(Post $post)
    {
        // Check if the user is authorized to edit the post
        if (Auth::id() !== $post->user_id && !Auth::user()->hasRole('admin')) {
            return redirect()->route('dashboard')->with('error', 'Unauthorized action.');
        }

        return view('posts.edit', compact('post'));
    }

    // Update the specified post in storage
    public function update(Request $request, Post $post)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string|max:500',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $imagePath = $post->image;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public');
        }

        $post->update([
            'title' => $request->title,
            'content' => $request->content,
            'image' => $imagePath,
        ]);

        return redirect()->route('dashboard')->with('success', 'Post updated successfully');
    }

    // Delete the specified post
    public function destroy(Post $post)
    {
        // Check if the user is authorized to delete the post
        if (Auth::id() !== $post->user_id && !Auth::user()->hasRole('admin')) {
            return redirect()->route('dashboard')->with('error', 'Unauthorized action.');
        }

        // Delete the post
        $post->delete();
        return redirect()->route('dashboard')->with('success', 'Post deleted successfully.');
    }
}
