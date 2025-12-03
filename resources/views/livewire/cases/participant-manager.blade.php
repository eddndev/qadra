<div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
    
    <!-- Header & Actions -->
    <div class="flex justify-between items-center mb-6">
        <h4 class="text-md font-bold text-gray-900 dark:text-gray-100">Involucrados en el Caso</h4>
        <button wire:click="openCreateModal" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
            + Agregar Persona
        </button>
    </div>

    <!-- List -->
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead class="bg-gray-50 dark:bg-gray-700">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Rol</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Nombre / Alias</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Tipo</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Estado</th>
                    <th class="px-6 py-3 relative"></th>
                </tr>
            </thead>
            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                @forelse($participants as $participant)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300">
                                {{ ucfirst($participant->pivot->role) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $participant->name }}</div>
                            @if($participant->pivot->alias)
                                <div class="text-xs text-gray-500">Alias: {{ $participant->pivot->alias }}</div>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                            {{ ucfirst($participant->type) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($participant->pivot->is_detained)
                                <span class="text-red-600 font-bold text-xs">⚠️ DETENIDO</span>
                            @else
                                <span class="text-green-600 text-xs">Libre</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <button wire:click="delete('{{ $participant->id }}')" wire:confirm="¿Seguro que deseas quitar a este participante del caso?" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">
                                Eliminar
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                            No hay participantes registrados aún.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Modal -->
    <x-modal name="create-participant" :show="$isCreating" focusable>
        <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                Agregar Nuevo Participante
            </h2>

            <div class="mt-6 grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-2">
                <!-- Nombre -->
                <div class="sm:col-span-2">
                    <x-input-label for="name" value="Nombre Completo *" />
                    <x-text-input wire:model="name" id="name" class="block mt-1 w-full" type="text" placeholder="Ej. Juan Pérez" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <!-- Tipo -->
                <div>
                    <x-input-label for="type" value="Tipo de Persona *" />
                    <select wire:model="type" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                        <option value="fisica">Física</option>
                        <option value="moral">Moral (Empresa)</option>
                        <option value="autoridad">Autoridad</option>
                    </select>
                    <x-input-error :messages="$errors->get('type')" class="mt-2" />
                </div>

                <!-- Rol -->
                <div>
                    <x-input-label for="role" value="Rol en el Caso *" />
                    <select wire:model="role" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                        <option value="imputado">Imputado</option>
                        <option value="victima">Víctima / Ofendido</option>
                        <option value="testigo">Testigo</option>
                        <option value="defensor">Defensor</option>
                        <option value="asesor_juridico">Asesor Jurídico</option>
                        <option value="juez_control">Juez de Control</option>
                        <option value="juez_juicio">Juez de Juicio</option>
                        <option value="mp">Ministerio Público</option>
                        <option value="perito">Perito</option>
                        <option value="policia">Policía</option>
                    </select>
                    <x-input-error :messages="$errors->get('role')" class="mt-2" />
                </div>

                <!-- Alias -->
                <div>
                    <x-input-label for="alias" value="Alias (Opcional)" />
                    <x-text-input wire:model="alias" id="alias" class="block mt-1 w-full" type="text" />
                </div>

                <!-- Detenido Checkbox -->
                <div class="flex items-center mt-8">
                    <label for="is_detained" class="inline-flex items-center">
                        <input wire:model="is_detained" id="is_detained" type="checkbox" class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600">
                        <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">¿Se encuentra detenido?</span>
                    </label>
                </div>

                <!-- Notas -->
                <div class="sm:col-span-2">
                    <x-input-label for="notes" value="Notas Adicionales" />
                    <textarea wire:model="notes" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" rows="2"></textarea>
                </div>
            </div>

            <div class="mt-6 flex justify-end">
                <x-secondary-button wire:click="closeCreateModal">
                    Cancelar
                </x-secondary-button>

                <x-primary-button class="ms-3" wire:click="save">
                    Guardar Participante
                </x-primary-button>
            </div>
        </div>
    </x-modal>
</div>