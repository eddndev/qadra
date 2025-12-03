<div>
    <button wire:click="openModal" class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-500 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
        Cambiar Etapa / Estatus
    </button>

    <x-modal name="change-stage-modal" :show="$showModal" focusable>
        <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">
                Actualizar Situación Procesal
            </h2>

            <p class="text-sm text-gray-500 dark:text-gray-400 mb-6">
                Registra el avance procesal del caso. Esta acción quedará guardada en el historial inmutable del expediente.
            </p>

            <div class="grid grid-cols-1 gap-6">
                <!-- Nueva Etapa -->
                <div>
                    <x-input-label for="new_stage" value="Nueva Etapa Procesal" />
                    <select wire:model="new_stage" id="new_stage" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                        @foreach($stages as $key => $label)
                            <option value="{{ $key }}">{{ $label }}</option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('new_stage')" class="mt-2" />
                </div>

                <!-- Nuevo Estatus -->
                <div>
                    <x-input-label for="new_status" value="Estatus del Expediente" />
                    <select wire:model="new_status" id="new_status" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                        @foreach($statuses as $key => $label)
                            <option value="{{ $key }}">{{ $label }}</option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('new_status')" class="mt-2" />
                </div>

                <!-- Razón / Justificación -->
                <div>
                    <x-input-label for="reason" value="Justificación del Cambio (Obligatorio)" />
                    <textarea wire:model="reason" id="reason" rows="3" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" placeholder="Ej. Se dictó auto de vinculación a proceso en la audiencia inicial..."></textarea>
                    <x-input-error :messages="$errors->get('reason')" class="mt-2" />
                </div>
            </div>

            <div class="mt-6 flex justify-end">
                <x-secondary-button wire:click="$set('showModal', false)">
                    Cancelar
                </x-secondary-button>

                <x-primary-button class="ms-3" wire:click="save">
                    Confirmar Cambio
                </x-primary-button>
            </div>
        </div>
    </x-modal>
</div>