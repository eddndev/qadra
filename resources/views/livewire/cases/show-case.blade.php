<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

        <!-- Case Header / Summary -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
            <div class="p-6 text-gray-900">
                <div class="flex justify-between items-start">
                    <div>
                        <h3 class="text-lg font-semibold text-indigo-600">
                            {{ $case->crime_type }} <span
                                class="text-sm text-gray-500">({{ ucfirst($case->crime_severity) }})</span>
                        </h3>
                        <p class="text-sm text-gray-500 mt-1">NUC: {{ $case->nuc ?? 'No asignado' }}</p>
                        <p class="text-sm text-gray-500">Etapa: <span
                                class="font-bold">{{ ucfirst(str_replace('_', ' ', $case->stage)) }}</span></p>
                    </div>
                    <div class="text-right">
                        <div class="flex flex-col items-end gap-2">
                            <span
                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $case->status === 'activo' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
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
        <div class="border-b border-gray-200 mb-6">
            <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                @php
                    $tabs = [
                        'overview' => 'Resumen e Historial',
                        'participants' => 'Participantes',
                        'hearings' => 'Audiencias',
                        'deadlines' => 'Plazos y Términos',
                        'measures' => 'Medidas Cautelares',
                        'solutions' => 'Soluciones Alternas',
                        'activities' => 'Actuaciones (Bitácora)',
                        'evidence' => 'Evidencias',
                        'documents' => 'Documentos',
                    ];
                @endphp

                @foreach($tabs as $key => $label)
                            <button wire:click="setActiveTab('{{ $key }}')" class="{{ $activeTab === $key
                    ? 'border-indigo-500 text-indigo-600'
                    : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}
                                        whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                                {{ $label }}
                            </button>
                @endforeach
            </nav>
        </div>

        <!-- Tab Content -->
        <div>
            @if($activeTab === 'overview')
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                    
                    <!-- Columna 1: Ficha Técnica -->
                    <div class="md:col-span-1 space-y-6">
                        <div class="bg-white shadow-sm sm:rounded-lg p-6 border border-gray-100">
                            <h4 class="text-sm font-bold text-gray-500 uppercase tracking-wider mb-4 border-b pb-2">Ficha Técnica</h4>
                            
                            <dl class="space-y-4 text-sm">
                                <div>
                                    <dt class="text-xs text-gray-500">Folio Interno</dt>
                                    <dd class="font-medium text-gray-900">{{ $case->internal_folio }}</dd>
                                </div>
                                
                                @if($case->nuc)
                                <div>
                                    <dt class="text-xs text-gray-500">NUC</dt>
                                    <dd class="font-medium text-gray-900 break-words">{{ $case->nuc }}</dd>
                                </div>
                                @endif

                                @if($case->judicial_file_number)
                                <div>
                                    <dt class="text-xs text-gray-500">Expediente Judicial</dt>
                                    <dd class="font-medium text-gray-900">{{ $case->judicial_file_number }}</dd>
                                </div>
                                @endif

                                <div class="pt-2 border-t border-gray-100"></div>

                                <div>
                                    <dt class="text-xs text-gray-500">Juzgado</dt>
                                    <dd class="font-medium text-gray-900">{{ $case->court_name ?? 'No registrado' }}</dd>
                                </div>

                                <div>
                                    <dt class="text-xs text-gray-500">Juez</dt>
                                    <dd class="font-medium text-gray-900">{{ $case->judge_name ?? 'No asignado' }}</dd>
                                </div>

                                <div>
                                    <dt class="text-xs text-gray-500">Fiscalía</dt>
                                    <dd class="font-medium text-gray-900">{{ $case->prosecutor_name ?? 'No registrada' }}</dd>
                                </div>
                                
                                <div class="pt-2 border-t border-gray-100"></div>
                                
                                <div>
                                    <dt class="text-xs text-gray-500">Fecha de Inicio</dt>
                                    <dd class="font-medium text-gray-900">{{ $case->start_date ? $case->start_date->format('d/m/Y') : '-' }}</dd>
                                </div>
                            </dl>
                        </div>
                    </div>

                    <!-- Columna 2 y 3: Notas y Equipo -->
                    <div class="md:col-span-2 space-y-6">
                        <!-- Notas -->
                        <div class="bg-white shadow-sm sm:rounded-lg p-6 border border-gray-100 min-h-[200px]">
                            <div class="flex items-center gap-2 mb-4">
                                <svg class="w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                                <h4 class="text-md font-bold text-gray-900">Notas y Estrategia</h4>
                            </div>
                            <div class="bg-yellow-50 rounded-md p-4 border border-yellow-100 text-sm text-gray-700 whitespace-pre-line">
                                {{ $case->notes ?? 'No hay notas registradas para este caso.' }}
                            </div>
                        </div>

                        <!-- Equipo -->
                        <div class="bg-white shadow-sm sm:rounded-lg p-6 border border-gray-100">
                            <h4 class="text-sm font-bold text-gray-500 uppercase tracking-wider mb-4 border-b pb-2">Equipo Legal</h4>
                            <div class="flex items-center gap-6">
                                <div class="flex items-center gap-3">
                                    <div class="h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-700 font-bold">
                                        {{ substr($case->leadLawyer->name ?? '?', 0, 2) }}
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500">Abogado Líder</p>
                                        <p class="text-sm font-medium text-gray-900">{{ $case->leadLawyer->name ?? 'Sin asignar' }}</p>
                                    </div>
                                </div>
                                
                                @if($case->assignedLawyer)
                                <div class="flex items-center gap-3">
                                    <div class="h-10 w-10 rounded-full bg-gray-100 flex items-center justify-center text-gray-700 font-bold">
                                        {{ substr($case->assignedLawyer->name, 0, 2) }}
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500">Colaborador</p>
                                        <p class="text-sm font-medium text-gray-900">{{ $case->assignedLawyer->name }}</p>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Columna 4: Urgencias e Historial -->
                    <div class="md:col-span-1 space-y-6">
                        
                        <!-- Próximos Eventos (Placeholder lógica futura) -->
                        <div class="bg-white shadow-sm sm:rounded-lg p-6 border-l-4 border-indigo-500">
                            <h4 class="text-sm font-bold text-gray-900 mb-2">Próximo Evento</h4>
                            @php
                                $nextHearing = $case->hearings()->where('scheduled_at', '>=', now())->orderBy('scheduled_at')->first();
                                $nextDeadline = $case->deadlines()->where('expires_at', '>=', now())->orderBy('expires_at')->first();
                            @endphp

                            @if($nextHearing)
                                <div class="mb-2">
                                    <p class="text-xs text-indigo-600 font-bold">AUDIENCIA</p>
                                    <p class="text-sm font-medium">{{ $nextHearing->type }}</p>
                                    <p class="text-xs text-gray-500">{{ $nextHearing->scheduled_at->format('d M, H:i') }}</p>
                                </div>
                            @elseif($nextDeadline)
                                <div class="mb-2">
                                    <p class="text-xs text-amber-600 font-bold">PLAZO</p>
                                    <p class="text-sm font-medium">{{ $nextDeadline->title }}</p>
                                    <p class="text-xs text-gray-500">{{ $nextDeadline->expires_at->format('d M, H:i') }}</p>
                                </div>
                            @else
                                <p class="text-xs text-gray-400 italic">No hay eventos próximos programados.</p>
                            @endif
                        </div>

                        <!-- Historial Procesal -->
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                            <h4 class="text-sm font-bold text-gray-900 mb-4">Historial Reciente</h4>
                            <ul class="relative border-l border-gray-200 ml-3 space-y-6">
                                @foreach($case->stageHistory->take(5) as $history)
                                    <li class="ml-4">
                                        <div class="absolute w-2 h-2 bg-gray-400 rounded-full mt-1.5 -left-1 border border-white"></div>
                                        <time class="mb-1 text-[10px] font-normal text-gray-400 block">{{ $history->created_at->format('d/m/Y') }}</time>
                                        <h3 class="text-xs font-semibold text-gray-900">
                                            {{ ucfirst(str_replace('_', ' ', $history->new_stage)) }}
                                        </h3>
                                        <p class="text-[10px] text-gray-500 truncate">
                                            {{ $history->reason ?? 'Cambio de estado' }}
                                        </p>
                                    </li>
                                @endforeach
                            </ul>
                            <div class="mt-4 text-center">
                                <button class="text-xs text-indigo-600 hover:text-indigo-800">Ver historial completo</button>
                            </div>
                        </div>
                    </div>
                </div>
            @elseif($activeTab === 'participants')
                <livewire:cases.participant-manager :case="$case" />
            @elseif($activeTab === 'hearings')
                <livewire:hearings.case-hearings-list :case="$case" />
            @elseif($activeTab === 'deadlines')
                <livewire:deadlines.case-deadlines-list :case="$case" />
            @elseif($activeTab === 'measures')
                <livewire:measures.precautionary-measure-form :case="$case" />
            @elseif($activeTab === 'solutions')
                <livewire:solutions.alternative-solution-form :case="$case" />
            @elseif($activeTab === 'activities')
                <livewire:activities.activity-timeline :case="$case" />
            @elseif($activeTab === 'evidence')
                <div class="flex justify-end mb-4">
                    <a href="{{ route('evidence.create', ['case_id' => $case->id]) }}"
                        class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded text-sm">
                        + Nueva Evidencia
                    </a>
                </div>
                <livewire:evidence.evidence-table :caseId="$case->id" />
            @elseif($activeTab === 'documents')
                <div class="space-y-6">
                    <livewire:documents.document-uploader :model="$case" />
                    <livewire:documents.document-list :model="$case" />
                </div>
            @endif
        </div>

    </div>
</div>