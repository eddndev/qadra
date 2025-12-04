<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Main Welcome / Stats (Placeholder for now) -->
                <div class="md:col-span-2 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <h3 class="text-lg font-semibold mb-2">Bienvenido, {{ Auth::user()->name }}</h3>
                        <p class="text-gray-600 dark:text-gray-400">Selecciona un módulo del menú para comenzar.</p>
                    </div>
                </div>

                <!-- Deadlines Widget -->
                <div class="md:col-span-1">
                    <livewire:deadlines.deadlines-widget />
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
