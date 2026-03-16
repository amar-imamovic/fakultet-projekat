@extends('admin.dashboard')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Users</h1>

        <a href="{{ route('admin.users.create') }}"
            class="text-blue-50 py-2 bg-blue-600 px-4 font-bold rounded-md border-blue-600 border-x-2 border-y-2 hover:bg-white hover:text-blue-600 transition-all duration-150">
            Create User
        </a>
    </div>

    <div class="bg-white shadow rounded">

        <table class="w-full">

            <thead class="border-b bg-gray-100">
                <tr>
                    <th class="p-3 text-left">Name</th>
                    <th class="p-3 text-left">Email</th>
                    <th class="p-3 text-left">Role</th>
                    <th class="p-3 text-center">Actions</th>
                </tr>
            </thead>

            <tbody>

                @foreach ($users as $user)
                    <tr class="border-b">

                        <td class="p-3">{{ $user->name }}</td>
                        <td class="p-3">{{ $user->email }}</td>
                        <td class="p-3">{{ $user->role->name }}</td>

                        <td class="p-3 flex justify-center overflow-hidden">
                            <div class="grid grid-flow-col grid-cols-3 w-full gap-3 text-center">

                                <a href="{{ route('admin.users.show', $user) }}"
                                    class="text-gray-200 bg-gray-700 border-x-2 border-y-2 border-gray-700 py-1 font-bold rounded-md hover:bg-white hover:text-gray-700 transition-all duration-150">
                                    View
                                </a>

                                <a href="{{ route('admin.users.edit', $user) }}"
                                    class="text-blue-50 py-1 bg-blue-600 w-full font-bold rounded-md border-blue-600 border-x-2 border-y-2 hover:bg-white hover:text-blue-600 transition-all duration-150">
                                    Edit
                                </a>

                                @if (auth()->id() !== $user->id)
                                    <form method="POST" action="{{ route('admin.users.destroy', $user) }}">

                                        @csrf
                                        @method('DELETE')

                                        <button
                                            class="text-red-50 py-1 bg-red-600 w-full font-bold rounded-md border-red-600 border-x-2 border-y-2 hover:bg-white hover:text-red-600 hover:border-red-600 transition-all duration-150">
                                            Delete
                                        </button>

                                    </form>
                                @endif
                            </div>

                        </td>

                    </tr>
                @endforeach

            </tbody>

        </table>

    </div>
@endsection
