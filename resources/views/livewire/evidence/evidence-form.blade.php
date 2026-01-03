<div class="max-w-4xl mx-auto">
    
    <!-- Card Container -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-8">
        
        <!-- Header -->
        <div class="flex items-center gap-3 mb-8 border-b border-slate-100 pb-4">
            <div class="p-2 bg-blue-50 rounded-lg">
                <svg class="w-8 h-8 text-[#111344]" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                </svg>
            </div>
            <div>
                <h2 class="text-2xl font-bold text-[#111344]">
                    Registro de Nueva Evidencia
                </h2>
                <p class="text-sm text-slate-500">
                    Alta de objeto físico/digital en la cadena de custodia
                </p>
            </div>
        </div>

        @if (session()->has('message'))
            <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-800 rounded-lg flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                {{ session('message') }}
            </div>
        @endif

        <form wire:submit.prevent="save" class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <!-- Caso Vinculado -->
                <div class="col-span-1 md:col-span-2">
                    <x-input-label for="case_id" :value="__('Caso Vinculado *')" class="mb-1" />
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 00.75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 00-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0112 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 01-.673-.38m0 0A2.18 2.18 0 013 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 013.413-.387m7.5 0V5.25A2.25 2.25 0 0013.5 3h-3a2.25 2.25 0 00-2.25 2.25v.894m7.5 0a48.667 48.667 0 00-7.5 0M12 12.75h.008v.008H12v-.008z" />
                            </svg>
                        </div>
                        <select wire:model="case_id" id="case_id"
                            class="pl-10 w-full border-slate-300 rounded-md shadow-sm focus:border-[#1E40AF] focus:ring-[#1E40AF] sm:text-sm px-4">
                            <option value="">-- Seleccionar Caso --</option>
                            @foreach($cases as $case)
                                <option value="{{ $case->id }}">
                                    {{ $case->internal_folio }} - {{ $case->case_alias ?? 'Sin Alias' }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    @error('case_id') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>

                <!-- Tipo de Evidencia -->
                <div>
                    <x-input-label for="type" :value="__('Tipo de Evidencia *')" class="mb-1" />
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 005.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 009.568 3z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 6h.008v.008H6V6z" />
                            </svg>
                        </div>
                        <select wire:model="type" id="type"
                            class="pl-10 w-full border-slate-300 rounded-md shadow-sm focus:border-[#1E40AF] focus:ring-[#1E40AF] sm:text-sm px-4">
                            <option value="">-- Seleccionar Tipo --</option>
                            <option value="arma">Arma / Balística</option>
                            <option value="documento_original">Documento Original</option>
                            <option value="dispositivo_electronico">Dispositivo Electrónico</option>
                            <option value="biologico">Biológico</option>
                            <option value="droga">Narcóticos</option>
                            <option value="dinero">Dinero / Valores</option>
                            <option value="vehiculo">Vehículo</option>
                            <option value="otro">Otro</option>
                        </select>
                    </div>
                    @error('type') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>

                <!-- Ubicación Inicial -->
                <div>
                    <x-input-label for="current_location" :value="__('Ubicación Física Inicial *')" class="mb-1" />
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                            </svg>
                        </div>
                        <x-text-input wire:model="current_location" id="current_location"
                            class="pl-10 px-4" placeholder="Ej: Bodega de Evidencias" />
                    </div>
                    @error('current_location') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>

                <!-- Descripción -->
                <div class="col-span-1 md:col-span-2">
                    <x-input-label for="description" :value="__('Descripción Detallada del Objeto *')" class="mb-1" />
                    <div class="relative">
                        <div class="absolute top-3 left-3 flex items-start pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25H12" />
                            </svg>
                        </div>
                        <textarea wire:model="description" id="description" rows="3"
                            placeholder="Describe marca, modelo, número de serie, color, estado..."
                            class="pl-10 w-full border-slate-300 rounded-md shadow-sm focus:border-[#1E40AF] focus:ring-[#1E40AF] sm:text-sm px-4 py-2"></textarea>
                    </div>
                    @error('description') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>

                <!-- Fecha de Recolección -->
                <div>
                    <x-input-label for="collected_at" :value="__('Fecha y Hora de Recolección *')" class="mb-1" />
                    <div class="relative">
                         <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                            </svg>
                        </div>
                        <input type="datetime-local" wire:model="collected_at" id="collected_at"
                            class="pl-10 w-full border-slate-300 rounded-md shadow-sm focus:border-[#1E40AF] focus:ring-[#1E40AF] sm:text-sm px-4">
                    </div>
                    @error('collected_at') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>

                <!-- Recolectado Por -->
                <div>
                    <x-input-label for="collected_by" :value="__('Recolectado Por (Autoridad)')" class="mb-1" />
                    <div class="relative">
                         <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                            </svg>
                        </div>
                        <x-text-input wire:model="collected_by" id="collected_by"
                             class="pl-10 px-4" placeholder="Nombre completo" />
                    </div>
                    @error('collected_by') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>

                <!-- Carga de Archivos (Fotos) -->
                <div class="col-span-1 md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Fotografías de la Evidencia</label>
                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-slate-300 border-dashed rounded-md bg-slate-50 hover:bg-slate-100 transition-colors cursor-pointer group">
                        <div class="space-y-1 text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400 group-hover:text-blue-500 transition-colors" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <div class="flex text-sm text-gray-600 justify-center">
                                <label for="file-upload" class="relative cursor-pointer bg-transparent rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                                    <span>Sube un archivo</span>
                                    <input id="file-upload" name="file-upload" type="file" class="sr-only" multiple>
                                </label>
                                <p class="pl-1">o arrastra y suelta</p>
                            </div>
                            <p class="text-xs text-gray-500">
                                PNG, JPG, GIF hasta 10MB
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Notas -->
                <div class="col-span-1 md:col-span-2">
                    <x-input-label for="notes" :value="__('Notas Adicionales')" class="mb-1" />
                    <div class="relative">
                         <div class="absolute top-3 left-3 flex items-start pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                            </svg>
                        </div>
                        <textarea wire:model="notes" id="notes" rows="2"
                             class="pl-10 w-full border-slate-300 rounded-md shadow-sm focus:border-[#1E40AF] focus:ring-[#1E40AF] sm:text-sm px-4 py-2"></textarea>
                    </div>
                </div>

            </div>

            <div class="mt-8 flex justify-end pt-4 border-t border-slate-100">
                <button type="submit"
                    class="inline-flex items-center px-6 py-3 bg-[#1E40AF] border border-transparent rounded-md font-bold text-xs text-white uppercase tracking-wider hover:bg-[#111344] focus:bg-[#111344] active:bg-[#0f172a] focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    <span wire:loading.remove wire:target="save">
                        Registrar Evidencia
                    </span>
                    <span wire:loading wire:target="save" class="flex items-center gap-2">
                        <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Procesando Indicio...
                    </span>
                </button>
            </div>
        </form>
    </div>
</div>