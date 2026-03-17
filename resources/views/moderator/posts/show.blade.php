@extends('moderator.dashboard')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Moderate Post</h1>
        <div class="flex space-x-4">
            <a href="{{ route('moderator.posts.index') }}" class="text-gray-600 hover:text-gray-900">
                ← Back to Posts
            </a>
            <a href="{{ route('posts.show', $post) }}" class="text-blue-600 hover:text-blue-800">
                View Public →
            </a>
        </div>
    </div>

    <div class="bg-white shadow rounded p-6">
        <!-- Post Details -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
            <div class="p-6">
                <div class="flex justify-between items-start">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">{{ $post->title }}</h1>
                        <p class="text-sm text-gray-500 mt-1">
                            By {{ $post->user->name }} • {{ $post->created_at->format('M d, Y \a\t g:i A') }}
                        </p>
                    </div>
                    @if ($post->is_locked)
                        <span class="px-3 py-1 bg-red-100 text-red-800 rounded-full text-sm">Locked</span>
                    @endif
                </div>

                <div class="mt-4 p-4 bg-gray-50 rounded text-gray-700 whitespace-pre-wrap">{{ $post->body }}</div>

                <div class="mt-4 flex space-x-4 text-sm text-gray-600">
                    <span>{{ $post->likes_count }} Likes</span>
                    <span>{{ $post->comments_count }} Comments</span>
                </div>

                <div class="mt-6 flex space-x-2">
                    <form method="POST" action="{{ route('moderator.posts.lock', $post) }}">
                        @csrf
                        <button type="submit"
                            class="bg-{{ $post->is_locked ? 'gray' : 'yellow' }}-600 hover:bg-{{ $post->is_locked ? 'gray' : 'yellow' }}-700 text-white px-4 py-2 rounded">
                            {{ $post->is_locked ? 'Unlock' : 'Lock' }}
                        </button>
                    </form>
                    <form method="POST" action="{{ route('moderator.posts.destroy', $post) }}"
                        onsubmit="return confirm('Delete this post?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded">Delete</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Comments -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Comments ({{ $post->comments_count }})</h3>

                @if ($post->comments->count() > 0)
                    <div class="space-y-4">
                        @foreach ($post->comments as $comment)
                            <div class="border-b border-gray-200 pb-4 last:border-0">
                                <div class="flex justify-between items-start">
                                    <div class="flex-1">
                                        <p class="text-sm text-gray-500 mb-1">
                                            <span class="font-medium text-gray-900">{{ $comment->user->name }}</span>
                                            • {{ $comment->created_at->format('M d, Y \a\t g:i A') }}
                                        </p>
                                        <p class="text-gray-700">{{ $comment->body }}</p>
                                    </div>
                                    <form method="POST" action="{{ route('moderator.comments.destroy', $comment) }}"
                                        onsubmit="return confirm('Delete this comment?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="text-red-600 hover:text-red-800 text-sm">Delete</button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500">No comments yet.</p>
                @endif
            </div>
        @endsection
