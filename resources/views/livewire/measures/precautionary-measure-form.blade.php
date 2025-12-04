<div>
    <!-- Header & Actions -->
    @if(!$showForm)
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-medium text-gray-900 dark:text-white">Medidas Cautelares Vigentes</h3>
            <button wire:click="create" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                + Nueva Medida
            </button>
        </div>

        <!-- List View -->
        <div class="bg-white dark:bg-gray-800 shadow overflow-hidden sm:rounded-md">
            <ul class="divide-y divide-gray-200 dark:divide-gray-700">
                @forelse($measures as $measure)
                    <li class="px-4 py-4 sm:px-6">
                        <div class="flex items-center justify-between">
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center justify-between mb-1">
                                    <p class="text-sm font-bold text-indigo-600 truncate">
                                        {{ $measure->measureType->name }}
                                    </p>
                                    <div class="ml-2 flex-shrink-0 flex">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            {{ $measure->status === 'vigente' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                            {{ ucfirst($measure->status) }}
                                        </span>
                                    </div>
                                </div>
                                <p class="text-sm text-gray-600 dark:text-gray-300">
                                    Imputado: <span class="font-medium">{{ $measure->participant->name }}</span>
                                </p>
                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                    {{ Str::limit($measure->description, 100) }}
                                </p>
                                <div class="mt-2 sm:flex sm:justify-between">
                                    <div class="sm:flex">
                                        <p class="flex items-center text-xs text-gray-500 dark:text-gray-400 mr-6">
                                            Impuesta: {{ $measure->imposed_at->format('d/m/Y') }}
                                        </p>
                                        @if($measure->review_date)
                                            <p class="flex items-center text-xs 
                                                {{ $measure->review_alert_level === 'critical' ? 'text-red-600 font-bold' : 'text-gray-500' }}">
                                                Revisión: {{ $measure->review_date->format('d/m/Y') }}
                                            </p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="ml-4 flex-shrink-0 flex flex-col gap-2">
                                <button wire:click="edit('{{ $measure->id }}')" class="text-indigo-600 hover:text-indigo-900 text-sm">Editar</button>
                                @if($measure->status === 'vigente')
                                    <button wire:click="revoke('{{ $measure->id }}')" 
                                            wire:confirm="¿Estás seguro de revocar esta medida?"
                                            class="text-red-600 hover:text-red-900 text-sm">Revocar</button>
                                @endif
                            </div>
                        </div>
                    </li>
                @empty
                    <li class="px-4 py-6 text-center text-gray-500 dark:text-gray-400 text-sm">
                        No hay medidas cautelares registradas en este caso.
                    </li>
                @endforelse
            </ul>
        </div>
    @else
        <!-- Form View -->
        <div class="bg-gray-50 dark:bg-gray-700 p-6 rounded-lg border border-gray-200 dark:border-gray-600">
            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">
                {{ $isEditing ? 'Editar Medida' : 'Registrar Nueva Medida' }}
            </h3>

            <form wire:submit.prevent="save">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    
                    <!-- Imputado -->
                    <div class="col-span-1 md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Imputado *</label>
                        <select wire:model="participant_id" class="mt-1 block w-full rounded-md border-gray-300 dark:bg-gray-800 dark:border-gray-600 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">-- Seleccionar --</option>
                            @foreach($imputed_participants as $imputed)
                                <option value="{{ $imputed->id }}">{{ $imputed->name }} {{ $imputed->is_detained ? '(Detenido)' : '' }}</option>
                            @endforeach
                        </select>
                        @error('participant_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        @if($imputed_participants->isEmpty())
                            <span class="text-xs text-orange-500 block mt-1">⚠ No hay imputados registrados en este caso. Agregue participantes primero.</span>
                        @endif
                    </div>

                    <!-- Tipo de Medida -->
                    <div class="col-span-1 md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tipo de Medida *</label>
                        <select wire:model.live="measure_type_id" class="mt-1 block w-full rounded-md border-gray-300 dark:bg-gray-800 dark:border-gray-600 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">-- Seleccionar Tipo --</option>
                            @foreach($measure_types as $type)
                                <option value="{{ $type->id }}">{{ $type->fraction }} - {{ $type->name }}</option>
                            @endforeach
                        </select>
                        @error('measure_type_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <!-- Fechas -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Fecha de Imposición *</label>
                        <input type="date" wire:model="imposed_at" class="mt-1 block w-full rounded-md border-gray-300 dark:bg-gray-800 dark:border-gray-600 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        @error('imposed_at') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Fecha de Revisión Obligatoria</label>
                        <input type="date" wire:model="review_date" class="mt-1 block w-full rounded-md border-gray-300 dark:bg-gray-800 dark:border-gray-600 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <span class="text-xs text-gray-500">Requerida para Prisión Preventiva</span>
                        @error('review_date') <span class="text-red-500 text-xs block">{{ $message }}</span> @enderror
                    </div>

                    <!-- Descripción -->
                    <div class="col-span-1 md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Descripción Detallada / Condiciones *</label>
                        <textarea wire:model="description" rows="3" placeholder="Especifique montos, direcciones, horarios o restricciones..." class="mt-1 block w-full rounded-md border-gray-300 dark:bg-gray-800 dark:border-gray-600 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                        @error('description') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                     <!-- Juez -->
                     <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Juez que impuso</label>
                        <input type="text" wire:model="judge_name" class="mt-1 block w-full rounded-md border-gray-300 dark:bg-gray-800 dark:border-gray-600 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>

                </div>

                <div class="mt-6 flex justify-end gap-3">
                    <button type="button" wire:click="cancel" class="bg-gray-200 dark:bg-gray-600 text-gray-700 dark:text-gray-200 px-4 py-2 rounded-md text-sm font-medium">
                        Cancelar
                    </button>
                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                        Guardar Medida
                    </button>
                </div>
            </form>
        </div>
    @endif
</div>