@extends('layouts.public')

@section('content')
<div class="relative min-h-screen bg-slate-50 overflow-hidden">
    {{-- Tech Background Pattern --}}
    <div class="absolute inset-0 z-0 pointer-events-none">
        <div class="absolute inset-0 bg-[linear-gradient(to_right,#e2e8f0_1px,transparent_1px),linear-gradient(to_bottom,#e2e8f0_1px,transparent_1px)] bg-[size:4rem_4rem] [mask-image:radial-gradient(ellipse_60%_50%_at_50%_0%,#000_70%,transparent_100%)] opacity-40"></div>
        <div class="absolute top-0 left-0 w-full h-full bg-slate-50/50"></div>
    </div>

    {{-- Hero Section --}}
    <section class="relative z-10 py-20 md:py-32 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-brand-50 border border-brand-100 text-brand-600 text-sm font-medium mb-6">
            <span class="relative flex h-2 w-2">
              <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-brand-400 opacity-75"></span>
              <span class="relative inline-flex rounded-full h-2 w-2 bg-brand-500"></span>
            </span>
            Características
        </div>
        <h1 class="text-4xl md:text-6xl font-bold text-brand-900 tracking-tight mb-6 font-sans">
            Control total y <span class="text-transparent bg-clip-text bg-gradient-to-r from-brand-600 to-brand-400">confidencialidad</span>
            <br class="hidden md:block"> para su despacho.
        </h1>
    </section>

    {{-- Features Grid --}}
    <section class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-32">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 lg:gap-12">
            
            {{-- Feature 1: Expedientes Digitales --}}
            <div class="group relative bg-white rounded-2xl p-8 border border-slate-100 shadow-[0_8px_30px_rgb(0,0,0,0.04)] hover:shadow-[0_8px_30px_rgb(0,0,0,0.12)] transition-all duration-300 hover:-translate-y-2 overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-brand-500 to-brand-300 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                <div class="flex flex-col sm:flex-row items-start gap-6">
                    <div class="flex-shrink-0">
                        {{-- Icon Container: Circular (rounded-full) with brand-50 bg --}}
                        <div class="w-16 h-16 rounded-full bg-brand-50 flex items-center justify-center text-brand-600 group-hover:bg-brand-600 group-hover:text-white transition-colors duration-300 shadow-sm">
                            {{-- Icon: BriefcaseIcon (Heroicons v2 Outline) --}}
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 00.75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 00-3.413-.387m4.5 2.613H3.75m16.5 0v2.25m0-2.25h-5.25m0 0c-.279-1.402-1.503-2.466-2.956-2.466h-1.089c-1.452 0-2.677 1.064-2.956 2.466m7.912 0h-7.912"></path>
                            </svg>
                        </div>
                    </div>
                    <div>
                        <h3 class="text-2xl font-bold text-brand-900 mb-3 font-sans group-hover:text-brand-600 transition-colors">Expedientes Digitales</h3>
                        <p class="text-slate-600 leading-relaxed text-base">
                            Organiza expedientes, documentos y notas en un solo lugar seguro. Accede a la información crítica al instante.
                        </p>
                    </div>
                </div>
            </div>

            {{-- Feature 2: Control de Evidencia --}}
            <div class="group relative bg-white rounded-2xl p-8 border border-slate-100 shadow-[0_8px_30px_rgb(0,0,0,0.04)] hover:shadow-[0_8px_30px_rgb(0,0,0,0.12)] transition-all duration-300 hover:-translate-y-2 overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-brand-500 to-brand-300 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                <div class="flex flex-col sm:flex-row items-start gap-6">
                    <div class="flex-shrink-0">
                         {{-- Icon Container: Circular (rounded-full) with brand-50 bg --}}
                         <div class="w-16 h-16 rounded-full bg-brand-50 flex items-center justify-center text-brand-600 group-hover:bg-brand-600 group-hover:text-white transition-colors duration-300 shadow-sm">
                            {{-- Icon: ShieldCheckIcon (Heroicons v2 Outline) --}}
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 01-1.043 3.296 3.745 3.745 0 01-3.296 1.043A3.745 3.745 0 0112 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 01-3.296-1.043 3.745 3.745 0 01-1.043-3.296A3.745 3.745 0 013 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 011.043-3.296 3.746 3.746 0 013.296-1.043A3.746 3.746 0 0112 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 013.296 1.043 3.746 3.746 0 011.043 3.296A3.745 3.745 0 0121 12z"></path>
                            </svg>
                        </div>
                    </div>
                    <div>
                        <h3 class="text-2xl font-bold text-brand-900 mb-3 font-sans group-hover:text-brand-600 transition-colors">Control de Evidencia</h3>
                        <p class="text-slate-600 leading-relaxed text-base">
                            Registro inmutable de evidencia. Rastrea cada movimiento y asegura la integridad probatoria.
                        </p>
                    </div>
                </div>
            </div>

            {{-- Feature 3: Calendario y Notificaciones --}}
            <div class="group relative bg-white rounded-2xl p-8 border border-slate-100 shadow-[0_8px_30px_rgb(0,0,0,0.04)] hover:shadow-[0_8px_30px_rgb(0,0,0,0.12)] transition-all duration-300 hover:-translate-y-2 overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-brand-500 to-brand-300 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                <div class="flex flex-col sm:flex-row items-start gap-6">
                    <div class="flex-shrink-0">
                         {{-- Icon Container: Circular (rounded-full) with brand-50 bg --}}
                         <div class="w-16 h-16 rounded-full bg-brand-50 flex items-center justify-center text-brand-600 group-hover:bg-brand-600 group-hover:text-white transition-colors duration-300 shadow-sm">
                            {{-- Icon: BellAlertIcon (Heroicons v2 Outline) --}}
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0M3.124 7.5A8.969 8.969 0 015.292 3m13.416 0a8.969 8.969 0 012.168 4.5"></path>
                            </svg>
                        </div>
                    </div>
                    <div>
                        <h3 class="text-2xl font-bold text-brand-900 mb-3 font-sans group-hover:text-brand-600 transition-colors">Calendario y Notificaciones</h3>
                        <p class="text-slate-600 leading-relaxed text-base">
                            Organiza audiencias, plazos fatales y recordatorios. Nunca pierdas una fecha límite crítica.
                        </p>
                    </div>
                </div>
            </div>

            {{-- Feature 4: Gestión Reservada de Datos --}}
            <div class="group relative bg-white rounded-2xl p-8 border border-slate-100 shadow-[0_8px_30px_rgb(0,0,0,0.04)] hover:shadow-[0_8px_30px_rgb(0,0,0,0.12)] transition-all duration-300 hover:-translate-y-2 overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-brand-500 to-brand-300 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                <div class="flex flex-col sm:flex-row items-start gap-6">
                    <div class="flex-shrink-0">
                         {{-- Icon Container: Circular (rounded-full) with brand-50 bg --}}
                         <div class="w-16 h-16 rounded-full bg-brand-50 flex items-center justify-center text-brand-600 group-hover:bg-brand-600 group-hover:text-white transition-colors duration-300 shadow-sm">
                            {{-- Icon: LockClosedIcon (Heroicons v2 Outline) --}}
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"></path>
                            </svg>
                        </div>
                    </div>
                    <div>
                        <h3 class="text-2xl font-bold text-brand-900 mb-3 font-sans group-hover:text-brand-600 transition-colors">Gestión Reservada de Datos</h3>
                        <p class="text-slate-600 leading-relaxed text-base">
                            Entornos de trabajo exclusivos para cada despacho, respetando la confidencialidad de su práctica legal.
                        </p>
                    </div>
                </div>
            </div>

        </div>
    </section>
</div>
@endsection