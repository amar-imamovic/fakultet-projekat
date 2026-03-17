<?php

namespace App\Policies;

use App\Models\Comment;
use App\Models\User;
use Illuminate\Support\Str;

class CommentPolicy
{
    public function delete(User $user, Comment $comment): bool
    {
        return $user->id === $comment->user_id
            || Str::lower($user->role?->name) === 'admin'
            || Str::lower($user->role?->name) === 'moderator';
    }
}
