<header class="w-full bg-blue-900/95 backdrop-blur text-white border-b border-blue-800"
        x-data="{ open: false }">

    <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">

        {{-- Logo --}}
        <h1 class="text-2xl font-semibold tracking-tight">
            <a href="{{ route('home') }}" class="hover:text-blue-200 transition">
                JobPortal
            </a>
        </h1>

        {{-- DESKTOP NAV --}}
        <nav class="hidden md:flex items-center gap-6 text-sm font-medium">

            <x-nav-link :url="route('home')" :active="request()->routeIs('home')">
                Home
            </x-nav-link>

            <x-nav-link :url="route('jobs.index')" :active="request()->routeIs('jobs.*')">
                Jobs
            </x-nav-link>

            @auth
                <x-nav-link :url="route('bookmarks.index')" :active="request()->routeIs('bookmarks.*')">
                    Saved
                </x-nav-link>

                <a href="{{ route('dashboard') }}" class="flex items-center gap-2">
                    <img
                        src="{{ auth()->user()->avatar
                            ? asset('storage/' . auth()->user()->avatar)
                            : asset('storage/avatars/default-avatar.png') }}"
                        class="w-9 h-9 rounded-full object-cover ring-2 ring-blue-700"
                    >
                </a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="text-blue-200 hover:text-white transition">
                        Logout
                    </button>
                </form>

                <x-button-link :url="route('jobs.create')" icon="edit">
                    Create
                </x-button-link>
            @else
                <x-nav-link :url="route('login')" :active="request()->routeIs('login')">
                    Login
                </x-nav-link>

                <x-nav-link :url="route('register')" :active="request()->routeIs('register')">
                    Register
                </x-nav-link>
            @endauth
        </nav>

        {{-- HAMBURGER --}}
        <button @click="open = !open" class="md:hidden text-white">
            <i class="fa fa-bars text-xl"></i>
        </button>
    </div>

    {{-- MOBILE MENU --}}
    <nav
        x-show="open"
        x-transition
        @click.away="open = false"
        class="md:hidden bg-blue-900 border-t border-blue-800"
    >
        <div class="max-w-7xl mx-auto px-6 py-4 space-y-3 text-sm">
            <x-nav-link :url="route('home')" mobile>Home</x-nav-link>
            <x-nav-link :url="route('jobs.index')" mobile>Jobs</x-nav-link>

            @auth
                <x-nav-link :url="route('bookmarks.index')" mobile>Saved</x-nav-link>
                <x-nav-link :url="route('dashboard')" mobile>Dashboard</x-nav-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="w-full text-left py-2 text-blue-200">
                        Logout
                    </button>
                </form>

                <x-button-link :url="route('jobs.create')" icon="edit" block>
                    Create Job
                </x-button-link>
            @else
                <x-nav-link :url="route('login')" mobile>Login</x-nav-link>
                <x-nav-link :url="route('register')" mobile>Register</x-nav-link>
            @endauth
        </div>
    </nav>
</header>
