<x-modal name="deadline-form-modal" focusable>
    <div class="p-6">
        <h2 class="text-lg font-medium text-gray-900 mb-4">
            {{ $deadline ? 'Editar Plazo' : 'Crear Nuevo Plazo' }}
        </h2>

        <form wire:submit.prevent="save">
            <div class="grid grid-cols-1 gap-6">

                <!-- Título -->
                <div>
                    <x-input-label for="deadline_title" value="Título del Plazo" />
                    <x-text-input wire:model="title" id="deadline_title" type="text" class="block mt-1 w-full"
                        placeholder="Ej. Cierre de Investigación" />
                    <x-input-error :messages="$errors->get('title')" class="mt-2" />
                </div>

                <!-- Descripción -->
                <div>
                    <x-input-label for="deadline_description" value="Descripción (Opcional)" />
                    <textarea wire:model="description" id="deadline_description" rows="3"
                        class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"></textarea>
                    <x-input-error :messages="$errors->get('description')" class="mt-2" />
                </div>

                <!-- Fecha de Vencimiento -->
                <div>
                    <x-input-label for="deadline_expires_at" value="Fecha y Hora de Vencimiento" />
                    <input type="datetime-local" wire:model="expires_at" id="deadline_expires_at"
                        class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                    <x-input-error :messages="$errors->get('expires_at')" class="mt-2" />
                </div>

                <div class="flex items-center gap-4">
                    <!-- Fatal -->
                    <div class="flex items-center">
                        <input wire:model="is_fatal" id="is_fatal" type="checkbox"
                            class="rounded border-gray-300 text-red-600 shadow-sm focus:ring-red-500">
                        <label for="is_fatal" class="ms-2 text-sm font-bold text-red-600">¿Es Término Fatal?</label>
                    </div>

                    <!-- Status (Only Edit) -->
                    @if($deadline)
                        <div class="flex items-center ml-6">
                            <x-input-label for="status" value="Estatus" class="mr-2" />
                            <select wire:model="status" id="status"
                                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm py-1">
                                <option value="pendiente">Pendiente</option>
                                <option value="cumplido">Cumplido</option>
                                <option value="vencido">Vencido</option>
                            </select>
                        </div>
                    @endif
                </div>

                <!-- Alertas -->
                <div>
                    <x-input-label value="Configuración de Alertas" class="mb-2" />
                    <div class="grid grid-cols-2 gap-4">
                        <label class="inline-flex items-center">
                            <input type="checkbox" wire:model="remind_7_days"
                                class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                            <span class="ms-2 text-sm text-gray-600">7 días antes</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="checkbox" wire:model="remind_3_days"
                                class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                            <span class="ms-2 text-sm text-gray-600">3 días antes</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="checkbox" wire:model="remind_1_day"
                                class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                            <span class="ms-2 text-sm text-gray-600">1 día antes</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="checkbox" wire:model="remind_0_day"
                                class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                            <span class="ms-2 text-sm text-gray-600">Mismo día (08:00 AM)</span>
                        </label>
                    </div>
                    <x-input-error :messages="$errors->get('remind_1_day')" class="mt-2" />
                </div>

            </div>

            <div class="mt-6 flex justify-end">
                <x-secondary-button wire:click="$dispatch('close-modal', 'deadline-form-modal')" type="button">
                    Cancelar
                </x-secondary-button>

                <x-primary-button class="ms-3" type="submit">
                    {{ $deadline ? 'Guardar Cambios' : 'Crear Plazo' }}
                </x-primary-button>
            </div>
        </form>
    </div>
</x-modal>