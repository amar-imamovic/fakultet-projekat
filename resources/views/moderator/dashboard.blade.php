@extends('layouts.app')

@section('nav-links')
    <x-nav-link :href="route('moderator.dashboard')" :active="request()->routeIs('moderator.dashboard')">
        Dashboard
    </x-nav-link>
@endsection


@section('content')
    <h2 class="text-2xl font-bold">Moderator Dashboard</h2>
@endsection
