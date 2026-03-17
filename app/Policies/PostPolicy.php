<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Str;

class PostPolicy
{
    public function update(User $user, Post $post): bool
    {
        return $user->id === $post->user_id
            || Str::lower($user->role?->name) === 'admin'
            || Str::lower($user->role?->name) === 'moderator';
    }

    public function delete(User $user, Post $post): bool
    {
        return $user->id === $post->user_id
            || Str::lower($user->role?->name) === 'admin'
            || Str::lower($user->role?->name) === 'moderator';
    }
}
