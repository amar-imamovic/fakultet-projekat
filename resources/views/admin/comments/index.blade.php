@extends('admin.dashboard')

@section('content')
    <h1 class="text-2xl font-bold mb-6">Manage Comments</h1>

    <div class="bg-white shadow rounded p-6">
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Comment</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Author</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Post</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($comments as $comment)
                                <tr>
                                    <td class="px-6 py-4 text-sm text-gray-900">
                                        {{ Str::limit($comment->body, 100) }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-900">{{ $comment->user->name }}</td>
                                    <td class="px-6 py-4 text-sm">
                                        <a href="{{ route('admin.posts.show', $comment->post) }}" class="text-blue-600 hover:text-blue-900">
                                            {{ Str::limit($comment->post->title, 30) }}
                                        </a>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500">{{ $comment->created_at->format('M d, Y') }}</td>
                                    <td class="px-6 py-4 text-sm font-medium">
                                        <form method="POST" action="{{ route('admin.comments.destroy', $comment) }}" class="inline"
                                              onsubmit="return confirm('Delete this comment?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="mt-4">
                        {{ $comments->links() }}
                    </div>
    </div>
@endsection
