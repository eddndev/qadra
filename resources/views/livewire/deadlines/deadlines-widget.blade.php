<div class="overflow-hidden bg-white shadow-sm ring-1 ring-black ring-opacity-5 sm:rounded-lg">
    <table class="min-w-full divide-y divide-gray-300">
        <thead class="bg-[#eef2ff]">
            <tr>
                <th scope="col"
                    class="py-3.5 pl-4 pr-3 text-left text-xs font-semibold text-gray-900 sm:pl-6 uppercase tracking-wider">
                    Caso</th>
                <th scope="col"
                    class="px-3 py-3.5 text-left text-xs font-semibold text-gray-900 uppercase tracking-wider">Tipo de
                    Plazo</th>
                <th scope="col"
                    class="px-3 py-3.5 text-center text-xs font-semibold text-gray-900 uppercase tracking-wider">Fecha
                    Límite</th>
                <th scope="col"
                    class="px-3 py-3.5 text-center text-xs font-semibold text-gray-900 uppercase tracking-wider">Estado
                </th>
                <th scope="col"
                    class="px-3 py-3.5 text-center text-xs font-semibold text-gray-900 uppercase tracking-wider">Acción
                </th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200 bg-white">
            @if($deadlines->isEmpty())
                <tr>
                    <td colspan="5" class="px-3 py-4 text-sm text-center text-gray-500">
                        No hay plazos urgentes por vencer.
                    </td>
                </tr>
            @else
                @foreach($deadlines as $deadline)
                    @php
                        $isPast = $deadline->expires_at->isPast();
                        $daysLeft = now()->diffInDays($deadline->expires_at, false);

                        // Styling logic based on urgency
                        $rowClass = 'hover:bg-gray-50';
                        $dateColor = 'text-gray-700 font-medium';
                        $statusColor = 'text-gray-500';

                        if ($isPast) {
                            $rowClass = 'bg-red-50/30 hover:bg-red-50/60';
                            $dateColor = 'text-[#A52A2A] font-bold';
                            $statusColor = 'text-[#A52A2A] font-semibold';
                            $statusText = 'Vencido';
                        } elseif ($daysLeft <= 3) {
                            $dateColor = 'text-[#A52A2A] font-bold';
                            $statusColor = 'text-[#A52A2A] font-semibold';
                            // Format hours if less than 1 day? Or just "X días"
                            if ($daysLeft < 1) {
                                $hours = now()->diffInHours($deadline->expires_at);
                                $statusText = "Vence en {$hours}h";
                            } else {
                                $statusText = (int) $daysLeft . ' días';
                            }
                        } else {
                            $statusText = (int) $daysLeft . ' días';
                        }
                    @endphp

                    <tr class="{{ $rowClass }}">
                        <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">
                            <div class="font-bold text-[#111344]">
                                {{ $deadline->case->internal_folio ?? $deadline->case->case_number ?? 'S/N' }}
                            </div>
                            <div class="text-xs text-gray-500 truncate max-w-[150px]" title="{{ $deadline->case->case_alias }}">
                                {{ $deadline->case->case_alias ?? 'Sin alias' }}
                            </div>
                        </td>
                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                            {{ $deadline->title }}
                        </td>
                        <td class="whitespace-nowrap px-3 py-4 text-sm text-center {{ $dateColor }}">
                            {{ $deadline->expires_at->format('d M Y') }}
                        </td>
                        <td class="whitespace-nowrap px-3 py-4 text-sm text-center">
                            <span class="{{ $statusColor }}">
                                {{ $statusText }}
                            </span>
                        </td>
                        <td class="whitespace-nowrap px-3 py-4 text-sm text-center">
                            {{-- Assuming there is a route to view the case or deadline. Using '#' for now as closest link --}}
                            <a href="{{ route('cases.show', $deadline->case) }}"
                                class="text-[#1E40AF] hover:text-[#111344] flex justify-center items-center gap-1 text-xs font-medium">
                                Ver <span aria-hidden="true">&rarr;</span>
                            </a>
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
</div>