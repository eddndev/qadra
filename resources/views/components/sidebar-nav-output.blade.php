<!-- Dashboard (Only show if in a Tenant context or if we have a specific Portal ink) -->
@if(\App\Models\Tenant::getGlobalTenant())
    <a href="{{ route('dashboard') }}"
        class="{{ request()->routeIs('dashboard') ? 'bg-brand-500 text-white' : 'text-gray-300 hover:bg-brand-500 hover:text-white' }} group flex items-center px-2 py-2 text-sm font-medium rounded-md">
        <svg class="mr-3 flex-shrink-0 h-6 w-6 {{ request()->routeIs('dashboard') ? 'text-white' : 'text-gray-400 group-hover:text-white' }}"
            fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
        </svg>
        Dashboard
    </a>
@else
    <!-- Portal Link for Tenantless Users -->
    <a href="{{ route('portal') }}"
        class="{{ request()->routeIs('portal') ? 'bg-brand-500 text-white' : 'text-gray-300 hover:bg-brand-500 hover:text-white' }} group flex items-center px-2 py-2 text-sm font-medium rounded-md">
        <svg class="mr-3 flex-shrink-0 h-6 w-6 {{ request()->routeIs('portal') ? 'text-white' : 'text-gray-400 group-hover:text-white' }}"
            fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
        </svg>
        Inicio
    </a>
@endif

@if(\App\Models\Tenant::getGlobalTenant())
    <!-- Expedientes -->
    <a href="{{ route('cases.index') }}"
        class="{{ request()->routeIs('cases.*') ? 'bg-brand-500 text-white' : 'text-gray-300 hover:bg-brand-500 hover:text-white' }} group flex items-center px-2 py-2 text-sm font-medium rounded-md">
        <svg class="mr-3 flex-shrink-0 h-6 w-6 {{ request()->routeIs('cases.*') ? 'text-white' : 'text-gray-400 group-hover:text-white' }}"
            fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
        </svg>
        Expedientes
    </a>

    <!-- Audiencias (Calendario) -->
    <a href="{{ route('calendar') }}"
        class="{{ request()->routeIs('calendar') ? 'bg-brand-500 text-white' : 'text-gray-300 hover:bg-brand-500 hover:text-white' }} group flex items-center px-2 py-2 text-sm font-medium rounded-md">
        <svg class="mr-3 flex-shrink-0 h-6 w-6 {{ request()->routeIs('calendar') ? 'text-white' : 'text-gray-400 group-hover:text-white' }}"
            fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
        </svg>
        Audiencias
    </a>

    <!-- Evidencias -->
    <a href="{{ route('evidence.index') }}"
        class="{{ request()->routeIs('evidence.*') ? 'bg-brand-500 text-white' : 'text-gray-300 hover:bg-brand-500 hover:text-white' }} group flex items-center px-2 py-2 text-sm font-medium rounded-md">
        <svg class="mr-3 flex-shrink-0 h-6 w-6 {{ request()->routeIs('evidence.*') ? 'text-white' : 'text-gray-400 group-hover:text-white' }}"
            fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
        </svg>
        Evidencias
    </a>

    <!-- Equipo -->
    <a href="{{ route('team.index') }}"
        class="{{ request()->routeIs('team.*') ? 'bg-brand-500 text-white' : 'text-gray-300 hover:bg-brand-500 hover:text-white' }} group flex items-center px-2 py-2 text-sm font-medium rounded-md">
        <svg class="mr-3 flex-shrink-0 h-6 w-6 {{ request()->routeIs('team.*') ? 'text-white' : 'text-gray-400 group-hover:text-white' }}"
            fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
        </svg>
        Equipo
    </a>

    <!-- Alertas -->
    <a href="{{ route('alerts.index') }}"
        class="{{ request()->routeIs('alerts.*') ? 'bg-brand-500 text-white' : 'text-gray-300 hover:bg-brand-500 hover:text-white' }} group flex items-center px-2 py-2 text-sm font-medium rounded-md">
        <svg class="mr-3 flex-shrink-0 h-6 w-6 {{ request()->routeIs('alerts.*') ? 'text-white' : 'text-gray-400 group-hover:text-white' }}"
            fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
        </svg>
        Alertas
    </a>

    <!-- Reportes -->
    <a href="{{ route('reports.index') }}"
        class="{{ request()->routeIs('reports.*') ? 'bg-brand-500 text-white' : 'text-gray-300 hover:bg-brand-500 hover:text-white' }} group flex items-center px-2 py-2 text-sm font-medium rounded-md">
        <svg class="mr-3 flex-shrink-0 h-6 w-6 {{ request()->routeIs('reports.*') ? 'text-white' : 'text-gray-400 group-hover:text-white' }}"
            fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
        </svg>
        Reportes
    </a>
@endif

<!-- Configuración -->
<a href="{{ route('profile.edit') }}"
    class="{{ request()->routeIs('profile.*') ? 'bg-brand-500 text-white' : 'text-gray-300 hover:bg-brand-500 hover:text-white' }} group flex items-center px-2 py-2 text-sm font-medium rounded-md">
    <svg class="mr-3 flex-shrink-0 h-6 w-6 {{ request()->routeIs('profile.*') ? 'text-white' : 'text-gray-400 group-hover:text-white' }}"
        fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
    </svg>
    Configuración
</a>