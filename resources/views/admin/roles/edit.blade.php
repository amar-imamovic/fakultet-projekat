@extends('admin.dashboard')

@section('content')
    <h1>Edit Role</h1>

    @include('components.messages')

    <form action="{{ route('admin.roles.update', $role) }}" method="POST">

        @csrf
        @method('PUT')

        <div>
            <label>Role Name</label>

            <input type="text" name="name" value="{{ old('name', $role->name) }}">
        </div>

        <br>

        <button type="submit">Update Role</button>

    </form>


@section('content')
    <h1 class="text-2xl font-bold mb-6">Edit Role</h1>

    <div class="bg-white shadow rounded p-6">

        <form method="POST" action="{{ route('admin.roles.update', $role) }}">

            @csrf
            @method('PUT')

            <div class="mb-4">

                <label>Name</label>

                <input type="text" name="name" value="{{ old('name', $role->name) }}"
                    class="border w-full p-2 rounded">

                @error('name')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror

            </div>


            <div class="flex gap-4 mt-4"> <button class="bg-blue-600 text-white px-4 py-2 rounded"> Update </button> <a
                    href="{{ route('admin.roles.index') }}" class="bg-gray-600 text-white px-4 py-2 rounded"> Back </a>
            </div>

        </form>

    </div>
@endsection

@endsection
