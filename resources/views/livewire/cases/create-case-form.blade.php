<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <form wire:submit="save" class="space-y-6">
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Identificación del Caso -->
                        <div>
                            <x-input-label for="internal_folio" :value="__('Folio Interno *')" />
                            <x-text-input wire:model="internal_folio" id="internal_folio" class="block mt-1 w-full" type="text" required autofocus placeholder="EXP-2025-001" />
                            <x-input-error :messages="$errors->get('internal_folio')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="nuc" :value="__('NUC (Fiscalía)')" />
                            <x-text-input wire:model="nuc" id="nuc" class="block mt-1 w-full" type="text" placeholder="Número Único de Caso" />
                            <x-input-error :messages="$errors->get('nuc')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="case_alias" :value="__('Alias del Caso')" />
                            <x-text-input wire:model="case_alias" id="case_alias" class="block mt-1 w-full" type="text" placeholder="Ej. Caso Lozoya" />
                            <x-input-error :messages="$errors->get('case_alias')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="start_date" :value="__('Fecha de Inicio *')" />
                            <x-text-input wire:model="start_date" id="start_date" class="block mt-1 w-full" type="date" required />
                            <x-input-error :messages="$errors->get('start_date')" class="mt-2" />
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 border-t border-gray-200 dark:border-gray-700 pt-6">
                        <!-- Clasificación Legal -->
                        <div>
                            <x-input-label for="crime_type" :value="__('Delito Principal *')" />
                            <select wire:model="crime_type" id="crime_type" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                <option value="">Seleccionar Delito...</option>
                                @foreach($crimeTypes as $crime)
                                    <option value="{{ $crime->name }}">{{ $crime->name }} ({{ $crime->severity }})</option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('crime_type')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="stage" :value="__('Etapa Procesal Inicial *')" />
                            <select wire:model="stage" id="stage" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                <option value="inv_inicial">Investigación Inicial</option>
                                <option value="inv_complementaria">Investigación Complementaria</option>
                                <option value="intermedia">Intermedia</option>
                                <option value="juicio">Juicio Oral</option>
                                <option value="ejecucion">Ejecución de Sentencia</option>
                            </select>
                            <x-input-error :messages="$errors->get('stage')" class="mt-2" />
                        </div>
                    </div>

                    <div>
                        <x-input-label for="notes" :value="__('Notas Iniciales')" />
                        <textarea wire:model="notes" id="notes" rows="3" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"></textarea>
                        <x-input-error :messages="$errors->get('notes')" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-end gap-4">
                        <a href="{{ route('cases.index') }}" class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100">
                            Cancelar
                        </a>
                        <x-primary-button>
                            {{ __('Crear Expediente') }}
                        </x-primary-button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>