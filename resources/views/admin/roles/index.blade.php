@extends('admin.dashboard')

@section('content')
    <h1>Roles</h1>

    @include('components.messages')

    <a href="{{ route('admin.roles.create') }}">Create Role</a>

    <table border="1" cellpadding="8">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Actions</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($roles as $role)
                <tr>
                    <td>{{ $role->id }}</td>
                    <td>{{ $role->name }}</td>

                    <td>

                        <a href="{{ route('admin.roles.show', $role) }}">View</a>

                        <a href="{{ route('admin.roles.edit', $role) }}">Edit</a>

                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
