<x-app-layout>
    <x-slot name="header">
        Configuración
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="flex items-center justify-between mb-6">
                <h1 class="text-3xl font-bold text-[#111344]">Gestiona tu perfil, equipo, notificaciones y preferencias de seguridad</h1>
            </div>

            <div class="bg-white shadow-sm sm:rounded-lg overflow-hidden">
                <div class="p-8">
                    <h2 class="text-xl font-bold text-[#111344] mb-1">Información Personal</h2>
                    <p class="text-gray-500 mb-8">Actualiza tus datos personales y profesionales</p>

                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <!-- Keep Password and Delete sections below for functionality, though prototype focuses on Profile Info -->
            <div class="bg-white shadow-sm sm:rounded-lg overflow-hidden">
                <div class="p-8">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="bg-white shadow-sm sm:rounded-lg overflow-hidden">
                <div class="p-8">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>