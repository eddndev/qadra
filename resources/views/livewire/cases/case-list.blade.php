<div class="py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header & Actions -->
        <div class="sm:flex sm:items-center sm:justify-between mb-8">
            <div>
                <x-slot name="header">Expedientes</x-slot>
                <h1 class="text-2xl font-bold text-[#111344]">Expedientes Penales</h1>
                <p class="mt-2 text-sm text-gray-700">Lista completa de casos y su estado procesal.</p>
            </div>
            <div class="mt-4 sm:mt-0 flex gap-3">
                 <a href="{{ route('cases.create') }}" class="inline-flex items-center px-4 py-2 bg-[#1E40AF] border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-[#111344] focus:bg-[#111344] active:bg-[#111344] focus:outline-none focus:ring-2 focus:ring-[#1E40AF] focus:ring-offset-2 transition ease-in-out duration-150">
                    + Nuevo Caso
                </a>
            </div>
        </div>

        <!-- Filters -->
        <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-200 mb-6 flex flex-col sm:flex-row gap-4">
             <div class="relative w-full sm:w-80">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
                <input wire:model.live.debounce.300ms="search" type="text" class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#1E40AF] focus:ring-[#1E40AF] sm:text-sm placeholder-gray-400" placeholder="Buscar por folio, alias, delito...">
            </div>

            <select wire:model.live="filterStage" class="block w-full sm:w-48 rounded-md border-gray-300 shadow-sm focus:border-[#1E40AF] focus:ring-[#1E40AF] sm:text-sm">
                <option value="">Todas las Etapas</option>
                <option value="inv_inicial">Inv. Inicial</option>
                <option value="inv_complementaria">Inv. Complementaria</option>
                <option value="intermedia">Intermedia</option>
                <option value="juicio">Juicio Oral</option>
                <option value="ejecucion">Ejecución</option>
            </select>
        </div>

        <!-- Cases Table -->
        <div class="overflow-hidden bg-white shadow-sm ring-1 ring-black ring-opacity-5 rounded-lg">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-300">
                    <thead class="bg-[#eef2ff]">
                        <tr>
                            <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-xs font-semibold text-gray-900 sm:pl-6 uppercase tracking-wider">Folio / Alias</th>
                            <th scope="col" class="px-3 py-3.5 text-left text-xs font-semibold text-gray-900 uppercase tracking-wider">Delito</th>
                            <th scope="col" class="px-3 py-3.5 text-center text-xs font-semibold text-gray-900 uppercase tracking-wider">Etapa</th>
                            <th scope="col" class="px-3 py-3.5 text-left text-xs font-semibold text-gray-900 uppercase tracking-wider">NUC / Causa</th>
                            <th scope="col" class="px-3 py-3.5 text-left text-xs font-semibold text-gray-900 uppercase tracking-wider">Abogado</th>
                            <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                                <span class="sr-only">Acciones</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 bg-white">
                        @forelse ($cases as $case)
                            <tr class="hover:bg-gray-50">
                                <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm sm:pl-6">
                                    <div class="font-bold text-[#111344]">
                                        {{ $case->internal_folio }}
                                    </div>
                                    @if($case->case_alias)
                                        <div class="text-xs text-gray-500">
                                            {{ $case->case_alias }}
                                        </div>
                                    @endif
                                </td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-700">
                                    <div class="font-medium">{{ $case->crime_type }}</div>
                                    <div class="text-xs text-gray-500">{{ ucfirst($case->crime_severity ?? '') }}</div>
                                </td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-center">
                                    @php
                                        $stageColor = match($case->stage) {
                                            'inv_inicial', 'inv_complementaria' => 'bg-blue-50 text-blue-700 ring-blue-700/10',
                                            'intermedia' => 'bg-amber-50 text-amber-700 ring-amber-600/20',
                                            'juicio' => 'bg-purple-50 text-purple-700 ring-purple-700/10',
                                            'ejecucion' => 'bg-green-50 text-green-700 ring-green-600/20',
                                            default => 'bg-gray-50 text-gray-600 ring-gray-500/10',
                                        };
                                        $stageLabel = ucfirst(str_replace('_', ' ', $case->stage));
                                    @endphp
                                    <span class="inline-flex items-center rounded-full px-2 py-1 text-xs font-medium ring-1 ring-inset {{ $stageColor }}">
                                        {{ $stageLabel }}
                                    </span>
                                </td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                    @if($case->nuc)
                                        <div><span class="text-xs font-semibold">NUC:</span> {{ $case->nuc }}</div>
                                    @endif
                                    @if($case->judicial_file_number)
                                        <div><span class="text-xs font-semibold">Causa:</span> {{ $case->judicial_file_number }}</div>
                                    @endif
                                </td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                    {{ $case->leadLawyer->name ?? 'N/A' }}
                                </td>
                                <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                                    <a href="{{ route('cases.show', $case->id) }}" class="text-[#1E40AF] hover:text-[#111344] font-medium">Ver Expediente</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-10 text-center text-gray-500 bg-gray-50">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                                    </svg>
                                    <p class="mt-2 text-sm font-medium text-gray-900">No se encontraron expedientes</p>
                                    <p class="mt-1 text-sm text-gray-500">Intenta ajustar los filtros o crea un nuevo caso.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="px-4 py-3 border-t border-gray-200">
                {{ $cases->links() }}
            </div>
        </div>
    </div>
</div>