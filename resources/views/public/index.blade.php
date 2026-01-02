@extends('layouts.public')

@section('content')
    <!-- Hero Section -->
    <section class="relative bg-brand-900 overflow-hidden isolate">
        <!-- Abstract Background Pattern (Fallback/Overlay) -->
        <div class="absolute inset-x-0 -top-40 -z-10 transform-gpu overflow-hidden blur-3xl sm:-top-80" aria-hidden="true">
            <div class="relative left-[calc(50%-11rem)] aspect-[1155/678] w-[36.125rem] -translate-x-1/2 rotate-[30deg] bg-gradient-to-tr from-brand-300 to-brand-500 opacity-20 sm:left-[calc(50%-30rem)] sm:w-[72.1875rem]"
                style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)">
            </div>
        </div>

        <!-- Hero Background Asset -->
        <div class="absolute inset-0 -z-20 overflow-hidden opacity-10">
            <x-landing-image key="hero_bg" class="w-full h-full object-cover" alt="Background" />
        </div>

        <div class="container-app py-24 sm:py-32 lg:pb-40">
            <div class="mx-auto max-w-2xl text-center">
                <div class="mb-8 flex justify-center">
                    <div
                        class="relative rounded-full px-3 py-1 text-sm leading-6 text-brand-200 ring-1 ring-white/10 hover:ring-white/20">
                        Novedades: Versión Beta disponible. <a href="#" class="font-semibold text-white"><span
                                class="absolute inset-0" aria-hidden="true"></span>Leer más <span
                                aria-hidden="true">&rarr;</span></a>
                    </div>
                </div>
                <h1 class="text-4xl font-bold tracking-tight text-white sm:text-6xl">
                    Gestión Procesal Penal <br>
                    <span class="text-brand-300">Inteligente y Segura</span>
                </h1>
                <p class="mt-6 text-lg leading-8 text-brand-100">
                    Qadra centraliza y optimiza la gestión de casos, evidencia y audiencias, garantizando el cumplimiento
                    normativo en cada etapa del proceso penal.
                </p>
                <div class="mt-10 flex items-center justify-center gap-x-6">
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}"
                            class="btn btn-primary bg-brand-600 hover:bg-brand-500 text-white px-6 py-3 text-base shadow-lg shadow-brand-900/20">
                            Comenzar Prueba Gratuita
                        </a>
                    @endif
                    <a href="#features"
                        class="text-sm font-semibold leading-6 text-white hover:text-brand-200 transition-colors">
                        Conoce más <span aria-hidden="true">→</span>
                    </a>
                </div>
            </div>

            <!-- Dashboard Preview / Image Placeholder -->
            <div class="mt-10 flow-root sm:mt-24">
                <div
                    class="-mx-6 md:mx-0 md:-m-2 md:rounded-2xl md:bg-white/5 md:p-2 md:ring-1 md:ring-inset md:ring-white/10 lg:-m-4 lg:rounded-3xl lg:p-4 perspective-1000">
                    <!-- This would be a screenshot of the dashboard -->
                    <div
                        class="aspect-[16/9] w-full bg-neutral-800 shadow-2xl shadow-brand-900/40 ring-1 ring-white/10 overflow-hidden md:rounded-xl transform transition-all duration-700 hover:scale-[1.01] hover:shadow-brand-900/60">
                        <x-landing-image key="dashboard_preview" class="w-full h-full object-cover opacity-90 hover:opacity-100 transition-opacity duration-700"
                            alt="Dashboard Preview" />
                    </div>
                </div>
            </div>
        </div>

        <div class="absolute inset-x-0 top-[calc(100%-13rem)] -z-10 transform-gpu overflow-hidden blur-3xl sm:top-[calc(100%-30rem)]"
            aria-hidden="true">
            <div class="relative left-[calc(50%+3rem)] aspect-[1155/678] w-[36.125rem] -translate-x-1/2 bg-gradient-to-tr from-brand-300 to-brand-500 opacity-20 sm:left-[calc(50%+36rem)] sm:w-[72.1875rem]"
                style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)">
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-24 bg-white sm:py-32">
        <div class="container-app">
            <div class="mx-auto max-w-2xl lg:text-center">
                <h2 class="text-base font-semibold leading-7 text-brand-600">Todo lo que necesitas</h2>
                <p class="mt-2 text-3xl font-bold tracking-tight text-brand-900 sm:text-4xl">
                    Diseñado para Abogados y Firmas Legales
                </p>
                <p class="mt-6 text-lg leading-8 text-neutral-600">
                    Herramientas especializadas para gestionar cada aspecto del flujo de trabajo legal, desde la admisión
                    del caso hasta la sentencia.
                </p>
            </div>
            <div class="mx-auto mt-16 max-w-2xl sm:mt-20 lg:mt-24 lg:max-w-none">
                <dl class="grid max-w-xl grid-cols-1 gap-x-8 gap-y-16 lg:max-w-none lg:grid-cols-3">
                    <!-- Feature 1 -->
                    <div class="card border-0 shadow-none hover:shadow-none hover:bg-transparent">
                        <div class="card-body p-0">
                            <dt class="flex items-center gap-x-3 text-base font-semibold leading-7 text-brand-900">
                                <div class="h-10 w-10 flex items-center justify-center rounded-lg bg-brand-600">
                                    <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M2.25 12.75V12A2.25 2.25 0 014.5 9.75h15A2.25 2.25 0 0121.75 12v.75m-8.69-6.44l-2.12-2.12a1.5 1.5 0 00-1.061-.44H4.5A2.25 2.25 0 002.25 6v12a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9a2.25 2.25 0 00-2.25-2.25h-5.379a1.5 1.5 0 01-1.06-.44z" />
                                    </svg>
                                </div>
                                Gestión de Casos
                            </dt>
                            <dd class="mt-4 flex flex-auto flex-col text-base leading-7 text-neutral-600">
                                <p class="flex-auto">Organiza expedientes, documentos y notas en un solo lugar seguro.
                                    Accede a la información crítica al instante.</p>
                            </dd>
                        </div>
                    </div>

                    <!-- Feature 2 -->
                    <div class="card border-0 shadow-none hover:shadow-none hover:bg-transparent">
                        <div class="card-body p-0">
                            <dt class="flex items-center gap-x-3 text-base font-semibold leading-7 text-brand-900">
                                <div class="h-10 w-10 flex items-center justify-center rounded-lg bg-brand-600">
                                    <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M9 12.75L11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 01-1.043 3.296 3.745 3.745 0 01-3.296 1.043A3.745 3.745 0 0112 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 01-3.296-1.043 3.745 3.745 0 01-1.043-3.296A3.745 3.745 0 013 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 011.043-3.296 3.746 3.746 0 013.296-1.043A3.746 3.746 0 0112 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 013.296 1.043 3.746 3.746 0 011.043 3.296A3.745 3.745 0 0121 12z" />
                                    </svg>
                                </div>
                                Cadena de Custodia
                            </dt>
                            <dd class="mt-4 flex flex-auto flex-col text-base leading-7 text-neutral-600">
                                <p class="flex-auto">Registro inmutable de evidencia. Rastrea cada movimiento y asegura la
                                    integridad probatoria.</p>
                            </dd>
                        </div>
                    </div>

                    <!-- Feature 3 -->
                    <div class="card border-0 shadow-none hover:shadow-none hover:bg-transparent">
                        <div class="card-body p-0">
                            <dt class="flex items-center gap-x-3 text-base font-semibold leading-7 text-brand-900">
                                <div class="h-10 w-10 flex items-center justify-center rounded-lg bg-brand-600">
                                    <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5m-9-6h.008v.008H12v-.008zM12 15h.008v.008H12V15zm0 2.25h.008v.008H12v-.008zM9.75 15h.008v.008H9.75V15zm0 2.25h.008v.008H9.75v-.008zM7.5 15h.008v.008H7.5V15zm0 2.25h.008v.008H7.5v-.008zm6.75-4.5h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008V15zm0 2.25h.008v.008h-.008v-.008zm2.25-4.5h.008v.008H16.5v-.008zm0 2.25h.008v.008H16.5V15z" />
                                    </svg>
                                </div>
                                Calendario Judicial
                            </dt>
                            <dd class="mt-4 flex flex-auto flex-col text-base leading-7 text-neutral-600">
                                <p class="flex-auto">Sincroniza audiencias, plazos fatales y recordatorios. Nunca pierdas
                                    una fecha límite crítica.</p>
                            </dd>
                        </div>
                    </div>
                </dl>
            </div>
        </div>
    </section>

    <!-- Pricing Section Preview -->
    <section class="bg-neutral-50 py-24 sm:py-32">
        <div class="container-app relative">
            <div class="mx-auto max-w-2xl text-center">
                <h2 class="text-3xl font-bold tracking-tight text-brand-900 sm:text-4xl">Planes diseñados para crecer</h2>
                <p class="mt-6 text-lg leading-8 text-neutral-600">
                    Desde abogados independientes hasta grandes firmas. Elige el plan que mejor se adapte a ti.
                </p>
            </div>
            <!-- Pricing Cards -->
            <div class="mt-16 grid grid-cols-1 gap-8 lg:grid-cols-2 lg:gap-12 max-w-4xl mx-auto">
                <!-- Starter Plan -->
                <div class="card p-8 bg-white flex flex-col border-t-8 border-t-neutral-400 hover:shadow-lg transition-shadow">
                    <div class="mb-auto">
                        <h3 class="text-xl font-bold text-neutral-900">Starter</h3>
                        <p class="mt-4 text-sm text-neutral-600">Para despachos pequeños que inician su transformación digital.</p>
                        <p class="mt-6 flex items-baseline gap-x-1">
                            <span class="text-4xl font-bold tracking-tight text-neutral-900">$99</span>
                            <span class="text-sm font-semibold leading-6 text-neutral-600">/mes</span>
                        </p>
                        <ul role="list" class="mt-8 space-y-3 text-sm leading-6 text-neutral-600">
                            <li class="flex gap-x-3">
                                <svg class="h-6 w-5 flex-none text-brand-600" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                                </svg>
                                Hasta 3 usuarios
                            </li>
                            <li class="flex gap-x-3">
                                <svg class="h-6 w-5 flex-none text-brand-600" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                                </svg>
                                20 Casos Activos
                            </li>
                            <li class="flex gap-x-3">
                                <svg class="h-6 w-5 flex-none text-brand-600" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                                </svg>
                                10GB Almacenamiento
                            </li>
                        </ul>
                    </div>
                    <a href="{{ route('register') }}" class="mt-8 block rounded-md bg-neutral-100 px-3 py-2 text-center text-sm font-semibold leading-6 text-neutral-900 shadow-sm hover:bg-neutral-200 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-neutral-600">Comenzar</a>
                </div>

                <!-- Professional Plan -->
                <div class="card p-8 bg-white flex flex-col border-t-8 border-t-brand-600 ring-1 ring-brand-600/10 shadow-xl scale-105 z-10">
                    <div class="mb-auto">
                        <h3 class="text-xl font-bold text-brand-600">Professional</h3>
                        <p class="mt-4 text-sm text-neutral-600">Para firmas en crecimiento que requieren gestión avanzada y auditoría.</p>
                        <p class="mt-6 flex items-baseline gap-x-1">
                            <span class="text-4xl font-bold tracking-tight text-neutral-900">$249</span>
                            <span class="text-sm font-semibold leading-6 text-neutral-600">/mes</span>
                        </p>
                        <ul role="list" class="mt-8 space-y-3 text-sm leading-6 text-neutral-600">
                            <li class="flex gap-x-3">
                                <svg class="h-6 w-5 flex-none text-brand-600" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                                </svg>
                                Hasta 10 usuarios
                            </li>
                            <li class="flex gap-x-3">
                                <svg class="h-6 w-5 flex-none text-brand-600" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                                </svg>
                                100 Casos Activos
                            </li>
                            <li class="flex gap-x-3">
                                <svg class="h-6 w-5 flex-none text-brand-600" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                                </svg>
                                50GB Almacenamiento
                            </li>
                            <li class="flex gap-x-3">
                                <svg class="h-6 w-5 flex-none text-brand-600" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                                </svg>
                                Portal de Clientes
                            </li>
                            <li class="flex gap-x-3">
                                <svg class="h-6 w-5 flex-none text-brand-600" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                                </svg>
                                Reportes Avanzados y Auditoría
                            </li>
                        </ul>
                    </div>
                    <a href="{{ route('register') }}" class="mt-8 block rounded-md bg-brand-600 px-3 py-2 text-center text-sm font-semibold leading-6 text-white shadow-sm hover:bg-brand-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-brand-600">Obtener Acceso</a>
                </div>
            </div>
        </div>
    </section>
@endsection