<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Like;
use Illuminate\Http\Request;
use App\Notifications\PostLiked;

class LikeController extends Controller
{
    public function toggleLike(Post $post)
    {
    $like = $post->likes()->where('user_id', auth()->id())->first();

    if ($like) 
    {
        $like->delete();
    } 
    
    else 
    {
        $post->likes()->create(['user_id' => auth()->id()]);

        // Notify post author if liked by someone else
        if ($post->user_id !== auth()->id()) {
            $post->user->notify(new PostLiked($post, auth()->user()));
        }
    }
    return back();
    }
}