<div class="py-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center text-sm text-gray-500 mb-1">
                <a href="{{ route('cases.index') }}" class="hover:text-blue-600">Expedientes</a>
                <span class="mx-2">></span>
                <span class="text-gray-900 font-medium">Crear nuevo</span>
            </div>
        </div>

        <h1 class="text-3xl font-bold text-[#111344] mb-6">Configuración</h1>
        <!-- Header matches prototype text even if contextually 'Create Case' -->

        <form wire:submit="save" class="space-y-6">

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                <!-- Left Column (2/3 width) -->
                <div class="lg:col-span-2 space-y-6">

                    <!-- Datos Generales -->
                    <div class="bg-white shadow-sm rounded-lg border border-gray-200 p-6">
                        <div class="flex items-center gap-2 mb-4 text-[#111344]">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <h2 class="font-bold text-lg">Datos Generales</h2>
                        </div>

                        <div class="space-y-4">
                            <div>
                                <x-input-label for="internal_folio" :value="__('Número de carpeta *')" />
                                <x-text-input wire:model="internal_folio" id="internal_folio"
                                    class="block mt-1 w-full bg-gray-50" type="text" placeholder="Ej: CG-2024-002567"
                                    required />
                                <x-input-error :messages="$errors->get('internal_folio')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="crime_type" :value="__('Delito principal *')" />
                                <select wire:model="crime_type" id="crime_type"
                                    class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                    <option value="">Seleccionar delito</option>
                                    @foreach($crimeTypes as $crime)
                                        <option value="{{ $crime->name }}">{{ $crime->name }}</option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('crime_type')" class="mt-2" />
                            </div>

                            <!-- Mock fields for Courts/Prosecutor to match prototype visualization -->
                            <div>
                                <x-input-label for="court_name" :value="__('Juzgado *')" />
                                <select wire:model="court_name" id="court_name"
                                    class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                    <option value="">Seleccionar juzgado</option>
                                    <option value="Juzgado de Garantía 1">Juzgado de Garantía 1</option>
                                    <option value="Juzgado de Garantía 2">Juzgado de Garantía 2</option>
                                </select>
                            </div>

                            <div>
                                <x-input-label for="prosecutor_name" :value="__('Fiscalía / Unidad')" />
                                <select wire:model="prosecutor_name" id="prosecutor_name"
                                    class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                    <option value="">Seleccionar fiscalía</option>
                                    <option value="Fiscalía Centro Norte">Fiscalía Centro Norte</option>
                                    <option value="Fiscalía Oriente">Fiscalía Oriente</option>
                                </select>
                            </div>

                            <div>
                                <x-input-label for="start_date" :value="__('Fecha de inicio del expediente')" />
                                <x-text-input wire:model="start_date" id="start_date" class="block mt-1 w-full"
                                    type="text" placeholder="dd/mm/aaaa" onfocus="(this.type='date')"
                                    onblur="(this.type='text')" />
                            </div>
                        </div>
                    </div>

                    <!-- Personas Involucradas -->
                    <div class="bg-white shadow-sm rounded-lg border border-gray-200 p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center gap-2 text-[#111344]">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                                <h2 class="font-bold text-lg">Personas Involucradas</h2>
                            </div>
                            <button type="button"
                                class="text-xs bg-[#111344] text-white px-3 py-1.5 rounded hover:bg-blue-900 flex items-center gap-1">
                                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4v16m8-8H4" />
                                </svg>
                                Agregar imputado
                            </button>
                        </div>

                        <div class="space-y-4">
                            <!-- Imputado -->
                            <div class="border border-gray-200 rounded-md p-3 bg-gray-50">
                                <div class="text-sm font-bold text-blue-800 mb-2">Imputado(s)</div>
                                <div class="space-y-2">
                                    <x-text-input class="block w-full text-sm" placeholder="Nombre completo" />
                                    <x-text-input class="block w-full text-sm" placeholder="RUT" />
                                    <x-text-input class="block w-full text-sm" placeholder="Defensor" />
                                </div>
                            </div>

                            <!-- Other Roles -->
                            <div>
                                <x-input-label :value="__('Fiscal a cargo')"
                                    class="text-xs text-gray-500 uppercase font-bold" />
                                <select class="block mt-1 w-full text-sm border-gray-300 rounded-md shadow-sm">
                                    <option>Seleccionar fiscal</option>
                                    <option selected>Juan Díaz</option>
                                </select>
                            </div>
                            <div>
                                <x-input-label :value="__('Juez')" class="text-xs text-gray-500 uppercase font-bold" />
                                <x-text-input class="block mt-1 w-full text-sm"
                                    placeholder="Nombre del juez (opcional)" />
                            </div>
                        </div>
                    </div>

                    <!-- Etapa Procesal -->
                    <div class="bg-white shadow-sm rounded-lg border border-gray-200 p-6">
                        <div class="flex items-center gap-2 mb-4 text-[#111344]">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3" />
                            </svg>
                            <h2 class="font-bold text-lg">Etapa Procesal y Clasificación</h2>
                        </div>

                        <div class="space-y-4">
                            <div>
                                <x-input-label for="stage" :value="__('Etapa procesal actual')" />
                                <select wire:model="stage" id="stage"
                                    class="block mt-1 w-full border-gray-300 rounded-md shadow-sm">
                                    <option value="">Seleccionar etapa</option>
                                    <option value="inv_inicial">Investigación Inicial</option>
                                    <option value="inv_complementaria">Investigación Complementaria</option>
                                    <option value="intermedia">Intermedia</option>
                                    <option value="juicio">Juicio Oral</option>
                                </select>
                            </div>

                            <!-- Mock Risk Select -->
                            <div>
                                <x-input-label :value="__('Riesgo procesal')" />
                                <select class="block mt-1 w-full border-gray-300 rounded-md shadow-sm">
                                    <option>Seleccionar riesgo</option>
                                    <option>Alto</option>
                                    <option>Medio</option>
                                    <option>Bajo</option>
                                </select>
                            </div>

                            <div>
                                <x-input-label :value="__('Medidas cautelares')" class="mb-2" />
                                <div class="space-y-2">
                                    <label class="flex items-center">
                                        <input type="checkbox"
                                            class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" />
                                        <span class="ml-2 text-sm text-gray-600">Prisión preventiva</span>
                                    </label>
                                    <label class="flex items-center">
                                        <input type="checkbox"
                                            class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" />
                                        <span class="ml-2 text-sm text-gray-600">Firma periódica</span>
                                    </label>
                                    <label class="flex items-center">
                                        <input type="checkbox"
                                            class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" />
                                        <span class="ml-2 text-sm text-gray-600">Arraigo nacional</span>
                                    </label>
                                    <label class="flex items-center">
                                        <input type="checkbox"
                                            class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" />
                                        <span class="ml-2 text-sm text-gray-600">Prohibición de acercamiento</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Right Column (1/3 width) -->
                <div class="space-y-6">

                    <!-- Plazos Iniciales -->
                    <div class="bg-blue-50 shadow-sm rounded-lg border border-blue-100 p-6">
                        <div class="flex items-center justify-between mb-4 text-[#111344]">
                            <div class="flex items-center gap-2">
                                <svg class="w-5 h-5 text-blue-600" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <h2 class="font-bold text-lg">Plazos Iniciales</h2>
                            </div>
                            <button type="button"
                                class="text-xs bg-blue-600 text-white px-2 py-1 rounded hover:bg-blue-700 flex items-center gap-1">
                                + Agregar plazo
                            </button>
                        </div>

                        <div class="space-y-4">
                            <div class="bg-white p-3 rounded border border-blue-200">
                                <div class="flex items-center gap-2 mb-2">
                                    <span
                                        class="bg-[#111344] text-white text-xs font-bold w-5 h-5 flex items-center justify-center rounded-full">1</span>
                                    <span class="text-sm font-bold text-gray-700">Plazo</span>
                                </div>

                                <div class="space-y-3">
                                    <div>
                                        <x-input-label :value="__('Tipo de plazo')" class="text-xs" />
                                        <select class="block w-full text-sm border-gray-300 rounded shadow-sm py-1">
                                            <option>Seleccionar tipo</option>
                                        </select>
                                    </div>
                                    <div>
                                        <x-input-label :value="__('Fecha límite')" class="text-xs" />
                                        <input type="text" placeholder="dd/mm/aaaa"
                                            class="block w-full text-sm border-gray-300 rounded shadow-sm py-1"
                                            onfocus="(this.type='date')" onblur="(this.type='text')" />
                                    </div>
                                    <div>
                                        <x-input-label :value="__('Observaciones')" class="text-xs" />
                                        <input type="text" placeholder="Notas sobre este plazo (opcional)"
                                            class="block w-full text-sm border-gray-300 rounded shadow-sm py-1" />
                                    </div>
                                </div>
                            </div>

                            <div class="flex items-start gap-2 text-xs text-gray-500">
                                <svg class="w-4 h-4 mt-0.5 text-blue-500" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <p>Los plazos agregados aquí aparecerán en la sección de alertas del expediente.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Notas Internas -->
                    <div class="bg-white shadow-sm rounded-lg border border-gray-200 p-6">
                        <div class="flex items-center gap-2 mb-4 text-[#111344]">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                            </svg>
                            <h2 class="font-bold text-lg">Notas Internas</h2>
                        </div>

                        <div>
                            <x-input-label for="notes" :value="__('Comentarios del equipo')" />
                            <textarea wire:model="notes" id="notes" rows="4"
                                class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm resize-none"
                                placeholder="Añade observaciones, notas importantes o contexto del caso que puedan ser útiles para el equipo..."></textarea>
                        </div>

                        <div class="mt-4 flex items-start gap-2 text-xs text-gray-500">
                            <input type="checkbox" class="mt-0.5" />
                            <p>Estas notas solo serán visibles para miembros autorizados del equipo. No se incluyen en
                                documentos oficiales.</p>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="pt-4 space-y-3">
                        <button type="submit"
                            class="w-full justify-center inline-flex items-center px-4 py-2 bg-[#334D6E] border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-[#243b55] focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            Guardar y abrir expediente
                        </button>
                        <button type="button"
                            class="w-full justify-center inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                            Guardar como borrador
                        </button>
                    </div>

                </div>
            </div>

        </form>
    </div>
</div>