<x-app-layout>
    <x-slot name="header">
        Dashboard
    </x-slot>

    <div class="space-y-8">
        @if(isset($isTenantless) && $isTenantless)
            <!-- Tenantless User Portal -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Welcome & Actions -->
                <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100">
                    <h2 class="text-2xl font-bold text-[#111344] mb-2">Bienvenido, {{ Auth::user()->name }}</h2>
                    <p class="text-gray-600 mb-6">Gestiona tus invitaciones o crea un nuevo despacho para comenzar.</p>

                    <div class="space-y-4">
                        <a href="{{ route('tenant.create') }}"
                            class="block w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-lg text-center transition">
                            Crear Nuevo Despacho
                        </a>
                    </div>
                </div>

                <!-- Pending Invitations -->
                <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100">
                    <livewire:dashboard.user-invitations />
                </div>
            </div>
        @else
            <!-- Standard Tenant Dashboard -->

            <!-- Module Header -->
            <div>
                <h1 class="text-3xl font-bold text-[#111344] tracking-tight">Dashboard</h1>
            </div>

            <!-- Stats Row -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Expedientes Activos -->
                <x-stat-card title="Expedientes Activos" count="{{ $activeCasesCount }}" iconColor="text-blue-600"
                    bgIcon="bg-blue-50">
                    <x-slot name="icon">
                        <svg class="w-6 h-6 text-[#1E40AF]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
                        </svg>
                    </x-slot>
                </x-stat-card>

                <!-- Audiencias de Hoy -->
                <x-stat-card title="Audiencias de Hoy" count="{{ $todaysHearingsCount }}" iconColor="text-blue-600"
                    bgIcon="bg-blue-50">
                    <x-slot name="icon">
                        <svg class="w-6 h-6 text-[#1E40AF]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </x-slot>
                </x-stat-card>

                <!-- Plazos Próximos -->
                <x-stat-card title="Plazos Próximos (72 hrs)" count="{{ $upcomingDeadlinesCount }}"
                    iconColor="text-[#A52A2A]" bgIcon="bg-red-50" borderColor="red-100">
                    <x-slot name="icon">
                        <svg class="w-6 h-6 text-[#A52A2A]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </x-slot>
                </x-stat-card>
            </div>

            <!-- Recent Cases Section -->
            <div>
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-xl font-bold text-[#111344]">Expedientes Recientes</h2>
                <a href="{{ route('cases.index') }}" class="text-sm font-medium text-blue-600 hover:text-blue-800 flex items-center">
                        Ver todos
                        <svg class="w-4 h-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 8l4 4m0 0l-4 4m4-4H3" />
                        </svg>
                    </a>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 xl:grid-cols-2 gap-6">
                    @foreach($recentCases as $case)
                        <a href="{{ route('cases.show', $case) }}" class="block">
                            <x-case-card :caseNumber="$case->internal_folio ?? $case->nuc ?? 'Sin Folio'" 
                                :title="$case->case_alias ?? $case->crime_type ?? 'Sin Título'" 
                                :location="$case->court_name ?? 'Sin Asignar'"
                                :date="$case->start_date ? $case->start_date->isoFormat('D MMM YYYY') : '--'" 
                                :status="$case->stage ?? $case->status ?? 'Sin Estado'" 
                                statusColor="blue" />
                        </a>
                    @endforeach
                </div>
            </div>

            <!-- Upcoming Deadlines -->
            <div>
                <div class="mb-4">
                    <h2 class="text-xl font-bold text-[#111344]">Plazos Próximos</h2>
                </div>

                <livewire:deadlines.deadlines-widget />
            </div>
        @endif
    </div>
</x-app-layout>