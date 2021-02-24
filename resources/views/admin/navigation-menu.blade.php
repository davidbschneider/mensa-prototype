<nav class="navbar navbar-expand-md navbar-dark bg-dark sticky-top">
    <div class="container">
        <!-- Logo -->
        <a class="navbar-brand" href="/">
            <x-jet-application-mark width="36" />
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav mr-auto">
                @auth('admin')
                    <x-jet-nav-link href="{{ route('admin.home') }}" :active="request()->routeIs('admin.home')">
                        {{ __('Dashboard') }}
                    </x-jet-nav-link>
                @endauth
            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto align-items-baseline">
                <x-jet-dropdown id="teamManagementDropdown">
                    <x-slot name="trigger">
                        {{ config('lang.locales')[App::getLocale()] }}
                    </x-slot>

                    <x-slot name="content">
                        @foreach(config('lang.locales') as $locale => $language)
                            <x-jet-dropdown-link href="{{ route('setlocale',$locale) }}">
                                {{ $language }}
                            </x-jet-dropdown-link>
                        @endforeach
                    </x-slot>
                </x-jet-dropdown>
                @auth('admin')
                    <a href="{{ route('logout') }}"
                        class="nav-link"
                        onclick="event.preventDefault(); document.getElementById('admin-logout-form').submit();">
                        {{ __('Logout') }}
                    </a>
                    <form method="POST" id="admin-logout-form" action="{{ route('admin.logout') }}">
                        @csrf
                    </form>
                @else
                    <x-jet-nav-link href="{{ route('admin.login') }}" :active="request()->routeIs('admin.login')">
                        {{ __('Login') }}
                    </x-jet-nav-link>

                @endauth
            </ul>
        </div>
    </div>
</nav>
