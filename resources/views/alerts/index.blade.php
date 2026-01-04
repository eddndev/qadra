<x-app-layout>
    <x-slot name="header">
        Alertas
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            


            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Left Column: Deadlines -->
                <div class="space-y-8">
                    
                    <!-- Plazos Vencidos -->
                    <div class="bg-red-50 border border-red-100 rounded-lg overflow-hidden shadow-sm">
                        <div class="px-4 py-3 border-b border-red-200 bg-red-100/50 flex items-center gap-2">
                            <svg class="w-5 h-5 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <h2 class="font-bold text-red-800">Plazos Vencidos</h2>
                            <svg class="w-4 h-4 text-red-600 animate-pulse" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z" />
                            </svg>
                        </div>
                        
                        <div class="divide-y divide-red-200/50">
                            @forelse($expiredDeadlines as $deadline)
                                <div class="p-4 hover:bg-red-100/30 transition-colors">
                                    <div class="flex justify-between items-start mb-1">
                                        <div class="text-sm font-bold text-[#111344]">
                                            {{ $deadline->case->internal_folio ?? $deadline->case->nuc ?? 'Sin Folio' }}
                                        </div>
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-red-600 text-white">
                                            VENCIDO
                                        </span>
                                    </div>
                                    <div class="text-sm font-medium text-gray-800 mb-1">
                                        {{ $deadline->case->crime_type ?? 'Delito' }} - {{ $deadline->case->case_alias ?? 'Alias' }}
                                    </div>
                                    <div class="text-xs text-gray-600 mb-2">
                                        {{ $deadline->title }}
                                    </div>
                                    <div class="flex items-center justify-between text-xs text-red-700">
                                        <span>Fecha límite: {{ $deadline->expires_at->format('d M Y') }}</span>
                                        <span class="font-bold">Vencido hace {{ $deadline->expires_at->diffInDays(now()) }} días</span>
                                    </div>
                                    <div class="mt-2">
                                        <a href="{{ route('cases.show', $deadline->case_id) }}" class="text-xs text-blue-600 hover:text-blue-800 flex items-center gap-1">
                                            Ver expediente
                                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            @empty
                                <div class="p-4 text-sm text-gray-500 text-center">No hay plazos vencidos.</div>
                            @endforelse
                        </div>
                    </div>

                    <!-- Plazos Próximos -->
                    <div class="bg-blue-50 border border-blue-100 rounded-lg overflow-hidden shadow-sm">
                        <div class="px-4 py-3 border-b border-blue-200 bg-blue-100/50 flex items-center gap-2">
                            <svg class="w-5 h-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <h2 class="font-bold text-blue-800">Plazos Próximos 72h</h2>
                             <svg class="w-4 h-4 text-blue-600" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 17v2m0-8h.01"></path>
                            </svg>
                        </div>
                        
                         <div class="divide-y divide-blue-200/50">
                            @forelse($upcomingDeadlines as $deadline)
                                <div class="p-4 hover:bg-blue-100/30 transition-colors">
                                    <div class="flex justify-between items-start mb-1">
                                        <div class="text-sm font-bold text-[#111344]">
                                            {{ $deadline->case->internal_folio ?? $deadline->case->nuc ?? 'Sin Folio' }}
                                        </div>
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-amber-100 text-amber-800 border border-amber-200">
                                            Vence en {{ $deadline->expires_at->diffInHours(now()) }}h
                                        </span>
                                    </div>
                                    <div class="text-sm font-medium text-gray-800 mb-1">
                                        {{ $deadline->case->crime_type ?? 'Delito' }} - {{ $deadline->case->case_alias ?? 'Alias' }}
                                    </div>
                                    <div class="text-xs text-gray-600 mb-2">
                                        {{ $deadline->title }}
                                    </div>
                                    <div class="flex items-center justify-between text-xs text-blue-900">
                                        <span>Fecha límite: {{ $deadline->expires_at->format('d M Y, H:i') }}</span>
                                    </div>
                                     <div class="mt-2">
                                        <a href="{{ route('cases.show', $deadline->case_id) }}" class="text-xs text-blue-600 hover:text-blue-800 flex items-center gap-1">
                                            Ver expediente
                                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            @empty
                                 <div class="p-4 text-sm text-gray-500 text-center">No hay plazos próximos en 72h.</div>
                            @endforelse
                        </div>
                    </div>

                </div>

                <!-- Right Column: Recent Activity & System Alerts -->
                <div class="space-y-8">
                    
                    <!-- Actividad Reciente -->
                    <div class="bg-white rounded-lg border border-gray-200 shadow-sm p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h2 class="text-lg font-bold text-[#111344]">Actividad Reciente</h2>
                            <span class="bg-gray-100 text-gray-600 text-xs px-2 py-1 rounded-full font-bold">{{ count($recentActivities) }}</span>
                        </div>
                        
                        @if($recentActivities->isEmpty())
                            <div class="text-sm text-gray-500 text-center py-4">No hay actividad reciente.</div>
                        @else
                            <div class="relative pl-4 border-l-2 border-gray-100 space-y-6">
                                @foreach($recentActivities as $activity)
                                    @php
                                        $iconColors = [
                                            'Llamada Telefónica' => 'bg-blue-100 text-blue-600',
                                            'Email' => 'bg-green-100 text-green-600',
                                            'Reunión' => 'bg-purple-100 text-purple-600',
                                            'Visita a Juzgado' => 'bg-amber-100 text-amber-600',
                                            'Presentación de Escrito' => 'bg-indigo-100 text-indigo-600',
                                            'Diligencia' => 'bg-teal-100 text-teal-600',
                                        ];
                                        $colorClass = $iconColors[$activity->type] ?? 'bg-gray-100 text-gray-600';
                                    @endphp
                                    <div class="relative">
                                        <div class="absolute -left-[21px] {{ $colorClass }} p-1 rounded-full border border-white">
                                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </div>
                                        <div class="text-sm text-gray-800 font-medium">{{ $activity->title }}</div>
                                        <div class="text-xs text-gray-500">
                                            {{ $activity->legalCase->internal_folio ?? 'Sin folio' }} - {{ $activity->type }}
                                        </div>
                                        <div class="text-xs text-gray-400 mt-1">
                                            {{ $activity->created_at->diffForHumans() }}
                                            @if($activity->legalCase)
                                                • <a href="{{ route('cases.show', $activity->legalCase->id) }}" class="text-blue-600 hover:underline">Ver expediente</a>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
