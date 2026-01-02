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
            Tecnología Qadra
        </div>
        <h1 class="text-4xl md:text-6xl font-bold text-brand-900 tracking-tight mb-6 font-sans">
            Control total y <span class="text-transparent bg-clip-text bg-gradient-to-r from-brand-600 to-brand-400">seguridad absoluta</span>
            <br class="hidden md:block"> para su despacho.
        </h1>
        <p class="text-lg md:text-xl text-slate-600 max-w-2xl mx-auto leading-relaxed font-sans">
            La plataforma inteligente diseñada para organizar expedientes, proteger evidencia y cumplir plazos procesales con precisión militar.
        </p>
    </section>

    {{-- Features Grid --}}
    <section class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-32">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 lg:gap-12">
            
            {{-- Feature 1: Gestión de Casos --}}
            <div class="group relative bg-white rounded-2xl p-8 border border-slate-100 shadow-[0_8px_30px_rgb(0,0,0,0.04)] hover:shadow-[0_8px_30px_rgb(0,0,0,0.12)] transition-all duration-300 hover:-translate-y-2 overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-brand-500 to-brand-300 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                <div class="flex flex-col sm:flex-row items-start gap-6">
                    <div class="flex-shrink-0">
                        <div class="w-16 h-16 rounded-2xl bg-brand-50 flex items-center justify-center text-brand-600 group-hover:bg-brand-600 group-hover:text-white transition-colors duration-300 shadow-sm">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 19a2 2 0 01-2-2V7a2 2 0 012-2h4l2 2h4a2 2 0 012 2v1M5 19h14a2 2 0 002-2v-5a2 2 0 00-2-2H9a2 2 0 00-2 2v5a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                    </div>
                    <div>
                        <h3 class="text-2xl font-bold text-brand-900 mb-3 font-sans group-hover:text-brand-600 transition-colors">Expedientes Digitales</h3>
                        <p class="text-slate-600 leading-relaxed text-base">
                            Centralice toda la información de sus casos. Acceda al historial completo de actuaciones y estado procesal de carpetas con una arquitectura de datos optimizada para velocidad.
                        </p>
                    </div>
                </div>
            </div>

            {{-- Feature 2: Evidencia --}}
            <div class="group relative bg-white rounded-2xl p-8 border border-slate-100 shadow-[0_8px_30px_rgb(0,0,0,0.04)] hover:shadow-[0_8px_30px_rgb(0,0,0,0.12)] transition-all duration-300 hover:-translate-y-2 overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-brand-500 to-brand-300 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                <div class="flex flex-col sm:flex-row items-start gap-6">
                    <div class="flex-shrink-0">
                        <div class="w-16 h-16 rounded-2xl bg-brand-50 flex items-center justify-center text-brand-600 group-hover:bg-brand-600 group-hover:text-white transition-colors duration-300 shadow-sm">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <div>
                        <h3 class="text-2xl font-bold text-brand-900 mb-3 font-sans group-hover:text-brand-600 transition-colors">Control de Evidencia</h3>
                        <p class="text-slate-600 leading-relaxed text-base">
                            Garantice la admisibilidad de sus pruebas. Sistema avanzado de registro de cadena de custodia y trazabilidad digital inmutable para cada elemento probatorio.
                        </p>
                    </div>
                </div>
            </div>

            {{-- Feature 3: Notificaciones --}}
            <div class="group relative bg-white rounded-2xl p-8 border border-slate-100 shadow-[0_8px_30px_rgb(0,0,0,0.04)] hover:shadow-[0_8px_30px_rgb(0,0,0,0.12)] transition-all duration-300 hover:-translate-y-2 overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-brand-500 to-brand-300 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                <div class="flex flex-col sm:flex-row items-start gap-6">
                    <div class="flex-shrink-0">
                        <div class="w-16 h-16 rounded-2xl bg-brand-50 flex items-center justify-center text-brand-600 group-hover:bg-brand-600 group-hover:text-white transition-colors duration-300 shadow-sm">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                            </svg>
                        </div>
                    </div>
                    <div>
                        <h3 class="text-2xl font-bold text-brand-900 mb-3 font-sans group-hover:text-brand-600 transition-colors">Alertas Inteligentes</h3>
                        <p class="text-slate-600 leading-relaxed text-base">
                            Nunca pierda un plazo. Motor de notificaciones en tiempo real para vencimientos y audiencias, asegurando la presentación oportuna de cada promoción.
                        </p>
                    </div>
                </div>
            </div>

            {{-- Feature 4: Privacidad --}}
            <div class="group relative bg-white rounded-2xl p-8 border border-slate-100 shadow-[0_8px_30px_rgb(0,0,0,0.04)] hover:shadow-[0_8px_30px_rgb(0,0,0,0.12)] transition-all duration-300 hover:-translate-y-2 overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-brand-500 to-brand-300 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                <div class="flex flex-col sm:flex-row items-start gap-6">
                    <div class="flex-shrink-0">
                        <div class="w-16 h-16 rounded-2xl bg-brand-50 flex items-center justify-center text-brand-600 group-hover:bg-brand-600 group-hover:text-white transition-colors duration-300 shadow-sm">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                        </div>
                    </div>
                    <div>
                        <h3 class="text-2xl font-bold text-brand-900 mb-3 font-sans group-hover:text-brand-600 transition-colors">Privacidad Blindada</h3>
                        <p class="text-slate-600 leading-relaxed text-base">
                            Aislamiento total de datos por despacho. Arquitectura de seguridad que garantiza que la información de su firma sea exclusiva, inaccesible para terceros.
                        </p>
                    </div>
                </div>
            </div>

        </div>
    </section>
</div>
@endsection