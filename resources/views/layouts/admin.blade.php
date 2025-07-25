<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - Admin</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-gray-100">
    <div class="min-h-screen">
        <!-- Navigation -->
        <nav class="bg-white shadow-sm border-b border-gray-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex">
                        <!-- Logo -->
                        <div class="shrink-0 flex items-center">
                            <a href="{{ route('admin.dashboard') }}" class="text-xl font-bold text-gray-800">
                                Songket Palembang - Admin
                            </a>
                        </div>

                        <!-- Navigation Links -->
                        <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                            <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                                <x-icon name="heroicon-o-chart-bar" class="w-4 h-4 mr-2" />
                                {{ __('Dashboard') }}
                            </x-nav-link>

                            @if (auth()->user()->canAccess('manage_songkets'))
                                <x-nav-link :href="route('admin.songket.index')" :active="request()->routeIs('admin.songket.*')">
                                    <x-icon name="heroicon-o-cube" class="w-4 h-4 mr-2" />
                                    {{ __('Songket') }}
                                </x-nav-link>

                                <x-nav-link :href="route('admin.categories.index')" :active="request()->routeIs('admin.categories.*')">
                                    <x-icon name="heroicon-o-tag" class="w-4 h-4 mr-2" />
                                    {{ __('Categories') }}
                                </x-nav-link>
                            @endif

                            @if (auth()->user()->canAccess('view_songkets'))
                                <x-nav-link :href="route('admin.songket.index')" :active="request()->routeIs('admin.songket.*')">
                                    <x-icon name="heroicon-o-cube" class="w-4 h-4 mr-2" />
                                    {{ __('Songket') }}
                                </x-nav-link>
                            @endif

                            @if (auth()->user()->canAccess('manage_orders'))
                                <x-nav-link :href="route('admin.orders.index')" :active="request()->routeIs('admin.orders.*')">
                                    <x-icon name="heroicon-o-shopping-bag" class="w-4 h-4 mr-2" />
                                    {{ __('Orders') }}
                                </x-nav-link>
                            @endif

                            @if (auth()->user()->canAccess('manage_payments'))
                                <x-nav-link :href="route('admin.payments.index')" :active="request()->routeIs('admin.payments.*')">
                                    <x-icon name="heroicon-o-credit-card" class="w-4 h-4 mr-2" />
                                    {{ __('Payments') }}
                                </x-nav-link>
                            @endif
                        </div>
                    </div>

                    <!-- Settings Dropdown -->
                    <div class="hidden sm:flex sm:items-center sm:ml-6">
                        <div class="flex items-center space-x-4">
                            <!-- Role Badge -->
                            <span
                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                {{ auth()->user()->role->label() }}
                            </span>

                            <x-dropdown align="right" width="48">
                                <x-slot name="trigger">
                                    <button
                                        class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                        <div>{{ Auth::user()->name }}</div>

                                        <div class="ml-1">
                                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                                viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                    </button>
                                </x-slot>

                                <x-slot name="content">
                                    <x-dropdown-link :href="route('home')">
                                        {{ __('View Store') }}
                                    </x-dropdown-link>

                                    <x-dropdown-link :href="route('profile.edit')">
                                        {{ __('Profile') }}
                                    </x-dropdown-link>

                                    <!-- Authentication -->
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf

                                        <x-dropdown-link :href="route('logout')"
                                            onclick="event.preventDefault();
                                                            this.closest('form').submit();">
                                            {{ __('Log Out') }}
                                        </x-dropdown-link>
                                    </form>
                                </x-slot>
                            </x-dropdown>
                        </div>
                    </div>

                    <!-- Hamburger -->
                    <div class="-mr-2 flex items-center sm:hidden">
                        <button @click="open = ! open"
                            class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                            <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                                    stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 6h16M4 12h16M4 18h16" />
                                <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden"
                                    stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Responsive Navigation Menu -->
            <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden">
                <div class="pt-2 pb-3 space-y-1">
                    <x-responsive-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                        {{ __('Dashboard') }}
                    </x-responsive-nav-link>

                    @if (auth()->user()->canAccess('manage_songkets'))
                        <x-responsive-nav-link :href="route('admin.songket.index')" :active="request()->routeIs('admin.songket.*')">
                            {{ __('Songket') }}
                        </x-responsive-nav-link>

                        <x-responsive-nav-link :href="route('admin.categories.index')" :active="request()->routeIs('admin.categories.*')">
                            {{ __('Categories') }}
                        </x-responsive-nav-link>
                    @endif

                    @if (auth()->user()->canAccess('view_songkets'))
                        <x-responsive-nav-link :href="route('admin.songket.index')" :active="request()->routeIs('admin.songket.*')">
                            {{ __('Songket') }}
                        </x-responsive-nav-link>
                    @endif

                    @if (auth()->user()->canAccess('manage_orders'))
                        <x-responsive-nav-link :href="route('admin.orders.index')" :active="request()->routeIs('admin.orders.*')">
                            {{ __('Orders') }}
                        </x-responsive-nav-link>
                    @endif

                    @if (auth()->user()->canAccess('manage_payments'))
                        <x-responsive-nav-link :href="route('admin.payments.index')" :active="request()->routeIs('admin.payments.*')">
                            {{ __('Payments') }}
                        </x-responsive-nav-link>
                    @endif
                </div>

                <!-- Responsive Settings Options -->
                <div class="pt-4 pb-1 border-t border-gray-200">
                    <div class="px-4">
                        <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                        <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                        <div class="mt-1">
                            <span
                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                {{ auth()->user()->role->label() }}
                            </span>
                        </div>
                    </div>

                    <div class="mt-3 space-y-1">
                        <x-responsive-nav-link :href="route('home')">
                            {{ __('View Store') }}
                        </x-responsive-nav-link>

                        <x-responsive-nav-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-responsive-nav-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-responsive-nav-link :href="route('logout')"
                                onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-responsive-nav-link>
                        </form>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Page Content -->
        <main class="py-6">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Session Status -->
                <x-session-alerts />

                {{ $slot }}
            </div>
        </main>
    </div>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('navigation', () => ({
                open: false
            }))
        })
    </script>
</body>

</html>
