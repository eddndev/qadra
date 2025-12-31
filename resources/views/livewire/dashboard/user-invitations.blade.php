<div>
    <h3 class="font-bold text-lg text-[#111344] mb-4">Invitaciones Pendientes</h3>

    @if($invitations->isEmpty())
        <div class="text-center py-6 text-gray-500 bg-gray-50 rounded-lg border border-dashed border-gray-300">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
            </svg>
            <p class="mt-2 text-sm">No tienes invitaciones pendientes.</p>
        </div>
    @else
        <ul class="divide-y divide-gray-100">
            @foreach($invitations as $invitation)
                <li class="py-4 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div>
                        <p class="text-sm font-medium text-gray-900">
                            {{ $invitation->tenant->name }}
                        </p>
                        <p class="text-xs text-gray-500">
                            Te ha invitado como <strong>{{ $invitation->role }}</strong>
                        </p>
                        <p class="text-xs text-gray-400">
                            Expira {{ $invitation->expires_at->diffForHumans() }}
                        </p>
                    </div>

                    <div class="flex items-center gap-2">
                        <a href="{{ route('team.join', $invitation->token) }}"
                            class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none transition ease-in-out duration-150">
                            Aceptar
                        </a>
                    </div>
                </li>
            @endforeach
        </ul>
    @endif
</div>