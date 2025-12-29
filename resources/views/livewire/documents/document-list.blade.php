<div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
    <div class="px-4 py-3 border-b border-gray-200 bg-gray-50">
        <h3 class="text-sm font-medium text-gray-700">Archivos Adjuntos</h3>
    </div>

    <ul class="divide-y divide-gray-200">
        @forelse($documents as $doc)
            <li class="px-4 py-3 flex items-center justify-between hover:bg-gray-50 transition">
                <div class="flex items-center">
                    <!-- Icon based on mime type -->
                    <div class="flex-shrink-0 h-10 w-10 rounded-lg bg-indigo-100 flex items-center justify-center text-indigo-600">
                        @if(Str::contains($doc->mime_type, 'image'))
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        @elseif(Str::contains($doc->mime_type, 'pdf'))
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 2H7a2 2 0 00-2 2v15a2 2 0 002 2z"></path></svg>
                        @else
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        @endif
                    </div>
                    
                    <div class="ml-4">
                        <div class="text-sm font-medium text-gray-900">
                            {{ $doc->file_name }}
                        </div>
                        <div class="text-xs text-gray-500 flex gap-2">
                            <span>{{ $doc->human_readable_size }}</span>
                            <span>&bull;</span>
                            <span class="capitalize">{{ str_replace('_', ' ', $doc->getCustomProperty('category', 'General')) }}</span>
                            <span>&bull;</span>
                            <span>{{ $doc->created_at->diffForHumans() }}</span>
                        </div>
                        @if($doc->getCustomProperty('description'))
                            <p class="text-xs text-gray-400 mt-0.5 italic">
                                "{{ $doc->getCustomProperty('description') }}"
                            </p>
                        @endif
                    </div>
                </div>

                <div class="flex items-center space-x-2">
                    <button wire:click="download('{{ $doc->id }}')" class="text-gray-400 hover:text-indigo-600 transition" title="Descargar">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                    </button>
                    
                    <button wire:click="delete('{{ $doc->id }}')" 
                            wire:confirm="¿Estás seguro de eliminar este documento? Esta acción no se puede deshacer."
                            class="text-gray-400 hover:text-red-600 transition" title="Eliminar">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                    </button>
                </div>
            </li>
        @empty
            <li class="px-4 py-8 text-center text-gray-500 text-sm">
                No hay documentos adjuntos todavía.
            </li>
        @endforelse
    </ul>
</div>