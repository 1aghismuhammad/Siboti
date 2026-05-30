<nav x-data="{ open: false }" class="account-nav">
    <div class="account-nav__inner">
        <div class="account-nav__left">
            <a href="{{ route('dashboard') }}" class="account-nav__brand">
                <span class="account-nav__brand-mark">S</span>
                <span>Siboti</span>
            </a>

            <div class="account-nav__desktop-links">
                <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                    {{ __('Dashboard') }}
                </x-nav-link>
            </div>
        </div>

        <div class="account-nav__desktop-actions">
            @auth
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="account-nav__user-button">
                            <span>{{ Auth::user()->name }}</span>
                            <span>⌄</span>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            @endauth
        </div>

        <button @click="open = ! open" class="account-nav__mobile-button" type="button" aria-label="Toggle menu">
            ☰
        </button>
    </div>

    <div :class="{'account-nav__mobile-panel--open': open}" class="account-nav__mobile-panel">
        <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
            {{ __('Dashboard') }}
        </x-responsive-nav-link>

        @auth
            <div class="account-nav__mobile-user">
                <strong>{{ Auth::user()->name }}</strong>
                <span>{{ Auth::user()->email }}</span>
            </div>

            <x-responsive-nav-link :href="route('profile.edit')">
                {{ __('Profile') }}
            </x-responsive-nav-link>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                    {{ __('Log Out') }}
                </x-responsive-nav-link>
            </form>
        @endauth
    </div>
</nav>
