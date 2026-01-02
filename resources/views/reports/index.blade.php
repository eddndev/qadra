<x-app-layout>
    <x-slot name="header">
        Reportes
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <div class="flex items-center justify-between mb-2">
                <div>
                    <h1 class="text-3xl font-bold text-[#111344]">Análisis de desempeño y métricas de expedientes</h1>
                </div>
                
                <div class="flex gap-2">
                    <button class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <svg class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Exportar PDF
                    </button>
                    <button class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                         <svg class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Exportar Excel
                    </button>
                </div>
            </div>

            <!-- Filters Toolbar -->
            <div class="flex flex-wrap gap-4 bg-white p-3 rounded-lg border border-gray-200 shadow-sm items-center">
                 <select class="block w-40 pl-3 pr-10 py-1.5 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                    <option>Últimos 30 días</option>
                    <option>Este año</option>
                    <option>Año pasado</option>
                </select>
                <select class="block w-40 pl-3 pr-10 py-1.5 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                    <option>Todas las etapas</option>
                    <option>Investigación</option>
                    <option>Juicio Oral</option>
                </select>
                <select class="block w-40 pl-3 pr-10 py-1.5 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                    <option>Todos los juzgados</option>
                </select>
            </div>

            <div class="mt-8">
                <h3 class="text-lg font-bold text-[#111344] mb-4">Resumen</h3>
                
                <!-- Summary Cards Carousel/Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <!-- Card 1 -->
                    <div class="bg-white rounded-lg p-4 border border-gray-200 shadow-sm relative">
                        <div class="absolute top-4 right-4 text-green-500 text-xs font-bold bg-green-50 px-1.5 py-0.5 rounded">+12%</div>
                        <div class="flex items-center gap-3 mb-2">
                            <div class="p-2 bg-blue-50 rounded-lg">
                                <svg class="w-5 h-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
                                </svg>
                            </div>
                            <span class="text-sm font-medium text-gray-500">Total de Expedientes</span>
                        </div>
                        <div class="text-2xl font-bold text-[#111344]">{{ $totalCases }}</div>
                    </div>

                    <!-- Card 2 -->
                    <div class="bg-white rounded-lg p-4 border border-gray-200 shadow-sm relative">
                        <div class="absolute top-4 right-4 text-green-500 text-xs font-bold bg-green-50 px-1.5 py-0.5 rounded">+8%</div>
                         <div class="flex items-center gap-3 mb-2">
                             <div class="p-2 bg-green-50 rounded-lg">
                                <svg class="w-5 h-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <span class="text-sm font-medium text-gray-500">Casos Cerrados</span>
                        </div>
                        <div class="text-2xl font-bold text-[#111344]">{{ $closedCases }}</div>
                    </div>

                    <!-- Card 3 -->
                    <div class="bg-white rounded-lg p-4 border border-gray-200 shadow-sm relative">
                         <div class="absolute top-4 right-4 text-red-500 text-xs font-bold bg-red-50 px-1.5 py-0.5 rounded">3%</div>
                         <div class="flex items-center gap-3 mb-2">
                             <div class="p-2 bg-red-50 rounded-lg">
                                <svg class="w-5 h-5 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                            </div>
                            <span class="text-sm font-medium text-gray-500">Casos con Alerta</span>
                        </div>
                        <div class="text-2xl font-bold text-[#111344]">{{ $alertCases }}</div>
                    </div>

                    <!-- Card 4 -->
                    <div class="bg-white rounded-lg p-4 border border-gray-200 shadow-sm">
                         <div class="flex items-center gap-3 mb-2">
                             <div class="p-2 bg-indigo-50 rounded-lg">
                                <svg class="w-5 h-5 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <span class="text-sm font-medium text-gray-500">Audiencias Realizadas</span>
                        </div>
                         <div class="text-2xl font-bold text-[#111344]">{{ $hearingsRealized }}</div>
                    </div>
                </div>
            </div>

            <!-- Charts Section -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mt-6">
                <!-- Line Chart -->
                <div class="bg-white p-6 rounded-lg border border-gray-200 shadow-sm lg:col-span-2">
                    <h3 class="text-sm font-bold text-[#111344] mb-4">Nuevos Expedientes por Mes</h3>
                    <div class="h-64">
                         <canvas id="casesChart"></canvas>
                    </div>
                </div>

                <!-- Donut Chart -->
                <div class="bg-white p-6 rounded-lg border border-gray-200 shadow-sm">
                    <h3 class="text-sm font-bold text-[#111344] mb-4">Resultados de Casos</h3>
                    <div class="h-48 flex justify-center">
                         <canvas id="resultsChart"></canvas>
                    </div>
                     <div class="mt-4 flex justify-center gap-3 text-xs">
                        <div class="flex items-center gap-1"><span class="w-2 h-2 rounded-full bg-blue-600"></span> Acuerdo</div>
                        <div class="flex items-center gap-1"><span class="w-2 h-2 rounded-full bg-green-500"></span> Ganado</div>
                        <div class="flex items-center gap-1"><span class="w-2 h-2 rounded-full bg-slate-400"></span> Pendiente</div>
                    </div>
                </div>
            </div>

            <!-- Table Section -->
            <div class="bg-white rounded-lg border border-gray-200 shadow-sm mt-6 overflow-hidden">
                 <div class="p-4 border-b border-gray-200">
                    <h3 class="text-lg font-bold text-[#111344]">Detalle de Expedientes</h3>
                    <p class="text-xs text-gray-500">Lista completa de casos en el periodo seleccionado</p>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">N° Carpeta</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Tipo de Caso</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Etapa Procesal</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Fecha Inicio</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Estado</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Resultado</th>
                                <th scope="col" class="relative px-6 py-3">
                                    <span class="sr-only">Acciones</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($cases as $case)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-xs font-medium text-blue-600">
                                    {{ $case->internal_folio ?? $case->nuc ?? 'N/A' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-xs text-gray-900">
                                    {{ $case->crime_type ?? 'Sin tipo' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-xs text-gray-500">
                                    {{ ucfirst($case->status) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-xs text-gray-500">
                                    {{ $case->created_at->format('d M Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @php
                                        // Mock alert logic
                                        $hasAlert = $case->deadlines->where('expires_at', '<', now())->isNotEmpty();
                                        $statusClass = $hasAlert ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800';
                                        $statusText = $hasAlert ? 'Con Alerta' : 'En Curso';
                                        if($case->status === 'closed') {
                                            $statusClass = 'bg-gray-100 text-gray-800';
                                            $statusText = 'Cerrado';
                                        }
                                    @endphp
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusClass }}">
                                        {{ $statusText }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-xs text-gray-500">
                                     <span class="bg-amber-50 text-amber-700 px-2 py-0.5 rounded border border-amber-100">Pendiente</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a href="#" class="text-blue-600 hover:text-blue-900 text-xs">Ver ↗</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- Pagination -->
                 <div class="px-4 py-3 border-t border-gray-200 bg-gray-50">
                    {{ $cases->links() }}
                </div>
            </div>
        </div>
    </div>

    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Line Chart
            const ctx1 = document.getElementById('casesChart').getContext('2d');
            new Chart(ctx1, {
                type: 'line',
                data: {
                    labels: @json($chartLabels),
                    datasets: [{
                        label: 'Nuevos Expedientes',
                        data: @json($chartData),
                        borderColor: '#2563EB',
                        backgroundColor: 'rgba(37, 99, 235, 0.1)',
                        tension: 0.4,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: { borderDash: [2, 4] }
                        },
                        x: {
                            grid: { display: false }
                        }
                    }
                }
            });

            // Donut Chart
            const ctx2 = document.getElementById('resultsChart').getContext('2d');
            new Chart(ctx2, {
                type: 'doughnut',
                data: {
                    labels: ['Acuerdo', 'Ganado', 'Pendiente', 'Perdido'],
                    datasets: [{
                        data: [15, 25, 50, 10], // Static mock for prototype consistency with $resultsDistribution logic
                        backgroundColor: [
                            '#2563EB', // Blue
                            '#10B981', // Green
                            '#94A3B8', // Slate
                            '#EF4444'  // Red
                        ],
                        borderWidth: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '70%',
                    plugins: {
                        legend: { display: false }
                    }
                }
            });
        });
    </script>
</x-app-layout>
