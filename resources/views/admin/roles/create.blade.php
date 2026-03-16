@extends('admin.dashboard')

@section('content')
    <h1>Create Role</h1>

    @include('components.messages')

    <form action="{{ route('admin.roles.store') }}" method="POST">

        @csrf

        <div>
            <label>Role Name</label>

            <input type="text" name="name" value="{{ old('name') }}">
        </div>

        <br>

        <button type="submit">Create Role</button>

    </form>
@endsection
