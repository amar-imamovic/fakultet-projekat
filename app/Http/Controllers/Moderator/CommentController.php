<?php

namespace App\Http\Controllers\Moderator;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function index(Request $request)
    {
        $comments = Comment::with(['user', 'post'])
            ->latest()
            ->paginate(20);

        return view('moderator.comments.index', compact('comments'));
    }

    public function destroy(Comment $comment)
    {
        $comment->delete();

        return redirect()
            ->route('moderator.comments.index')
            ->with('success', 'Comment deleted successfully!');
    }
}
