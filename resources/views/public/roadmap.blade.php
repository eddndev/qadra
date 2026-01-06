@extends('layouts.public')

@section('content')
<div class="relative bg-white overflow-hidden">
    {{-- Background Pattern --}}
    <div class="absolute inset-0 pb-96">
        <div class="absolute inset-0 bg-neutral-50"></div>
        <div class="absolute inset-y-0 left-0 w-1/2 bg-white"></div>
    </div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24">
        
        {{-- Header --}}
        <div class="max-w-3xl mx-auto text-center mb-20">
            <h1 class="text-4xl font-extrabold tracking-tight text-brand-900 sm:text-5xl mb-6">
                El Futuro de <span class="text-brand-600">Qadra</span>
            </h1>
            <p class="text-xl text-neutral-600">
                Estamos construyendo la plataforma legal más avanzada. Descubre lo que estamos preparando para ti.
            </p>
        </div>

        {{-- Timeline --}}
        <div class="relative max-w-4xl mx-auto">
            {{-- Vertical Line --}}
            <div class="absolute left-1/2 transform -translate-x-1/2 h-full w-1 bg-neutral-200"></div>

            {{-- ----------------------------------------------------------------------- --}}
            {{-- NOW AVAILABLE (Example)
            {{-- ----------------------------------------------------------------------- --}}
            <div class="relative mb-16">
                <div class="flex items-center justify-between w-full">
                    <div class="order-1 w-5/12 text-right pr-8">
                        <h3 class="text-xl font-bold text-brand-900">Gestión de Expedientes</h3>
                        <p class="text-neutral-600 mt-2 text-sm">Organización completa de casos, partes y documentos.</p>
                        <span class="inline-block mt-3 px-3 py-1 bg-green-100 text-green-800 text-xs font-semibold rounded-full uppercase tracking-wide">
                            Disponible
                        </span>
                    </div>
                    <div class="z-20 flex items-center order-1 bg-green-500 shadow-xl w-8 h-8 rounded-full border-4 border-white"></div>
                    <div class="order-1 w-5/12 pl-8"></div>
                </div>
            </div>

            {{-- ----------------------------------------------------------------------- --}}
            {{-- NEXT RELEASE (In Progress) --}}
            {{-- ----------------------------------------------------------------------- --}}
            <div class="relative mb-16">
                <div class="flex items-center justify-between w-full">
                    <div class="order-1 w-5/12"></div>
                    <div class="z-20 flex items-center order-1 bg-brand-500 shadow-xl w-8 h-8 rounded-full border-4 border-white">
                        <div class="w-2 h-2 bg-white rounded-full mx-auto animate-pulse"></div>
                    </div>
                    <div class="order-1 w-5/12 pl-8">
                        <h3 class="text-xl font-bold text-brand-900">Advanced Reporting</h3>
                        <p class="text-neutral-600 mt-2 text-sm leading-relaxed">
                            Presentación más completa de reportes, filtros granulares y opciones de exportación para análisis detallado del desempeño del despacho.
                        </p>
                        <span class="inline-block mt-3 px-3 py-1 bg-brand-100 text-brand-800 text-xs font-semibold rounded-full uppercase tracking-wide">
                            En Desarrollo
                        </span>
                    </div>
                </div>
            </div>

            {{-- ----------------------------------------------------------------------- --}}
            {{-- FUTURE --}}
            {{-- ----------------------------------------------------------------------- --}}
            
            {{-- Electronic Signatures --}}
            <div class="relative mb-16">
                <div class="flex items-center justify-between w-full">
                    <div class="order-1 w-5/12 text-right pr-8">
                        <h3 class="text-xl font-bold text-brand-900">Firmas Electrónicas</h3>
                        <p class="text-neutral-600 mt-2 text-sm leading-relaxed">
                            Integración nativa para la firma de documentos con validez legal, sin salir de la plataforma.
                        </p>
                        <span class="inline-block mt-3 px-3 py-1 bg-neutral-100 text-neutral-600 text-xs font-semibold rounded-full uppercase tracking-wide">
                            Planeado
                        </span>
                    </div>
                    <div class="z-20 flex items-center order-1 bg-neutral-200 w-8 h-8 rounded-full border-4 border-white"></div>
                    <div class="order-1 w-5/12 pl-8"></div>
                </div>
            </div>

            {{-- Robust Encryption --}}
            <div class="relative">
                <div class="flex items-center justify-between w-full">
                     <div class="order-1 w-5/12"></div>
                    <div class="z-20 flex items-center order-1 bg-neutral-200 w-8 h-8 rounded-full border-4 border-white"></div>
                    <div class="order-1 w-5/12 pl-8">
                        <h3 class="text-xl font-bold text-brand-900">Cifrado Robusto</h3>
                        <p class="text-neutral-600 mt-2 text-sm leading-relaxed">
                            Implementación de cifrado avanzado en reposo y en tránsito para garantizar la máxima seguridad de la información sensible.
                        </p>
                         <span class="inline-block mt-3 px-3 py-1 bg-neutral-100 text-neutral-600 text-xs font-semibold rounded-full uppercase tracking-wide">
                            Planeado
                        </span>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection