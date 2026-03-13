<div>
    <h1>ADMIN ROLES INDEX</h1>

    <a href="{{ route('admin.roles.create') }}">Create</a>

    @foreach ($roles as $role)
        <h3>Name: {{ $role->name }}</h3>
    @endforeach
</div>
