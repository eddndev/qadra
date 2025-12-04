<div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg h-full">
    <div class="p-6">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4 flex items-center">
            <svg class="w-5 h-5 mr-2 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            Plazos Próximos
        </h3>

        @if($deadlines->isEmpty())
            <p class="text-gray-500 dark:text-gray-400 text-sm">No hay plazos urgentes para esta semana.</p>
        @else
            <ul class="space-y-3">
                @foreach($deadlines as $deadline)
                    @php
                        $isPast = $deadline->expires_at->isPast();
                        $daysLeft = now()->diffInDays($deadline->expires_at, false);
                        $colorClass = $isPast ? 'text-red-600 font-bold' : ($daysLeft <= 3 ? 'text-orange-600' : 'text-gray-600 dark:text-gray-300');
                    @endphp
                    <li class="flex justify-between items-start p-3 bg-gray-50 dark:bg-gray-700 rounded-md">
                        <div>
                            <div class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                {{ $deadline->title }}
                            </div>
                            <div class="text-xs text-gray-500 dark:text-gray-400">
                                {{ $deadline->case->case_alias ?? $deadline->case->internal_folio }}
                            </div>
                        </div>
                        <div class="text-right">
                            <div class="text-xs {{ $colorClass }}">
                                {{ $deadline->expires_at->format('d/m') }}
                                <br>
                                @if($isPast)
                                    (Vencido)
                                @else
                                    ({{ (int)$daysLeft }} días)
                                @endif
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
            <div class="mt-4 text-center">
                <a href="{{ route('calendar') }}" class="text-sm text-indigo-600 hover:text-indigo-900 dark:text-indigo-400">Ver Calendario Completo &rarr;</a>
            </div>
        @endif
    </div>
</div>
