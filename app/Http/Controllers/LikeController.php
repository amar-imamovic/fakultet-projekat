<?php

namespace App\Http\Controllers;

use App\Models\Post;

class LikeController extends Controller
{
    public function toggle(Post $post)
    {
        $like = $post->likes()->where('user_id', auth()->id())->first();

        if ($like) {
            $like->delete();
            $message = 'Post unliked!';
        } else {
            $post->likes()->create(['user_id' => auth()->id()]);
            $message = 'Post liked!';
        }

        if (request()->ajax()) {
            return response()->json([
                'likes_count' => $post->likes()->count(),
                'liked' => !$like,
            ]);
        }

        return back()->with('success', $message);
    }
}
