<div>
    <div class="flex justify-between items-center mb-4">
        <h3 class="text-lg font-medium text-gray-900">Audiencias del Caso</h3>
        <button wire:click="$dispatch('create-hearing', { caseId: '{{ $case->id }}' })"
            class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
            Nueva Audiencia
        </button>
    </div>

    @if($hearings->isEmpty())
        <div class="text-center py-8 text-gray-500 bg-white rounded-lg shadow p-6">
            <p>No hay audiencias programadas para este caso.</p>
        </div>
    @else
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Tipo / Fecha
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Ubicación
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Juez
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Estatus
                            </th>
                            <th scope="col" class="relative px-6 py-3">
                                <span class="sr-only">Acciones</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($hearings as $hearing)
                            <tr>
                                <td class="px-6 py-4">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ $hearing->type }}
                                    </div>
                                    <div class="text-sm text-gray-500">
                                        {{ $hearing->scheduled_at->format('d/m/Y H:i') }}
                                        @if($hearing->duration_minutes)
                                            <span class="ml-1 text-xs">({{ $hearing->duration_minutes }} min)</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">
                                        {{ $hearing->courtroom ?? 'Por definir' }}
                                    </div>
                                    @if($hearing->virtual_link)
                                        <a href="{{ $hearing->virtual_link }}" target="_blank"
                                            class="text-xs text-indigo-600 hover:text-indigo-900">
                                            Link Virtual
                                        </a>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $hearing->judge->name ?? 'No asignado' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span
                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                                {{ $hearing->status_config['bg_class'] }} {{ $hearing->status_config['text_class'] }}">
                                        {{ $hearing->status_config['label'] }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <!-- Actions dropdown could go here -->
                                    <button wire:click="$dispatch('edit-hearing', { hearingId: '{{ $hearing->id }}' })"
                                        class="text-indigo-600 hover:text-indigo-900">
                                        Ver/Editar
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif

    <!-- Hearing Form Modal -->
    <livewire:hearings.hearing-form :case="$case" />
</div>