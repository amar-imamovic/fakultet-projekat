@extends('admin.dashboard')

@section('content')
    <h1 class="text-2xl font-bold mb-6">Role Details</h1>

    <div class="bg-white shadow rounded p-6 space-y-4">

        <div>
            <strong>Id:</strong>
            {{ $role->id }}
        </div>

        <div>
            <strong>Name:</strong>
            {{ $role->name }}
        </div>

        <div class="flex gap-4 mt-4">

            <a href="{{ route('admin.roles.edit', $role) }}" class="bg-blue-600 text-white px-4 py-2 rounded">
                Edit
            </a>

            <a href="{{ route('admin.roles.index') }}" class="bg-gray-600 text-white px-4 py-2 rounded">
                Back
            </a>

        </div>

    </div>
@endsection
