<div class="max-w-4xl mx-auto p-6 bg-white dark:bg-gray-800 rounded-lg shadow-md">
    <!-- Header Evidencia -->
    <div class="mb-8 p-4 bg-gray-50 dark:bg-gray-700 rounded border-l-4 border-indigo-500">
        <div class="flex justify-between">
            <div>
                <h3 class="text-lg font-bold text-gray-800 dark:text-white">
                    Evidencia: {{ $evidence->chain_of_custody_folio }}
                </h3>
                <p class="text-sm text-gray-600 dark:text-gray-300 mt-1">
                    {{ Str::limit($evidence->description, 100) }}
                </p>
            </div>
            <div class="text-right">
                <span class="px-3 py-1 text-xs font-semibold rounded-full 
                    {{ $evidence->status === 'en_custodia' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                    {{ $evidence->status_label }}
                </span>
                <p class="text-xs text-gray-500 mt-2">Ubicación Actual: {{ $evidence->current_location }}</p>
            </div>
        </div>
    </div>

    <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-white">
            Registrar Nuevo Movimiento
        </h2>
    </div>

    @if (session()->has('message'))
        <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
            {{ session('message') }}
        </div>
    @endif

    <form wire:submit.prevent="save">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            
            <!-- Fecha -->
            <div class="col-span-1 md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Fecha y Hora del Movimiento *</label>
                <input type="datetime-local" wire:model="movement_at" class="w-full md:w-1/2 border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                @error('movement_at') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <!-- Quien Entrega -->
            <div class="bg-gray-50 dark:bg-gray-750 p-4 rounded border border-gray-200 dark:border-gray-700">
                <h4 class="font-medium text-gray-700 dark:text-gray-300 mb-3 border-b pb-2">Entrega (Origen)</h4>
                
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nombre Completo *</label>
                <input type="text" wire:model="given_by" class="w-full mb-3 border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                @error('given_by') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror

                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Placa / Cargo / ID</label>
                <input type="text" wire:model="given_by_badge" class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            </div>

            <!-- Quien Recibe -->
            <div class="bg-gray-50 dark:bg-gray-750 p-4 rounded border border-gray-200 dark:border-gray-700">
                <h4 class="font-medium text-gray-700 dark:text-gray-300 mb-3 border-b pb-2">Recibe (Destino)</h4>
                
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nombre Completo *</label>
                <input type="text" wire:model="received_by" class="w-full mb-3 border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                @error('received_by') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror

                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Placa / Cargo / ID</label>
                <input type="text" wire:model="received_by_badge" class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            </div>

            <!-- Motivo y Destino -->
            <div class="col-span-1 md:col-span-2 border-t pt-4 mt-2">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Motivo del Movimiento *</label>
                        <select wire:model.live="reason" class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">-- Seleccionar Motivo --</option>
                            <option value="Traslado a Fiscalía">Traslado a Fiscalía</option>
                            <option value="Entrega a Juzgado">Entrega a Juzgado</option>
                            <option value="Traslado a Peritaje">Traslado a Peritaje</option>
                            <option value="Recepción en Despacho">Recepción en Despacho (Retorno)</option>
                            <option value="Devolución a Propietario">Devolución a Propietario</option>
                            <option value="Destrucción Autorizada">Destrucción Autorizada</option>
                            <option value="Otro">Otro</option>
                        </select>
                        @error('reason') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nueva Ubicación Física *</label>
                        <input type="text" wire:model="location" placeholder="Ej: Bodega Fiscalía Zona 1" class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        @error('location') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            <!-- Condición -->
            <div class="col-span-1 md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Condición de la Evidencia / Embalaje *</label>
                <textarea wire:model="condition" rows="2" class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                @error('condition') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

        </div>

        <div class="mt-8 flex justify-between">
            <a href="{{ route('evidence.create') }}" class="text-indigo-600 hover:text-indigo-800 font-medium">
                &larr; Volver al listado
            </a>
            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-6 rounded focus:outline-none focus:shadow-outline transition duration-150 ease-in-out">
                Firmar y Registrar Movimiento
            </button>
        </div>
    </form>
</div>