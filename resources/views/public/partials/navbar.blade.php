<header class="bg-white border-b border-neutral-200 sticky top-0 z-50">
    <div class="container-app h-16 flex items-center justify-between">
        <!-- Logo -->
        <a href="{{ url('/') }}" class="flex items-center gap-2 group">
            <x-application-logo class="w-8 h-8 text-brand-600 group-hover:text-brand-700 transition-colors" />
            <span class="font-bold text-xl text-brand-900 tracking-tight">Qadra</span>
        </a>

        <!-- Desktop Navigation -->
        <nav class="hidden md:flex items-center gap-8">
            <a href="#features"
                class="text-sm font-medium text-neutral-600 hover:text-brand-600 transition-colors">Características</a>
            <a href="#pricing"
                class="text-sm font-medium text-neutral-600 hover:text-brand-600 transition-colors">Precios</a>
        </nav>

        <!-- Auth Actions -->
        <div class="flex items-center gap-4">
            @if (Route::has('login'))
                @auth
                    <a href="{{ url('/portal') }}"
                        class="text-sm font-medium text-neutral-600 hover:text-brand-600 transition-colors">
                        Mi Portal
                    </a>
                @else
                    <a href="{{ route('login') }}"
                        class="text-sm font-medium text-neutral-600 hover:text-brand-600 transition-colors hidden sm:block">
                        Iniciar Sesión
                    </a>

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="btn btn-primary text-sm shadow-sm hover:shadow-md transition-all">
                            Comenzar Gratis
                        </a>
                    @endif
                @endauth
            @endif
        </div>
    </div>
</header>