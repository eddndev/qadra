<header class="bg-white shadow-sm h-16 flex justify-between items-center px-6">
    <!-- Breadcrumbs / Title -->
    <div class="flex items-center">
        @isset($header)
            <div class="text-lg font-medium text-gray-800">
                {{ $header }}
            </div>
        @else
            <div class="text-sm breadcrumbs text-gray-500">
               Inicio <span class="mx-2">></span> <span class="font-semibold text-gray-800">Dashboard</span>
            </div>
        @endisset
    </div>

    <!-- Search Bar -->
    <div class="flex-1 max-w-lg mx-auto hidden md:flex">
        <div class="relative w-full">
            <span class="absolute inset-y-0 left-0 pl-3 flex items-center">
                <svg class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                </svg>
            </span>
            <input type="text" class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-full leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:border-blue-300 focus:ring focus:ring-blue-200 sm:text-sm" placeholder="Buscar expediente o imputado">
        </div>
    </div>

    <!-- Mobile menu button -->
    <div class="flex items-center lg:hidden mr-4">
        <button type="button" 
            onclick="document.getElementById('mobile-sidebar').classList.toggle('hidden')"
            class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
            <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>
    </div>

    <!-- Right Icons -->
    <div class="flex items-center gap-4">
        <!-- Tenant Switcher -->
        <livewire:components.tenant-switcher />

        <!-- Notification Bell -->
        <button class="text-gray-500 hover:text-gray-700 relative">
            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 2a6 6 0 00-9.935 6.953 6.002 6.002 0 00-8.65 8.651 8 8 0 0113.882-3.111 6.002 6.002 0 00-6.105-8.494A6 6 0 0010 2z" /> <!-- Simplification, better use heroicons bell -->
                <path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z" />
            </svg>
             <!-- Badge placeholder -->
        </button>

        <!-- Profile Dropdown -->
        <div class="ml-3 relative">
            <x-dropdown align="right" width="48">
                <x-slot name="trigger">
                    <button class="flex items-center gap-2 focus:outline-none">
                        <div class="h-8 w-8 rounded-full bg-slate-700 text-white flex items-center justify-center text-sm font-semibold">
                            {{ substr(Auth::user()->name ?? 'JD', 0, 2) }}
                        </div>
                        <div class="hidden md:block text-left">
                            <div class="text-sm font-medium text-gray-700">{{ Auth::user()->name }}</div>
                            <div class="text-xs text-gray-500">{{ Auth::user()->email }}</div>
                        </div>
                    </button>
                </x-slot>

                <x-slot name="content">
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
</header>
