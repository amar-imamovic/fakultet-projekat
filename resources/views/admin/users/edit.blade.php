@extends('admin.dashboard')

@section('content')
    <h1 class="text-2xl font-bold mb-6">Edit User</h1>

    <div class="bg-white shadow rounded p-6">

        <form method="POST" action="{{ route('admin.users.update', $user) }}">

            @csrf
            @method('PUT')

            <div class="mb-4">

                <label>Name</label>

                <input type="text" name="name" value="{{ old('name', $user->name) }}" class="border w-full p-2 rounded">

                @error('name')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror

            </div>


            <div class="mb-4">

                <label>Email</label>

                <input type="email" name="email" value="{{ old('email', $user->email) }}"
                    class="border w-full p-2 rounded">

                @error('email')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror

            </div>


            <div class="mb-4">

                <label>Role</label>

                <select name="role_id" class="border w-full p-2 rounded">

                    @foreach ($roles as $role)
                        <option value="{{ $role->id }}" @if (old('role_id', $user->role_id) == $role->id) selected @endif>

                            {{ $role->name }}

                        </option>
                    @endforeach

                </select>

                @error('role_id')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror

            </div>


            <div class="flex gap-4 mt-4"> <button class="bg-blue-600 text-white px-4 py-2 rounded"> Update </button> <a
                    href="{{ route('admin.users.index') }}" class="bg-gray-600 text-white px-4 py-2 rounded"> Back </a>
            </div>

        </form>

    </div>
@endsection
