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
@endsection
