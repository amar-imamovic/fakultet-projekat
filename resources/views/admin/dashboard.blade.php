@extends('dashboard')

@section('content')
    <p>I AM AN ADMIN</p>
    <a href="{{ route('admin.roles.index') }}">Roles</a>
@endsection
