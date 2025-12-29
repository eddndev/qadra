<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

        <!-- Mensajes de Estado -->
        @if (request()->get('success'))
            <div class="mb-6 bg-green-100 border-l-4 border-green-500 text-green-700 p-4" role="alert">
                <p class="font-bold">¡Suscripción Exitosa!</p>
                <p>Gracias por confiar en Qadra. Tu plan está activo.</p>
            </div>
        @endif

        @if (request()->get('cancel'))
            <div class="mb-6 bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4" role="alert">
                <p class="font-bold">Proceso cancelado</p>
                <p>No se realizó ningún cargo. Puedes intentarlo de nuevo cuando gustes.</p>
            </div>
        @endif

        <!-- Estado Actual -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-8">
            <div class="p-6 text-gray-900 flex flex-col md:flex-row justify-between items-center">
                <div>
                    <h3 class="text-lg font-semibold">Estado de la Suscripción</h3>
                    <div class="mt-2">
                        @if($isSubscribed)
                            <span
                                class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                Activa - Plan {{ $currentPlan }}
                            </span>
                            @if($tenant->subscription('default')->onGracePeriod())
                                <span class="ml-2 text-xs text-orange-500">
                                    (Se cancelará el {{ $tenant->subscription('default')->ends_at->format('d/m/Y') }})
                                </span>
                            @endif
                        @else
                            @if($onTrial)
                                <span
                                    class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                    Periodo de Prueba ({{ $tenant->trial_ends_at->diffForHumans(['parts' => 2]) }})
                                </span>
                            @else
                                <span
                                    class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                    Sin Suscripción Activa
                                </span>
                            @endif
                        @endif
                    </div>
                </div>

                <div class="mt-4 md:mt-0">
                    @if($isSubscribed)
                        <button wire:click="manage"
                            class="bg-gray-800 text-white hover:bg-gray-700 px-4 py-2 rounded-md font-semibold text-sm transition">
                            Gestionar Pagos y Facturas
                        </button>
                    @endif
                </div>
            </div>
        </div>

        @if(!$isSubscribed)
            <!-- Selector de Frecuencia -->
            <div class="flex justify-center mb-8">
                <div class="bg-gray-200 p-1 rounded-lg flex">
                    <button wire:click="$set('interval', 'monthly')"
                        class="px-4 py-2 rounded-md text-sm font-medium transition {{ $interval === 'monthly' ? 'bg-white shadow text-gray-900' : 'text-gray-500' }}">
                        Mensual
                    </button>
                    <button wire:click="$set('interval', 'yearly')"
                        class="px-4 py-2 rounded-md text-sm font-medium transition {{ $interval === 'yearly' ? 'bg-white shadow text-gray-900' : 'text-gray-500' }}">
                        Anual <span class="text-xs text-green-600 ml-1 font-bold">-17%</span>
                    </button>
                </div>
            </div>

            <!-- Tabla de Precios -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-5xl mx-auto">

                <!-- Plan Starter -->
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-200 relative">
                    <div class="p-8">
                        <h3 class="text-xl font-bold text-gray-900">Starter</h3>
                        <p class="text-gray-500 text-sm mt-2">Para despachos que inician su digitalización.</p>

                        <div class="my-6">
                            <span class="text-4xl font-extrabold text-gray-900">
                                ${{ $interval === 'monthly' ? '99' : '990' }}
                            </span>
                            <span class="text-gray-500">MXN / {{ $interval === 'monthly' ? 'mes' : 'año' }}</span>
                        </div>

                        <button wire:click="subscribe('starter', '{{ $interval }}')"
                            class="w-full block bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-4 rounded-lg transition text-center">
                            Elegir Starter
                        </button>

                        <ul class="mt-6 space-y-4 text-sm text-gray-600">
                            <li class="flex items-center">
                                <svg class="h-5 w-5 text-green-500 mr-2" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                                Hasta 3 Usuarios
                            </li>
                            <li class="flex items-center">
                                <svg class="h-5 w-5 text-green-500 mr-2" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                                20 Casos Activos
                            </li>
                            <li class="flex items-center">
                                <svg class="h-5 w-5 text-green-500 mr-2" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                                10 GB Almacenamiento S3
                            </li>
                            <li class="flex items-center text-gray-400">
                                <svg class="h-5 w-5 text-gray-300 mr-2" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                                Auditoría y Reportes
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Plan Professional -->
                <div
                    class="bg-white rounded-2xl shadow-xl overflow-hidden border-2 border-indigo-500 relative transform md:-translate-y-4">
                    <div class="absolute top-0 right-0 bg-indigo-500 text-white text-xs font-bold px-3 py-1 rounded-bl-lg">
                        RECOMENDADO</div>
                    <div class="p-8">
                        <h3 class="text-xl font-bold text-gray-900">Professional</h3>
                        <p class="text-gray-500 text-sm mt-2">Gestión avanzada y cumplimiento total.</p>

                        <div class="my-6">
                            <span class="text-4xl font-extrabold text-gray-900">
                                ${{ $interval === 'monthly' ? '249' : '2,490' }}
                            </span>
                            <span class="text-gray-500">MXN / {{ $interval === 'monthly' ? 'mes' : 'año' }}</span>
                        </div>

                        <button wire:click="subscribe('professional', '{{ $interval }}')"
                            class="w-full block bg-gray-900 text-white hover:bg-gray-800 font-bold py-3 px-4 rounded-lg transition text-center">
                            Elegir Professional
                        </button>

                        <ul class="mt-6 space-y-4 text-sm text-gray-600">
                            <li class="flex items-center">
                                <svg class="h-5 w-5 text-green-500 mr-2" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                                Hasta 10 Usuarios
                            </li>
                            <li class="flex items-center">
                                <svg class="h-5 w-5 text-green-500 mr-2" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                                100 Casos Activos
                            </li>
                            <li class="flex items-center">
                                <svg class="h-5 w-5 text-green-500 mr-2" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                                50 GB Almacenamiento S3
                            </li>
                            <li class="flex items-center">
                                <svg class="h-5 w-5 text-green-500 mr-2" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                                <strong>Auditoría y Reportes Avanzados</strong>
                            </li>
                            <li class="flex items-center">
                                <svg class="h-5 w-5 text-green-500 mr-2" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                                Portal de Clientes
                            </li>
                        </ul>
                    </div>
                </div>

            </div>
        @endif
    </div>
</div>