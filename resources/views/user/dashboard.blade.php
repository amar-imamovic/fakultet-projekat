@extends('layouts.app')

@section('nav-links')
    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('user.dashboard')">
        Dashboard
    </x-nav-link>
@endsection


@section('content')
    <h2 class="text-2xl font-bold">User Dashboard</h2>
@endsection
