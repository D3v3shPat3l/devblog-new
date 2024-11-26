<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\NewsService;

class PostController extends Controller
{
    protected $newsService;

    public function __construct(NewsService $newsService)
    {
        $this->newsService = $newsService;
    }

    // Show the dashboard page with all posts and comments and news
    public function index()
    {
        $posts = Post::with(['comments.user', 'user'])->latest()->paginate(3);
        $news = $this->newsService->getTopHeadlines('us', 1);

        return view('dashboard', compact('posts','news'));
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

    public function edit(Post $post)
    {
    if (auth()->user()->id !== $post->user_id && !auth()->user()->hasRole('editor')) {
        abort(403, 'You are not authorized to edit this post.');
    }

    return view('posts.edit', compact('post'));
    }

public function destroy(Post $post)
    {
    if (auth()->user()->id !== $post->user_id && !auth()->user()->hasRole('admin')) {
        abort(403, 'You are not authorized to delete this post.');
    }

    $post->delete();
    return redirect()->route('dashboard')->with('success', 'Post deleted successfully.');
    }
}
