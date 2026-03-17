@extends('layouts.app')

@section('title', $post->title)

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">View Post</h1>
        <a href="{{ route('posts.index') }}" class="text-gray-600 hover:text-gray-900">
            ← Back to Posts
        </a>
    </div>
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Post -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="flex justify-between items-start">
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900">{{ $post->title }}</h1>
                            <p class="text-sm text-gray-500 mt-1">
                                Posted by {{ $post->user->name }} • {{ $post->created_at->format('M d, Y \a\t g:i A') }}
                                @if($post->is_locked)
                                    <span class="ml-2 px-2 py-1 bg-red-100 text-red-800 text-xs rounded">Locked</span>
                                @endif
                            </p>
                        </div>
                        @can('update', $post)
                            <div class="flex space-x-2">
                                <a href="{{ route('posts.edit', $post) }}" class="text-blue-600 hover:text-blue-800 text-sm">Edit</a>
                                <form method="POST" action="{{ route('posts.destroy', $post) }}" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800 text-sm"
                                            onclick="return confirm('Are you sure?')">Delete</button>
                                </form>
                            </div>
                        @endcan
                    </div>

                    <div class="mt-4 text-gray-700 whitespace-pre-wrap">{{ $post->body }}</div>

                    <!-- Like Button -->
                    <div class="mt-6 flex items-center space-x-4">
                        <form method="POST" action="{{ route('posts.like', $post) }}">
                            @csrf
                            <button type="submit"
                                    class="flex items-center space-x-2 {{ $post->isLikedBy(auth()->user()) ? 'text-red-600' : 'text-gray-500' }} hover:text-red-600">
                                <svg class="w-6 h-6 {{ $post->isLikedBy(auth()->user()) ? 'fill-current' : 'fill-none' }}"
                                     stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                </svg>
                                <span>{{ $post->likes_count }} {{ Str::plural('Like', $post->likes_count) }}</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Comments Section -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">
                        {{ $post->comments_count }} {{ Str::plural('Comment', $post->comments_count) }}
                    </h3>

                    <!-- Comment Form -->
                    @if(!$post->is_locked)
                        <form method="POST" action="{{ route('comments.store', $post) }}" class="mb-6">
                            @csrf
                            <div class="mb-3">
                                <textarea name="body" rows="3" placeholder="Write a comment..." required
                                          class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"></textarea>
                                @error('body')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <button type="submit"
                                    class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Post Comment
                            </button>
                        </form>
                    @else
                        <div class="bg-gray-100 p-4 rounded mb-6 text-gray-600">
                            This post is locked. No new comments can be added.
                        </div>
                    @endif

                    <!-- Comments List -->
                    <div class="space-y-4">
                        @foreach($post->comments as $comment)
                            <div class="border-b border-gray-200 pb-4 last:border-0">
                                <div class="flex justify-between items-start">
                                    <div class="flex-1">
                                        <p class="text-sm text-gray-500 mb-1">
                                            <span class="font-medium text-gray-900">{{ $comment->user->name }}</span>
                                            • {{ $comment->created_at->diffForHumans() }}
                                        </p>
                                        <p class="text-gray-700">{{ $comment->body }}</p>
                                    </div>
                                    @can('delete', $comment)
                                        <form method="POST" action="{{ route('comments.destroy', [$post, $comment]) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-800 text-sm"
                                                    onclick="return confirm('Delete this comment?')">Delete</button>
                                        </form>
                                    @endcan
                                </div>
                            </div>
                        @endforeach
                    </div>
    </div>
@endsection
