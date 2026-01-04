<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-gray-50">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Qadra') }}</title>

    <link rel="icon" type="image/svg+xml" href="/favicon.svg">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700|merriweather:400,700&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <!-- FilePond -->
        <link href="https://unpkg.com/filepond/dist/filepond.css" rel="stylesheet">
        <link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css" rel="stylesheet">
    </head>
    <body class="h-full font-sans antialiased text-gray-900 bg-gray-50">
        <div class="min-h-screen flex bg-gray-50">
            <!-- Sidebar -->
            <x-sidebar />

            <!-- Main Content -->
            <div class="lg:pl-64 flex flex-col flex-1 min-h-screen transition-all duration-300">
                
                <!-- Topbar -->
                <x-topbar>
                    <x-slot name="header">
                        {{ $header ?? '' }}
                    </x-slot>
                </x-topbar>

                <!-- Page Content -->
                <main class="flex-1 py-8 px-6">
                     @php
                        $globalTenant = \App\Models\Tenant::getGlobalTenant();
                    @endphp

                    @if($globalTenant && $globalTenant->onTrial())
                        <div class="mb-6 rounded-md bg-[#111344] p-4 border border-blue-900 shadow-sm">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <svg class="h-6 w-6 text-white" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-4 flex-1 md:flex md:justify-between md:items-center">
                                    <p class="text-sm text-white">
                                        @if($globalTenant->subscribed('default'))
                                            Tu periodo de prueba finaliza en <span class="font-bold">{{ (int) ceil(now()->floatDiffInDays($globalTenant->trial_ends_at)) }} días</span>. Después se aplicará el cargo de tu plan.
                                        @else
                                            Estás en tu periodo de prueba gratuito. Te quedan <span class="font-bold">{{ (int) ceil(now()->floatDiffInDays($globalTenant->trial_ends_at)) }} días</span>.
                                        @endif
                                    </p>
                                    @if(!$globalTenant->subscribed('default'))
                                        <p class="mt-3 text-sm md:mt-0 md:ml-6">
                                            <a href="{{ route('billing.index') }}" class="inline-flex items-center px-4 py-2 bg-[#1E40AF] border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-md whitespace-nowrap">
                                                Seleccionar un plan
                                            </a>
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif

                    {{ $slot }}
                </main>
            </div>
        </div>

        <!-- FilePond Scripts -->
        <script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>
        <script src="https://unpkg.com/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.js"></script>
        <script src="https://unpkg.com/filepond-plugin-file-validate-size/dist/filepond-plugin-file-validate-size.js"></script>
        <script src="https://unpkg.com/filepond/dist/filepond.js"></script>
    </body>
</html>
