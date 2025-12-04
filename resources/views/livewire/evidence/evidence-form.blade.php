<div class="max-w-4xl mx-auto p-6 bg-white dark:bg-gray-800 rounded-lg shadow-md">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-white">
            Registro de Nueva Evidencia
        </h2>
        <span class="text-sm text-gray-500 dark:text-gray-400">
            Alta de objeto físico/digital
        </span>
    </div>

    @if (session()->has('message'))
        <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
            {{ session('message') }}
        </div>
    @endif

    <form wire:submit.prevent="save">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            
            <!-- Caso Vinculado -->
            <div class="col-span-1 md:col-span-2">
                <label for="case_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Caso Vinculado *</label>
                <select wire:model="case_id" id="case_id" class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <option value="">-- Seleccionar Caso --</option>
                    @foreach($cases as $case)
                        <option value="{{ $case->id }}">
                            {{ $case->internal_folio }} - {{ $case->case_alias ?? 'Sin Alias' }}
                        </option>
                    @endforeach
                </select>
                @error('case_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <!-- Tipo de Evidencia -->
            <div>
                <label for="type" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tipo de Evidencia *</label>
                <select wire:model="type" id="type" class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <option value="">-- Seleccionar Tipo --</option>
                    <option value="arma">Arma / Balística</option>
                    <option value="documento_original">Documento Original</option>
                    <option value="dispositivo_electronico">Dispositivo Electrónico (Celular, Laptop)</option>
                    <option value="biologico">Biológico (ADN, Sangre)</option>
                    <option value="droga">Narcóticos / Estupefacientes</option>
                    <option value="dinero">Dinero / Valores</option>
                    <option value="vehiculo">Vehículo</option>
                    <option value="otro">Otro</option>
                </select>
                @error('type') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <!-- Ubicación Inicial -->
            <div>
                <label for="current_location" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Ubicación Física Inicial *</label>
                <input type="text" wire:model="current_location" id="current_location" placeholder="Ej: Bodega de Evidencias, Caja Fuerte" class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                @error('current_location') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <!-- Descripción -->
            <div class="col-span-1 md:col-span-2">
                <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Descripción Detallada del Objeto *</label>
                <textarea wire:model="description" id="description" rows="3" placeholder="Describe marca, modelo, número de serie, color, estado..." class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                @error('description') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <!-- Fecha de Recolección -->
            <div>
                <label for="collected_at" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Fecha y Hora de Recolección *</label>
                <input type="datetime-local" wire:model="collected_at" id="collected_at" class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                @error('collected_at') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <!-- Recolectado Por -->
            <div>
                <label for="collected_by" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Recolectado Por (Autoridad)</label>
                <input type="text" wire:model="collected_by" id="collected_by" placeholder="Nombre del oficial o perito" class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                @error('collected_by') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <!-- Notas -->
            <div class="col-span-1 md:col-span-2">
                <label for="notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Notas Adicionales</label>
                <textarea wire:model="notes" id="notes" rows="2" class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
            </div>

        </div>

        <div class="mt-6 flex justify-end">
            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline transition duration-150 ease-in-out">
                <span wire:loading.remove wire:target="save">Registrar Evidencia</span>
                <span wire:loading wire:target="save">Guardando...</span>
            </button>
        </div>
    </form>
</div>