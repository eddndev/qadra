<div>
    <div class="flex justify-between items-center mb-4">
        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Plazos y Términos</h3>
        <button 
            x-data=""
            x-on:click.prevent="$dispatch('open-modal', 'deadline-form-modal')"
            class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
            Nuevo Plazo
        </button>
    </div>

    @if($deadlines->isEmpty())
        <div class="text-center py-8 text-gray-500 bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <p>No hay plazos pendientes para este caso.</p>
        </div>
    @else
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Título / Descripción
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Vencimiento
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Tipo
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Estatus
                            </th>
                            <th scope="col" class="relative px-6 py-3">
                                <span class="sr-only">Acciones</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach($deadlines as $deadline)
                            @php
                                $daysLeft = now()->diffInDays($deadline->expires_at, false);
                                $isPast = $deadline->expires_at->isPast();
                                // Urgency Logic
                                $urgencyClass = 'bg-green-100 text-green-800';
                                if ($deadline->status !== 'cumplido') {
                                    if ($isPast) {
                                        $urgencyClass = 'bg-red-100 text-red-800'; // Vencido
                                    } elseif ($daysLeft <= 1) {
                                        $urgencyClass = 'bg-red-100 text-red-800'; // Crítico
                                    } elseif ($daysLeft <= 3) {
                                        $urgencyClass = 'bg-orange-100 text-orange-800'; // Alto
                                    } elseif ($daysLeft <= 7) {
                                        $urgencyClass = 'bg-yellow-100 text-yellow-800'; // Medio
                                    }
                                }
                            @endphp
                            <tr>
                                <td class="px-6 py-4">
                                    <div class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                        {{ $deadline->title }}
                                    </div>
                                    @if($deadline->description)
                                        <div class="text-sm text-gray-500 dark:text-gray-400 truncate max-w-xs">
                                            {{ $deadline->description }}
                                        </div>
                                    @endif
                                    @if($deadline->hearing)
                                        <div class="text-xs text-indigo-500 mt-1">
                                            Vinculado a: {{ $deadline->hearing->type }}
                                        </div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900 dark:text-gray-100">
                                        {{ $deadline->expires_at->format('d/m/Y H:i') }}
                                    </div>
                                    @if($deadline->status !== 'cumplido')
                                        <div class="text-xs font-bold mt-1 {{ str_replace('bg-', 'text-', $urgencyClass) }}">
                                            @if($isPast)
                                                Vencido hace {{ abs((int)$daysLeft) }} días
                                            @else
                                                Faltan {{ (int)$daysLeft }} días
                                            @endif
                                        </div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($deadline->is_fatal)
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                            FATAL
                                        </span>
                                    @else
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                            Ordinario
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        {{ $deadline->status === 'pendiente' ? $urgencyClass : '' }}
                                        {{ $deadline->status === 'cumplido' ? 'bg-green-100 text-green-800' : '' }}
                                        {{ $deadline->status === 'vencido' ? 'bg-gray-800 text-white' : '' }}">
                                        {{ ucfirst($deadline->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <button wire:click="$dispatch('edit-deadline', { deadlineId: '{{ $deadline->id }}' })" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300">
                                        Ver/Editar
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
