@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('nav-links')

    <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
        Dashboard
    </x-nav-link>

    <x-nav-link :href="route('admin.roles.index')" :active="request()->routeIs('roles.*')">
        Roles
    </x-nav-link>

@endsection


@section('content')

    <h2 class="text-2xl font-bold">Admin Dashboard</h2>

@endsection
