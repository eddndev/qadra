<div>
    <div class="flex justify-between items-center mb-4">
        <h3 class="text-lg font-medium text-gray-900">Plazos y Términos</h3>
        <button 
            x-data=""
            x-on:click.prevent="$dispatch('open-modal', 'deadline-form-modal')"
            class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
            Nuevo Plazo
        </button>
    </div>

    @if($deadlines->isEmpty())
        <div class="text-center py-8 text-gray-500 bg-white rounded-lg shadow-sm p-6 border border-gray-200">
            <p>No hay plazos pendientes para este caso.</p>
        </div>
    @else
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-300">
                    <thead class="bg-[#eef2ff]">
                        <tr>
                            <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-xs font-semibold text-gray-900 sm:pl-6 uppercase tracking-wider">
                                Título / Descripción
                            </th>
                            <th scope="col" class="px-3 py-3.5 text-center text-xs font-semibold text-gray-900 uppercase tracking-wider">
                                Vencimiento
                            </th>
                            <th scope="col" class="px-3 py-3.5 text-center text-xs font-semibold text-gray-900 uppercase tracking-wider">
                                Tipo
                            </th>
                            <th scope="col" class="px-3 py-3.5 text-center text-xs font-semibold text-gray-900 uppercase tracking-wider">
                                Estado
                            </th>
                            <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                                <span class="sr-only">Acciones</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 bg-white">
                        @foreach($deadlines as $deadline)
                            @php
                                $daysLeft = now()->diffInDays($deadline->expires_at, false);
                                $isPast = $deadline->expires_at->isPast();
                                
                                // Urgency Styling
                                $rowClass = 'hover:bg-gray-50';
                                $dateColor = 'text-gray-700';
                                $statusBadgeClass = 'bg-blue-50 text-blue-700 ring-blue-700/10';

                                if ($deadline->status !== 'cumplido') {
                                    if ($isPast) {
                                        $rowClass = 'bg-red-50/30 hover:bg-red-50/60';
                                        $dateColor = 'text-[#A52A2A] font-bold';
                                        $statusBadgeClass = 'bg-red-50 text-[#A52A2A] ring-[#A52A2A]/20';
                                    } elseif ($daysLeft <= 3) {
                                        $dateColor = 'text-[#D97706] font-bold'; // Amber for warning
                                        $statusBadgeClass = 'bg-amber-50 text-amber-700 ring-amber-600/20';
                                        if($daysLeft <= 1) {
                                             $statusBadgeClass = 'bg-red-50 text-[#A52A2A] ring-[#A52A2A]/20'; // Critical if < 24h/1 day
                                        }
                                    }
                                } else {
                                    $statusBadgeClass = 'bg-green-50 text-green-700 ring-green-600/20';
                                }
                            @endphp
                            <tr class="{{ $rowClass }}">
                                <td class="py-4 pl-4 pr-3 text-sm sm:pl-6">
                                    <div class="font-medium text-[#111344]">
                                        {{ $deadline->title }}
                                    </div>
                                    @if($deadline->description)
                                        <div class="text-xs text-gray-500 truncate max-w-xs mt-0.5">
                                            {{ $deadline->description }}
                                        </div>
                                    @endif
                                    @if($deadline->hearing)
                                        <div class="text-xs text-indigo-500 mt-1 flex items-center">
                                            <svg class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z" />
                                            </svg>
                                            Audiencia: {{ $deadline->hearing->type }}
                                        </div>
                                    @endif
                                </td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-center {{ $dateColor }}">
                                    {{ $deadline->expires_at->format('d M Y') }}
                                    <div class="text-xs font-normal text-gray-500">{{ $deadline->expires_at->format('H:i') }}</div>
                                </td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-center">
                                    @if($deadline->is_fatal)
                                        <span class="inline-flex items-center rounded-full bg-red-50 px-2 py-1 text-xs font-bold text-[#A52A2A] ring-1 ring-inset ring-[#A52A2A]/10">
                                            FATAL
                                        </span>
                                    @else
                                        <span class="inline-flex items-center rounded-full bg-gray-50 px-2 py-1 text-xs font-medium text-gray-600 ring-1 ring-inset ring-gray-500/10">
                                            Ordinario
                                        </span>
                                    @endif
                                </td>
                                <td class="whitespace-nowrap px-3 py-4 text-center text-sm">
                                    @if($deadline->status === 'pendiente')
                                         <span class="inline-flex items-center rounded-full px-2 py-1 text-xs font-medium ring-1 ring-inset {{ $statusBadgeClass }}">
                                            @if($isPast)
                                                Vencido ({{ abs((int)$daysLeft) }}d)
                                            @else
                                                Faltan {{ (int)$daysLeft }} días
                                            @endif
                                        </span>
                                    @else
                                        <span class="inline-flex items-center rounded-full bg-green-50 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-600/20">
                                            {{ ucfirst($deadline->status) }}
                                        </span>
                                    @endif
                                </td>
                                <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                                    <button wire:click="$dispatch('edit-deadline', { deadlineId: '{{ $deadline->id }}' })" class="text-indigo-600 hover:text-indigo-900">
                                        Editar
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif

    <!-- Deadline Form Modal -->
    <livewire:deadlines.deadline-form :case="$case" />
</div>
