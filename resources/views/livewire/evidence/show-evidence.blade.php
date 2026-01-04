<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
    
    <!-- Header -->
    <div class="md:flex md:items-center md:justify-between mb-6">
        <div class="flex-1 min-w-0">
            <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
                {{ $evidence->chain_of_custody_folio }}
            </h2>
            <div class="mt-1 flex flex-col sm:flex-row sm:flex-wrap sm:mt-0 sm:space-x-6">
                <div class="mt-2 flex items-center text-sm text-gray-500">
                    <!-- Icono Case -->
                    <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                    Caso: {{ $evidence->legalCase->internal_folio ?? 'N/A' }}
                </div>
                <div class="mt-2 flex items-center text-sm text-gray-500">
                    <!-- Icono Location -->
                    <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    {{ $evidence->current_location }}
                </div>
                <div class="mt-2 flex items-center text-sm text-gray-500">
                    <!-- Icono Date -->
                    <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    Recolectado: {{ $evidence->collected_at ? $evidence->collected_at->format('d/m/Y H:i') : '-' }}
                </div>
            </div>
        </div>
        <div class="mt-4 flex md:mt-0 md:ml-4">
            <span class="inline-flex rounded-md shadow-sm">
                <a href="{{ route('evidence.move', $evidence) }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <svg class="-ml-1 mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                    </svg>
                    Nuevo Movimiento
                </a>
            </span>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        
        <!-- Columna Izquierda: Información Detallada -->
        <div class="md:col-span-2 space-y-6">
            <!-- Ficha Principal -->
            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <div class="px-4 py-5 sm:px-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Descripción del Indicio</h3>
                    <p class="mt-1 max-w-2xl text-sm text-gray-500">Detalles físicos y características.</p>
                </div>
                <div class="border-t border-gray-200 px-4 py-5 sm:p-0">
                    <dl class="sm:divide-y sm:divide-gray-200">
                        <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Tipo de Evidencia</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2 capitalize">{{ str_replace('_', ' ', $evidence->type) }}</dd>
                        </div>
                        <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Estado Actual</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    {{ $evidence->status === 'en_custodia' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                    {{ $evidence->status_label }}
                                </span>
                            </dd>
                        </div>
                        <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Descripción</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2 whitespace-pre-wrap">{{ $evidence->description }}</dd>
                        </div>
                        <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Recolectado Por</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $evidence->collected_by ?? 'No especificado' }}</dd>
                        </div>
                        @if($evidence->notes)
                        <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Notas Adicionales</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $evidence->notes }}</dd>
                        </div>
                        @endif
                    </dl>
                </div>
            </div>

            <!-- Galería de Fotos -->
            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <div class="px-4 py-5 sm:px-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Registro Fotográfico</h3>
                    <p class="mt-1 max-w-2xl text-sm text-gray-500">Evidencias visuales asociadas.</p>
                </div>
                <div class="border-t border-gray-200 px-4 py-5 sm:px-6">
                    @if($evidence->getMedia('evidence_photos')->count() > 0)
                        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
                            @foreach($evidence->getMedia('evidence_photos') as $media)
                                <a href="{{ $media->getUrl() }}" target="_blank" class="block group relative aspect-w-1 aspect-h-1 rounded-lg overflow-hidden bg-gray-100">
                                    <img src="{{ $media->getUrl() }}" alt="Evidencia" class="object-cover w-full h-full group-hover:opacity-75 transition">
                                </a>
                            @endforeach
                        </div>
                    @else
                        <p class="text-sm text-gray-500 italic">No hay fotografías registradas.</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Columna Derecha: Cadena de Custodia -->
        <div class="md:col-span-1">
            <div class="bg-white shadow overflow-hidden sm:rounded-lg sticky top-6">
                <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Cadena de Custodia</h3>
                    <p class="mt-1 max-w-2xl text-sm text-gray-500">Historial de movimientos.</p>
                </div>
                <div class="px-4 py-5 sm:px-6">
                    <ul class="space-y-8">
                        @foreach($evidence->chainOfCustodyEntries as $entry)
                            <li class="relative">
                                @if(!$loop->last)
                                    <span class="absolute top-5 left-5 -ml-px h-full w-0.5 bg-gray-200" aria-hidden="true"></span>
                                @endif
                                <div class="relative flex space-x-3">
                                    <div>
                                        <span class="h-10 w-10 rounded-full bg-indigo-50 flex items-center justify-center ring-8 ring-white">
                                            <svg class="h-5 w-5 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                                            </svg>
                                        </span>
                                    </div>
                                    <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                        <div>
                                            <p class="text-sm text-gray-500">
                                                De: <span class="font-medium text-gray-900">{{ $entry->given_by }}</span>
                                            </p>
                                            <p class="text-sm text-gray-500">
                                                A: <span class="font-medium text-gray-900">{{ $entry->received_by }}</span>
                                            </p>
                                            <p class="text-xs text-gray-500 mt-1 italic">{{ $entry->reason }}</p>
                                        </div>
                                        <div class="text-right text-sm whitespace-nowrap text-gray-500">
                                            <time datetime="{{ $entry->movement_at }}">{{ $entry->movement_at->format('d/m/y H:i') }}</time>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>