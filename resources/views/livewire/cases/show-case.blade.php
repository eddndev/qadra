<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        
        <!-- Case Header / Summary -->
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <div class="flex justify-between items-start">
                    <div>
                        <h3 class="text-lg font-semibold text-indigo-600 dark:text-indigo-400">
                            {{ $case->crime_type }} <span class="text-sm text-gray-500">({{ ucfirst($case->crime_severity) }})</span>
                        </h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">NUC: {{ $case->nuc ?? 'No asignado' }}</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Etapa: <span class="font-bold">{{ ucfirst(str_replace('_', ' ', $case->stage)) }}</span></p>
                    </div>
                    <div class="text-right">
                        <div class="flex flex-col items-end gap-2">
                             <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $case->status === 'activo' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                {{ ucfirst($case->status) }}
                            </span>
                            <livewire:cases.change-case-stage :case="$case" />
                        </div>
                        <p class="text-xs text-gray-400 mt-2">Creado: {{ $case->created_at->format('d/m/Y') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabs Navigation -->
        <div class="border-b border-gray-200 dark:border-gray-700 mb-6">
            <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                @php
                    $tabs = [
                        'overview' => 'Resumen e Historial',
                        'participants' => 'Participantes',
                        'hearings' => 'Audiencias',
                        'deadlines' => 'Plazos y Términos',
                        'documents' => 'Documentos', // Futuro
                    ];
                @endphp

                @foreach($tabs as $key => $label)
                    <button 
                        wire:click="setActiveTab('{{ $key }}')"
                        class="{{ $activeTab === $key 
                            ? 'border-indigo-500 text-indigo-600 dark:text-indigo-400' 
                            : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300' }}
                            whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                        {{ $label }}
                    </button>
                @endforeach
            </nav>
        </div>

        <!-- Tab Content -->
        <div>
            @if($activeTab === 'overview')
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Notas -->
                    <div class="md:col-span-2 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <h4 class="text-md font-bold mb-4 text-gray-900 dark:text-gray-100">Notas del Caso</h4>
                        <p class="text-gray-600 dark:text-gray-300 whitespace-pre-line">
                            {{ $case->notes ?? 'Sin notas registradas.' }}
                        </p>
                    </div>

                    <!-- Historial Procesal -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <h4 class="text-md font-bold mb-4 text-gray-900 dark:text-gray-100">Historial Procesal</h4>
                        <ul class="relative border-l border-gray-200 dark:border-gray-700 ml-3">
                            @foreach($case->stageHistory as $history)
                                <li class="mb-6 ml-4">
                                    <div class="absolute w-3 h-3 bg-indigo-600 rounded-full mt-1.5 -left-1.5 border border-white dark:border-gray-900"></div>
                                    <time class="mb-1 text-xs font-normal text-gray-400 dark:text-gray-500">{{ $history->created_at->format('d/m/Y H:i') }}</time>
                                    <h3 class="text-sm font-semibold text-gray-900 dark:text-white">
                                        {{ ucfirst(str_replace('_', ' ', $history->new_stage)) }}
                                    </h3>
                                    <p class="mb-2 text-xs font-normal text-gray-500 dark:text-gray-400">
                                        {{ ucfirst($history->new_status) }}
                                    </p>
                                    @if($history->reason)
                                        <p class="text-xs text-gray-600 dark:text-gray-300 italic">
                                            "{{ $history->reason }}"
                                        </p>
                                    @endif
                                    <div class="mt-1 text-xs text-indigo-500">
                                        Por: {{ $history->user->name ?? 'Sistema' }}
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @elseif($activeTab === 'participants')
                <livewire:cases.participant-manager :case="$case" />
            @elseif($activeTab === 'hearings')
                <livewire:hearings.case-hearings-list :case="$case" />
            @elseif($activeTab === 'deadlines')
                <livewire:deadlines.case-deadlines-list :case="$case" />
            @elseif($activeTab === 'documents')
                 <div class="text-center py-8 text-gray-500">Módulo de Documentos en construcción...</div>
            @endif
        </div>

    </div>
</div>