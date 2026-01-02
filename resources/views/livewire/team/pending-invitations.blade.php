<div class="mt-8 p-6 bg-white shadow sm:rounded-lg">
    <h3 class="text-lg font-medium text-gray-900 mb-4">Invitaciones Pendientes</h3>

    @if($invitations->isEmpty())
        <p class="text-gray-500 text-sm">No hay invitaciones pendientes.</p>
    @else
        <div class="grid grid-cols-1 gap-4">
            @foreach($invitations as $invitation)
                <div class="flex flex-col sm:flex-row sm:items-center justify-between p-4 bg-gray-50 border border-gray-200 rounded-lg gap-4">
                    <!-- Info -->
                    <div class="flex-grow">
                        <div class="flex items-center gap-3 mb-2">
                            <span class="font-bold text-gray-900">{{ $invitation->email }}</span>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 capitalize">
                                {{ $invitation->role }}
                            </span>
                        </div>
                        <div class="flex flex-col sm:flex-row sm:items-center gap-y-1 gap-x-6 text-sm text-gray-500">
                            <span class="flex items-center gap-1" title="Fecha de envío">
                                <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                Enviada {{ $invitation->created_at->diffForHumans() }}
                            </span>
                            <span class="flex items-center gap-1 text-amber-600" title="Fecha de expiración">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Expira {{ $invitation->expires_at->diffForHumans() }}
                            </span>
                        </div>
                    </div>

                    <!-- Action -->
                    <div class="flex-shrink-0">
                        <button wire:click="cancel('{{ $invitation->id }}')" 
                            wire:confirm="¿Estás seguro de cancelar esta invitación?"
                            class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-red-200 rounded-md shadow-sm text-sm font-medium text-red-600 hover:bg-red-50 hover:border-red-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-all">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            Cancelar
                        </button>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>