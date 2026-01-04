<div class="max-w-7xl mx-auto {{ $caseId ? '' : 'p-6' }}">
    
    <!-- Header: Show full header only if global, otherwise just the action button if needed -->
    @if(!$caseId)
        <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
            <h2 class="text-2xl font-bold text-gray-800">
                Inventario Global de Evidencias
            </h2>
            <a href="{{ route('evidence.create') }}"
                class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md text-sm font-medium transition">
                + Nueva Evidencia
            </a>
        </div>
    @else
        <!-- Case Context Header: Just the button, aligned right -->
        <div class="flex justify-end mb-4">
            <a href="{{ route('evidence.create', ['case_id' => $caseId]) }}"
                class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md text-sm font-medium transition flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Nueva Evidencia
            </a>
        </div>
    @endif

    <!-- Filtros -->
    <div class="bg-white p-4 rounded-lg shadow-sm mb-6 grid grid-cols-1 md:grid-cols-4 gap-4 border border-gray-100">
        <div class="md:col-span-2">
            <input wire:model.live.debounce.300ms="search" type="text"
                placeholder="{{ $caseId ? 'Buscar por folio o descripción...' : 'Buscar por folio, descripción o caso...' }}"
                class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
        </div>
        <div>
            <select wire:model.live="statusFilter"
                class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                <option value="">Todos los Estados</option>
                <option value="en_custodia">En Custodia</option>
                <option value="en_fiscalia">En Fiscalía</option>
                <option value="en_juzgado">En Juzgado</option>
                <option value="destruido">Destruido</option>
                <option value="devuelto">Devuelto</option>
            </select>
        </div>
        <div>
            <select wire:model.live="typeFilter"
                class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                <option value="">Todos los Tipos</option>
                <option value="arma">Arma</option>
                <option value="documento_original">Documento</option>
                <option value="dispositivo_electronico">Dispositivo</option>
                <option value="biologico">Biológico</option>
                <option value="droga">Droga</option>
                <option value="dinero">Dinero</option>
            </select>
        </div>
    </div>

    <!-- Tabla -->
    <div class="bg-white shadow-sm rounded-lg overflow-hidden border border-gray-200">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Folio
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        {{ $caseId ? 'Descripción' : 'Descripción / Caso' }}
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ubicación
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado
                    </th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($evidences as $evidence)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ $evidence->chain_of_custody_folio }}
                                    <div class="text-xs text-gray-500 font-normal">
                                        {{ ucfirst(str_replace('_', ' ', $evidence->type)) }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-900">{{ Str::limit($evidence->description, 60) }}</div>
                                    @if(!$caseId)
                                        <div class="text-xs text-indigo-600 mt-1">
                                            {{ $evidence->legalCase->internal_folio ?? 'Sin Caso' }}
                                        </div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $evidence->current_location }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span
                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            {{ $evidence->status === 'en_custodia' ? 'bg-green-100 text-green-800' :
                    ($evidence->status === 'destruido' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                                        {{ $evidence->status_label }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a href="{{ route('evidence.move', $evidence) }}"
                                        class="text-indigo-600 hover:text-indigo-900 mr-3">
                                        Mover
                                    </a>
                                    <a href="{{ route('evidence.show', $evidence) }}" class="text-gray-600 hover:text-gray-900">
                                        Ver
                                    </a>
                                </td>
                            </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">No hay evidencias</h3>
                            <p class="mt-1 text-sm text-gray-500">No se encontraron registros con los filtros actuales.</p>
                            @if($caseId)
                                <div class="mt-6">
                                    <a href="{{ route('evidence.create', ['case_id' => $caseId]) }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none">
                                        <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                                        </svg>
                                        Registrar Primera Evidencia
                                    </a>
                                </div>
                            @endif
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="p-4 border-t border-gray-200">
            {{ $evidences->links() }}
        </div>
    </div>
</div>