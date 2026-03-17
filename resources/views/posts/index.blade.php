@extends('layouts.app')

@section('title', 'Posts')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Posts</h1>
        <a href="{{ route('posts.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Create Post
        </a>
    </div>
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if($posts->count() > 0)
                        <div class="space-y-4">
                            @foreach($posts as $post)
                                <div class="border-b border-gray-200 pb-4 last:border-0">
                                    <div class="flex items-start justify-between">
                                        <div class="flex-1">
                                            <a href="{{ route('posts.show', $post) }}"
                                               class="text-xl font-semibold text-blue-600 hover:text-blue-800">
                                                {{ $post->title }}
                                            </a>
                                            <p class="text-gray-600 mt-1 text-sm">
                                                Posted by <span class="font-medium">{{ $post->user->name }}</span>
                                                • {{ $post->created_at->diffForHumans() }}
                                            </p>
                                            <p class="text-gray-700 mt-2 line-clamp-2">
                                                {{ Str::limit(strip_tags($post->body), 150) }}
                                            </p>
                                        </div>
                                        <div class="flex items-center space-x-4 text-sm text-gray-500 ml-4">
                                            <span class="flex items-center">
                                                <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                          d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                                </svg>
                                                {{ $post->likes_count }}
                                            </span>
                                            <span class="flex items-center">
                                                <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                          d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                                                </svg>
                                                {{ $post->comments_count }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-6">
                            {{ $posts->links() }}
                        </div>
                    @else
                        <p class="text-gray-500 text-center py-8">No posts yet. Be the first to create one!</p>
                    @endif
    </div>
@endsection
