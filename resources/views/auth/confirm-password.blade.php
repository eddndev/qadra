<x-blank-layout>
    <div class="min-h-screen flex items-center justify-center bg-[#111344] p-4">
        <div class="w-full max-w-5xl bg-white rounded-xl shadow-2xl overflow-hidden flex flex-col md:flex-row">

            <!-- Left Side (Dark Blue) -->
            <div
                class="hidden md:flex md:w-1/2 bg-[#1E293B] p-12 text-white flex-col justify-center relative overflow-hidden">
                <!-- Background Gradient Effect -->
                <div class="absolute inset-x-0 bottom-0 h-40 bg-gradient-to-t from-[#111344] to-transparent opacity-80">
                </div>

                <div class="relative z-10">
                    <!-- Brand -->
                    <div class="flex items-center gap-3 mb-8">
                        <x-application-logo class="h-12 w-12 text-white" />
                        <span class="text-4xl font-bold tracking-tight">Qadra</span>
                    </div>

                    <h1 class="text-3xl font-bold mb-4 leading-tight text-white">
                        Confirmación de Seguridad
                    </h1>
                    <p class="text-blue-200 mb-8 text-lg">
                        Por motivos de seguridad, necesitamos verificar tu identidad antes de continuar con esta acción
                        sensible.
                    </p>

                    <div class="mt-8 flex items-center gap-2 text-sm text-gray-400">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                        <span>Protección de datos activa</span>
                    </div>
                </div>
            </div>

            <!-- Right Side (Form) -->
            <div class="md:w-1/2 bg-[#E2E8F0] p-12 flex flex-col justify-center">
                <div class="max-w-md mx-auto w-full">
                    <h2 class="text-3xl font-bold text-[#111344] mb-2">Confirmar Contraseña</h2>
                    <p class="text-gray-600 mb-8 font-medium">
                        Esta es un área segura de la aplicación. Por favor, confirma tu contraseña antes de continuar.
                    </p>

                    <form method="POST" action="{{ route('password.confirm') }}" class="space-y-5">
                        @csrf

                        <!-- Password -->
                        <div>
                            <x-input-label for="password" class="mb-1 !text-gray-900 !font-bold"
                                :value="__('Contraseña')" />
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                    </svg>
                                </div>
                                <x-text-input id="password" class="pl-10 pr-3 placeholder-gray-400" type="password"
                                    name="password" required autocomplete="current-password"
                                    placeholder="Tu contraseña actual" />
                            </div>
                            <x-input-error :messages="$errors->get('password')" class="mt-1" />
                        </div>

                        <div class="pt-2">
                            <x-primary-button class="w-full justify-center">
                                Confirmar Acceso
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-blank-layout>