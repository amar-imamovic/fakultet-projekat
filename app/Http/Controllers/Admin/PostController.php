<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Post\IndexRequest;
use App\Http\Requests\Admin\Post\UpdateRequest;
use App\Models\Post;

class PostController extends Controller
{
    public function index(IndexRequest $request)
    {
        $validated = $request->safe();

        $posts = Post::with(['user', 'comments', 'likes'])
            ->withCount('comments', 'likes')
            ->filterByStatus($validated->status)
            ->sortBy($validated->sort)
            ->paginate(20)
            ->withQueryString();

        return view('admin.posts.index', compact('posts'));
    }

    public function show(Post $post)
    {
        $post->load(['user', 'comments.user', 'likes']);
        $post->loadCount('comments', 'likes');

        return view('admin.posts.show', compact('post'));
    }

    public function edit(Post $post)
    {
        return view('admin.posts.edit', compact('post'));
    }

    public function update(UpdateRequest $request, Post $post)
    {
        $post->update($request->validated());

        return redirect()
            ->route('admin.posts.index')
            ->with('success', 'Post updated successfully!');
    }

    public function destroy(Post $post)
    {
        $post->delete();

        return redirect()
            ->route('admin.posts.index')
            ->with('success', 'Post deleted successfully!');
    }

    public function togglePin(Post $post)
    {
        $post->update(['is_pinned' => !$post->is_pinned]);

        $status = $post->is_pinned ? 'pinned' : 'unpinned';
        return back()->with('success', "Post {$status} successfully!");
    }

    public function toggleLock(Post $post)
    {
        $post->update(['is_locked' => !$post->is_locked]);

        $status = $post->is_locked ? 'locked' : 'unlocked';
        return back()->with('success', "Post {$status} successfully!");
    }
}
