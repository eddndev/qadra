<x-modal name="hearing-form-modal" focusable>
    <div class="p-6">
        <h2 class="text-lg font-medium text-gray-900 mb-4">
            {{ $hearing ? 'Editar Audiencia' : 'Programar Nueva Audiencia' }}
        </h2>

        <form wire:submit.prevent="save">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <!-- Selección de Caso (Si no hay contexto) -->
                @if(!$case)
                    <div class="col-span-2">
                        <x-input-label for="case_id" value="Seleccionar Caso/Expediente" />
                        <select wire:model.live="case_id" id="case_id"
                            class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                            <option value="">-- Seleccionar Caso --</option>
                            @foreach($cases as $c)
                                <option value="{{ $c->id }}">[{{ $c->internal_folio }}] {{ $c->case_alias }}</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('case_id')" class="mt-2" />
                    </div>
                @endif

                <!-- Tipo de Audiencia -->
                <div class="col-span-2">
                    <x-input-label for="hearing_type" value="Tipo de Audiencia" />
                    <select wire:model="type" id="hearing_type"
                        class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                        @foreach($hearingTypes as $typeOption)
                            <option value="{{ $typeOption->name }}">{{ $typeOption->name }}</option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('type')" class="mt-2" />
                </div>

                <!-- Fecha y Hora -->
                <div>
                    <x-input-label for="scheduled_at" value="Fecha y Hora" />
                    <input type="datetime-local" wire:model="scheduled_at" id="scheduled_at"
                        class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                    <x-input-error :messages="$errors->get('scheduled_at')" class="mt-2" />
                </div>

                <!-- Duración -->
                <div>
                    <x-input-label for="duration_minutes" value="Duración Estimada (min)" />
                    <x-text-input wire:model="duration_minutes" id="duration_minutes" type="number" min="1"
                        class="block mt-1 w-full" />
                    <x-input-error :messages="$errors->get('duration_minutes')" class="mt-2" />
                </div>

                <!-- Sala / Juzgado -->
                <div>
                    <x-input-label for="courtroom" value="Sala / Juzgado" />
                    <x-text-input wire:model="courtroom" id="courtroom" type="text" class="block mt-1 w-full"
                        placeholder="Ej. Sala 1 Oralidad" />
                    <x-input-error :messages="$errors->get('courtroom')" class="mt-2" />
                </div>

                <!-- Juez -->
                <div>
                    <x-input-label for="judge_participant_id" value="Juez que preside" />
                    <select wire:model="judge_participant_id" id="judge_participant_id"
                        class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                        <option value="">-- Seleccionar Juez --</option>
                        @foreach($judges as $judge)
                            <option value="{{ $judge->id }}">{{ $judge->name }}</option>
                        @endforeach
                    </select>
                    @if($judges->isEmpty() && ($case || $case_id))
                        <p class="text-xs text-yellow-600 mt-1">No hay jueces asignados al caso. Agrega uno en la pestaña
                            Participantes.</p>
                    @endif
                    <x-input-error :messages="$errors->get('judge_participant_id')" class="mt-2" />
                </div>

                <!-- Link Virtual -->
                <div class="col-span-2">
                    <x-input-label for="virtual_link" value="Link de Videoconferencia (Opcional)" />
                    <x-text-input wire:model="virtual_link" id="virtual_link" type="url" class="block mt-1 w-full"
                        placeholder="https://zoom.us/..." />
                    <x-input-error :messages="$errors->get('virtual_link')" class="mt-2" />
                </div>

                <!-- Status and Result (Only Edit) -->
                @if($hearing)
                    <div class="col-span-2 border-t border-gray-200 pt-4 mt-2">
                        <h3 class="text-sm font-medium text-gray-900 mb-3">Resultado de la Audiencia</h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="status" value="Estatus" />
                                <select wire:model.live="status" id="status"
                                    class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                    <option value="programada">Programada</option>
                                    <option value="celebrada">Celebrada</option>
                                    <option value="cancelada">Cancelada</option>
                                    <option value="reprogramada">Reprogramada</option>
                                </select>
                                <x-input-error :messages="$errors->get('status')" class="mt-2" />
                            </div>

                            <div class="md:col-span-2" x-show="$wire.status !== 'programada'">
                                <x-input-label for="result_summary" value="Resumen de Acuerdos / Resoluciones" />
                                <textarea wire:model="result_summary" id="result_summary" rows="3"
                                    class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                    placeholder="Escribe aquí los resultados de la audiencia..."></textarea>
                                <x-input-error :messages="$errors->get('result_summary')" class="mt-2" />
                            </div>
                        </div>
                    </div>
                @endif

            </div>

            <div class="mt-6 flex justify-end">
                <x-secondary-button wire:click="$dispatch('close-modal', 'hearing-form-modal')" type="button">
                    Cancelar
                </x-secondary-button>

                <x-primary-button class="ms-3" type="submit">
                    {{ $hearing ? 'Actualizar Audiencia' : 'Programar Audiencia' }}
                </x-primary-button>
            </div>
        </form>
    </div>
</x-modal>