<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <!-- FilePond -->
        <link href="https://unpkg.com/filepond/dist/filepond.css" rel="stylesheet">
        <link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css" rel="stylesheet">
    </head>
    <body class="font-sans antialiased">
        @php
            $globalTenant = \App\Models\Tenant::getGlobalTenant();
        @endphp

        @if($globalTenant && $globalTenant->onTrial() && !$globalTenant->subscribed('default'))
            <div class="bg-indigo-600 text-white px-4 py-2 text-center text-sm font-medium relative">
                <span>
                    Estás disfrutando de tu periodo de prueba gratuito. 
                    Te quedan <strong>{{ $globalTenant->trial_ends_at->diffInDays(now()) }} días</strong>.
                </span>
                <a href="{{ route('billing.index') }}" class="underline ml-2 hover:text-indigo-100">
                    Suscribirme ahora
                </a>
            </div>
        @endif

        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white dark:bg-gray-800 shadow-sm">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>

        <!-- FilePond Scripts -->
        <script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>
        <script src="https://unpkg.com/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.js"></script>
        <script src="https://unpkg.com/filepond-plugin-file-validate-size/dist/filepond-plugin-file-validate-size.js"></script>
        <script src="https://unpkg.com/filepond/dist/filepond.js"></script>
    </body>
</html>
