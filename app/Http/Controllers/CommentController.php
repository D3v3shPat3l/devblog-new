<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use App\Models\Like;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Notifications\NewCommentNotification;

class CommentController extends Controller
{
    /**
     * Store a new comment
     */
    public function store(Request $request, $postId)
    {
        $request->validate([
            'content' => 'required|string|max:300',
        ]);

        $post = Post::findOrFail($postId);

        // Create the comment
        $comment = Comment::create([
            'post_id' => $post->id,
            'user_id' => Auth::id(),
            'content' => $request->content,
        ]);

        // Notify the post owner if it's not the current user
        if ($post->user_id !== Auth::id()) {
            $post->user->notify(new NewCommentNotification($comment));
        }

        // Check if the request is AJAX
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'comment' => [
                    'id' => $comment->id,
                    'content' => $comment->content,
                    'user_name' => Auth::user()->name,
                    'created_at' => $comment->created_at->format('M d, Y'),
                ],
            ]);
        }

        // Fallback for regular form submission
        return redirect()->route('dashboard')->with('success', 'Comment added successfully');
    }

    /**
     * Delete a comment
     */
    public function destroy(Comment $comment)
    {
        if (auth()->user()->id !== $comment->user_id && !auth()->user()->hasRole('moderator')) {
            abort(403, 'You are not authorized to delete this comment.');
        }
    
        $comment->delete();
        return back()->with('success', 'Comment deleted successfully.');
    }

    /**
     * Like a comment
     */
    public function like(Comment $comment)
    {
        // Check if the user has already liked the comment
        $like = Like::where('user_id', auth()->id())
                    ->where('likeable_id', $comment->id)
                    ->where('likeable_type', Comment::class)
                    ->first();

        if ($like) {
            // If the user already liked the comment, remove the like (unlike)
            $like->delete();
        } else {
            // If the user hasn't liked it yet, create a new like
            $comment->likes()->create([
                'user_id' => auth()->id(),
            ]);
        }

        // Return back to the previous page
        return back();
    }
}
