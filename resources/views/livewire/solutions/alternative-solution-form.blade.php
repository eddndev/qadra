<div>
    <!-- Header -->
    @if(!$showForm)
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-medium text-gray-900">Soluciones Alternas y Terminación Anticipada</h3>
                <button wire:click="create"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                    + Registrar Propuesta
                </button>
            </div>

            <!-- List -->
            <div class="grid grid-cols-1 gap-4">
                @forelse($solutions as $solution)
                        <div
                            class="bg-white shadow rounded-lg p-6 border-l-4 {{ $solution->status === 'cumplida' ? 'border-green-500' : ($solution->status === 'revocada' ? 'border-red-500' : 'border-indigo-500') }}">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h4 class="text-lg font-bold text-gray-900">{{ $solution->type }}</h4>
                                    <p class="text-sm text-gray-500">Propuesta: {{ $solution->proposal_date->format('d/m/Y') }}</p>
                                </div>
                                <span
                                    class="px-3 py-1 rounded-full text-xs font-semibold 
                                            {{ $solution->status === 'cumplida' ? 'bg-green-100 text-green-800' :
                            ($solution->status === 'aprobada' ? 'bg-blue-100 text-blue-800' :
                                ($solution->status === 'revocada' ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-800')) }}">
                                    {{ $solution->status_label }}
                                </span>
                            </div>

                        </div>

                        <div class="mt-4 bg-gray-50 p-3 rounded text-sm text-gray-700 whitespace-pre-line">
                            <strong>Condiciones:</strong><br>
                            {{ $solution->conditions }}
                        </div>

                        <div class="mt-4 flex justify-between items-center text-sm">
                            <div class="text-gray-500">
                                @if($solution->approved_at)
                                    <p>Aprobada: {{ $solution->approved_at->format('d/m/Y') }} por Juez {{ $solution->judge_name }}</p>
                                @endif
                                @if($solution->compliance_deadline)
                                    <p
                                        class="{{ now() > $solution->compliance_deadline && $solution->status !== 'cumplida' ? 'text-red-600 font-bold' : '' }}">
                                        Límite Cumplimiento: {{ $solution->compliance_deadline->format('d/m/Y') }}
                                    </p>
                                @endif
                            </div>

                            <div class="flex gap-2">
                                <button wire:click="edit('{{ $solution->id }}')"
                                    class="text-indigo-600 hover:text-indigo-800 font-medium">Editar</button>
                                @if($solution->status === 'aprobada')
                                    <button wire:click="markCompleted('{{ $solution->id }}')"
                                        wire:confirm="¿Confirmas que se han cumplido TODAS las condiciones?"
                                        class="text-green-600 hover:text-green-800 font-medium">
                                        Marcar Cumplida
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                <div class="text-center py-8 text-gray-500 bg-gray-50 rounded-lg">
                    No hay soluciones alternas registradas.
                </div>
            @endforelse
        </div>

    @else
    <!-- Form -->
    <div class="bg-gray-50 p-6 rounded-lg border border-gray-200">
        <h3 class="text-lg font-medium text-gray-900 mb-4">
            {{ $isEditing ? 'Editar Solución' : 'Nueva Propuesta de Solución' }}
        </h3>

        <form wire:submit.prevent="save">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                <!-- Tipo -->
                <div class="col-span-1 md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700">Tipo de Solución *</label>
                    <select wire:model="type"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="">-- Seleccionar --</option>
                        <option value="Acuerdo Reparatorio">Acuerdo Reparatorio</option>
                        <option value="Suspensión Condicional del Proceso">Suspensión Condicional del Proceso</option>
                        <option value="Procedimiento Abreviado">Procedimiento Abreviado</option>
                    </select>
                    @error('type') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <!-- Fechas -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Fecha de Propuesta *</label>
                    <input type="date" wire:model="proposal_date"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    @error('proposal_date') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Fecha de Aprobación Judicial</label>
                    <input type="date" wire:model.live="approved_at"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <span class="text-xs text-gray-500">Al llenar esto, el estado cambia a 'Aprobada'.</span>
                </div>

                <!-- Juez -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Juez que aprobó</label>
                    <input type="text" wire:model="judge_name"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Fecha Límite de Cumplimiento</label>
                    <input type="date" wire:model="compliance_deadline"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                </div>

                <!-- Condiciones -->
                <div class="col-span-1 md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700">Condiciones y Términos del Acuerdo *</label>
                    <textarea wire:model="conditions" rows="4"
                        placeholder="Detalle monto a pagar, plazos, obligaciones de hacer o no hacer..."
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                    @error('conditions') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

            </div>

            <div class="mt-6 flex justify-end gap-3">
                <button type="button" wire:click="cancel"
                    class="bg-gray-200 text-gray-700 px-4 py-2 rounded-md text-sm font-medium">
                    Cancelar
                </button>
                <button type="submit"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                    Guardar Solución
                </button>
            </div>
        </form>
    </div>
@endif
</div>