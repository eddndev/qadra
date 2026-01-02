<div class="max-w-7xl mx-auto p-6">
    <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
        <h2 class="text-2xl font-bold text-gray-800">
            Inventario Global de Evidencias
        </h2>
        <a href="{{ route('evidence.create') }}"
            class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md text-sm font-medium transition">
            + Nueva Evidencia
        </a>
    </div>

    <!-- Filtros -->
    <div class="bg-white p-4 rounded-lg shadow-sm mb-6 grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="md:col-span-2">
            <input wire:model.live.debounce.300ms="search" type="text"
                placeholder="Buscar por folio, descripción o caso..."
                class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
        </div>
        <div>
            <select wire:model.live="statusFilter"
                class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
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
                class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
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
    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Folio
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Descripción / Caso</th>
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
                                    <div class="text-sm text-gray-900">{{ Str::limit($evidence->description, 50) }}</div>
                                    <div class="text-xs text-indigo-600">
                                        {{ $evidence->legalCase->internal_folio ?? 'Sin Caso' }}
                                    </div>
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
                                    <!-- TODO: Link to Detail View -->
                                    <a href="#" class="text-gray-600 hover:text-gray-900">
                                        Ver
                                    </a>
                                </td>
                            </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-10 text-center text-gray-500">
                            No se encontraron evidencias con los filtros seleccionados.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="p-4">
            {{ $evidences->links() }}
        </div>
    </div>
</div>