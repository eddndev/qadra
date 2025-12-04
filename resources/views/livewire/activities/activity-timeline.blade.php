<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    
    <!-- Formulario de Registro (Izquierda o Arriba en móvil) -->
    <div class="lg:col-span-1">
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 sticky top-6">
            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Registrar Actuación</h3>
            
            @if (session()->has('message'))
                <div class="mb-4 p-2 bg-green-100 text-green-700 rounded text-sm">
                    {{ session('message') }}
                </div>
            @endif

            <form wire:submit.prevent="save">
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tipo de Actividad *</label>
                        <select wire:model="type" class="mt-1 block w-full rounded-md border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            <option value="">-- Seleccionar --</option>
                            <option value="Llamada Telefónica">Llamada Telefónica</option>
                            <option value="Email">Email Enviado/Recibido</option>
                            <option value="Reunión">Reunión / Cita</option>
                            <option value="Visita a Juzgado">Visita a Juzgado</option>
                            <option value="Presentación de Escrito">Presentación de Escrito</option>
                            <option value="Diligencia">Diligencia / Trámite</option>
                            <option value="Visita Carcelaria">Visita Carcelaria</option>
                            <option value="Investigación">Investigación / Estudio</option>
                            <option value="Otro">Otro</option>
                        </select>
                        @error('type') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Título Breve *</label>
                        <input type="text" wire:model="title" placeholder="Ej: Llamada con MP Lic. Torres" class="mt-1 block w-full rounded-md border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        @error('title') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Fecha y Hora *</label>
                        <input type="datetime-local" wire:model="performed_at" class="mt-1 block w-full rounded-md border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        @error('performed_at') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Descripción</label>
                        <textarea wire:model="description" rows="3" class="mt-1 block w-full rounded-md border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"></textarea>
                    </div>
                    
                    <div>
                         <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Duración (minutos)</label>
                         <input type="number" wire:model="duration_minutes" placeholder="30" class="mt-1 block w-full rounded-md border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Adjuntar Archivos (Opcional)</label>
                        <input type="file" wire:model="attachments" multiple class="mt-1 block w-full text-sm text-gray-500 dark:text-gray-400
                          file:mr-4 file:py-2 file:px-4
                          file:rounded-full file:border-0
                          file:text-sm file:font-semibold
                          file:bg-indigo-50 file:text-indigo-700
                          hover:file:bg-indigo-100
                        "/>
                        <div wire:loading wire:target="attachments" class="text-xs text-indigo-600 mt-1">Subiendo...</div>
                    </div>

                    <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" wire:loading.attr="disabled">
                        <span wire:loading.remove wire:target="save">Registrar Actuación</span>
                        <span wire:loading wire:target="save">Guardando...</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Timeline (Derecha) -->
    <div class="lg:col-span-2">
        <!-- Filtros -->
        <div class="flex gap-4 mb-4">
            <select wire:model.live="filterUser" class="block w-full md:w-1/3 rounded-md border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                <option value="">Todos los Usuarios</option>
                @foreach($users as $u)
                    <option value="{{ $u->id }}">{{ $u->name }}</option>
                @endforeach
            </select>
            
            <select wire:model.live="filterType" class="block w-full md:w-1/3 rounded-md border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                <option value="">Todos los Tipos</option>
                <option value="Llamada Telefónica">Llamada</option>
                <option value="Email">Email</option>
                <option value="Visita a Juzgado">Visita Juzgado</option>
                <option value="Presentación de Escrito">Escrito</option>
            </select>
        </div>

        <div class="flow-root">
            <ul role="list" class="-mb-8">
                @forelse($activities as $activity)
                    <li>
                        <div class="relative pb-8">
                            @if(!$loop->last)
                                <span class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-gray-200 dark:bg-gray-700" aria-hidden="true"></span>
                            @endif
                            <div class="relative flex space-x-3">
                                <div>
                                    <span class="h-8 w-8 rounded-full bg-indigo-500 flex items-center justify-center ring-8 ring-white dark:ring-gray-900">
                                        <!-- Heroicon based on type logic handled in model or simple logic here -->
                                        <svg class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </span>
                                </div>
                                <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                    <div>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">
                                            <span class="font-medium text-gray-900 dark:text-white">{{ $activity->type }}</span>: 
                                            {{ $activity->title }} 
                                            <span class="mx-1">&bull;</span> 
                                            <span class="font-medium text-indigo-600">{{ $activity->user->name }}</span>
                                        </p>
                                        @if($activity->description)
                                            <p class="mt-2 text-sm text-gray-700 dark:text-gray-300 whitespace-pre-line bg-gray-50 dark:bg-gray-800 p-3 rounded-lg border border-gray-200 dark:border-gray-700">
                                                {{ $activity->description }}
                                            </p>
                                        @endif
                                        
                                        <!-- Adjuntos -->
                                        @if($activity->media->count() > 0)
                                            <div class="mt-2 flex flex-wrap gap-2">
                                                @foreach($activity->media as $media)
                                                    <a href="{{ $media->getTemporaryUrl(now()->addMinutes(5)) }}" target="_blank" class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 hover:bg-blue-200">
                                                        📎 {{ $media->file_name }}
                                                    </a>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                    <div class="text-right text-sm whitespace-nowrap text-gray-500 dark:text-gray-400">
                                        <time datetime="{{ $activity->performed_at }}">{{ $activity->performed_at->diffForHumans() }}</time>
                                        @if($activity->duration_minutes)
                                            <div class="text-xs text-gray-400 mt-1">{{ $activity->duration_minutes }} min</div>
                                        @endif
                                        @if($activity->performed_by === auth()->id())
                                            <button wire:click="delete('{{ $activity->id }}')" wire:confirm="¿Eliminar esta actuación?" class="block mt-2 text-xs text-red-500 hover:text-red-700 ml-auto">
                                                Eliminar
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                @empty
                    <li class="text-center py-10 text-gray-500">
                        No hay actuaciones registradas con estos filtros.
                    </li>
                @endforelse
            </ul>
            <div class="mt-4">
                {{ $activities->links() }}
            </div>
        </div>
    </div>
</div>