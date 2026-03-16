<x-app-layout>
    <div class="">

        <nav class="border-b-2 border-b-slate-800 grid grid-flow-col justify-between pt-6 pb-6 pl-6 pr-6">
            <a href="{{ route('dashboard') }}">
                <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
            </a>
            <div class="grid grid-flow-col content-center gap-8">
                <a href="{{ route('dashboard') }}">Dashboard</a>
                <a href="{{ route('dashboard') }}">Dashboard</a>
                <a href="{{ route('dashboard') }}">Dashboard</a>
                <a href="{{ route('dashboard') }}">Dashboard</a>
                <a href="{{ route('dashboard') }}">Dashboard</a>
            </div>
            <div class="grid items-center">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <a :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();"
                        class="cursor-pointer">Logout</a>
                </form>
            </div>
        </nav>

        @yield('content')
    </div>
</x-app-layout>
