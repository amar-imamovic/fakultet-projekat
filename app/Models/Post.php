<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'body',
        'is_pinned',
        'is_locked',
    ];

    protected $casts = [
        'is_pinned' => 'boolean',
        'is_locked' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class)->latest();
    }

    public function likes(): HasMany
    {
        return $this->hasMany(Like::class);
    }

    public function isLikedBy(User $user): bool
    {
        return $this->likes()->where('user_id', $user->id)->exists();
    }

    /**
     * Scope to filter only pinned posts.
     */
    public function scopePinned($query): Builder
    {
        return $query->where('is_pinned', true);
    }

    /**
     * Scope to filter only locked posts.
     */
    public function scopeLocked($query): Builder
    {
        return $query->where('is_locked', true);
    }

    /**
     * Scope to filter by status using when() for conditional filtering.
     */
    public function scopeFilterByStatus($query, ?string $status): Builder
    {
        return $query->when($status && $status !== 'all', function ($q) use ($status) {
            match ($status) {
                'pinned' => $q->pinned(),
                'locked' => $q->locked(),
                default => null,
            };
        });
    }

    /**
     * Scope to sort posts by various criteria.
     */
    public function scopeSortBy($query, ?string $sort): Builder
    {
        return match ($sort) {
            'oldest' => $query->oldest(),
            'most_liked' => $query->orderBy('likes_count', 'desc'),
            'most_commented' => $query->orderBy('comments_count', 'desc'),
            default => $query->latest(), // 'latest' or null
        };
    }
}
