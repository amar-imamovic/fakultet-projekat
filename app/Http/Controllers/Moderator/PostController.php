<?php

namespace App\Http\Controllers\Moderator;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $posts = Post::with(['user', 'comments', 'likes'])
            ->withCount('comments', 'likes')
            ->latest()
            ->paginate(20);

        return view('moderator.posts.index', compact('posts'));
    }

    public function show(Post $post)
    {
        $post->load(['user', 'comments.user', 'likes']);
        $post->loadCount('comments', 'likes');

        return view('moderator.posts.show', compact('post'));
    }

    public function toggleLock(Post $post)
    {
        $post->update(['is_locked' => !$post->is_locked]);

        $status = $post->is_locked ? 'locked' : 'unlocked';
        return back()->with('success', "Post {$status} successfully!");
    }

    public function destroy(Post $post)
    {
        $post->delete();

        return redirect()
            ->route('moderator.posts.index')
            ->with('success', 'Post deleted successfully!');
    }
}
