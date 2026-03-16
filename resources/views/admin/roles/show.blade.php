@extends('admin.dashboard')

@section('content')
    <h1>Role Details</h1>

    @include('components.messages')

    <p>ID: {{ $role->id }}</p>
    <p>Name: {{ $role->name }}</p>

    <a href="{{ route('admin.roles.index') }}">Back</a>
@endsection
