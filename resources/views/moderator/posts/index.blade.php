@extends('moderator.dashboard')

@section('content')
    <h1 class="text-2xl font-bold mb-6">Moderate Posts</h1>

    <div class="bg-white shadow rounded p-6">
        <div class="flex justify-between items-center mb-4">
            <a href="{{ route('posts.index') }}" class="text-blue-600 hover:text-blue-800">
                View Public Posts →
            </a>
        </div>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Title</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Author</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Stats</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($posts as $post)
                                <tr>
                                    <td class="px-6 py-4">
                                        <a href="{{ route('moderator.posts.show', $post) }}"
                                            class="text-blue-600 hover:text-blue-900 font-medium">
                                            {{ Str::limit($post->title, 50) }}
                                        </a>
                                        <p class="text-xs text-gray-500">{{ $post->created_at->format('M d, Y') }}</p>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-900">{{ $post->user->name }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-500">
                                        {{ $post->likes_count }} likes, {{ $post->comments_count }} comments
                                    </td>
                                    <td class="px-6 py-4">
                                        @if ($post->is_locked)
                                            <span class="px-2 py-1 text-xs bg-red-100 text-red-800 rounded">Locked</span>
                                        @else
                                            <span class="px-2 py-1 text-xs bg-green-100 text-green-800 rounded">Open</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-sm font-medium">
                                        <div class="flex space-x-2">
                                            <form method="POST" action="{{ route('moderator.posts.lock', $post) }}"
                                                class="inline">
                                                @csrf
                                                <button type="submit"
                                                    class="text-{{ $post->is_locked ? 'gray' : 'yellow' }}-600 hover:text-{{ $post->is_locked ? 'gray' : 'yellow' }}-900">
                                                    {{ $post->is_locked ? 'Unlock' : 'Lock' }}
                                                </button>
                                            </form>
                                            <form method="POST" action="{{ route('moderator.posts.destroy', $post) }}"
                                                class="inline" onsubmit="return confirm('Delete this post?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="text-red-600 hover:text-red-900">Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="mt-4">
                        {{ $posts->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
