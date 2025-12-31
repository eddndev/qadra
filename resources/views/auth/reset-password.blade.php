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
                        Actualiza tu Contraseña
                    </h1>
                    <p class="text-blue-200 mb-8 text-lg">
                        Mantén tu cuenta segura actualizando tus credenciales de acceso periódicamente.
                    </p>

                    <div class="mt-8 flex items-center gap-2 text-sm text-gray-400">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                        <span>Encriptación de grado militar</span>
                    </div>
                </div>
            </div>

            <!-- Right Side (Form) -->
            <div class="md:w-1/2 bg-[#E2E8F0] p-12 flex flex-col justify-center">
                <div class="max-w-md mx-auto w-full">
                    <h2 class="text-3xl font-bold text-[#111344] mb-2">Restablecer Contraseña</h2>
                    <p class="text-blue-600 mb-8 font-medium">Ingresa tu nueva contraseña para continuar</p>

                    <form method="POST" action="{{ route('password.store') }}" class="space-y-5">
                        @csrf

                        <!-- Password Reset Token -->
                        <input type="hidden" name="token" value="{{ $request->route('token') }}">

                        <!-- Email Address -->
                        <div>
                            <x-input-label for="email" class="mb-1 !text-gray-900 !font-bold" :value="__('Correo electrónico')" />
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <x-text-input id="email" class="pl-10 pr-3 placeholder-gray-400" type="email"
                                    name="email" :value="old('email', $request->email)" required autofocus
                                    autocomplete="username" placeholder="tu@email.com" />
                            </div>
                            <x-input-error :messages="$errors->get('email')" class="mt-1" />
                        </div>

                        <!-- Password -->
                        <div>
                            <x-input-label for="password" class="mb-1 !text-gray-900 !font-bold" :value="__('Nueva Contraseña')" />
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                    </svg>
                                </div>
                                <x-text-input id="password" class="pl-10 pr-3 placeholder-gray-400" type="password"
                                    name="password" required autocomplete="new-password"
                                    placeholder="Min. 8 caracteres" />
                            </div>
                            <x-input-error :messages="$errors->get('password')" class="mt-1" />
                        </div>

                        <!-- Confirm Password -->
                        <div>
                            <x-input-label for="password_confirmation" class="mb-1 !text-gray-900 !font-bold"
                                :value="__('Confirmar Nueva Contraseña')" />
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                    </svg>
                                </div>
                                <x-text-input id="password_confirmation" class="pl-10 pr-3 placeholder-gray-400"
                                    type="password" name="password_confirmation" required autocomplete="new-password"
                                    placeholder="Confirmar contraseña" />
                            </div>
                            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1" />
                        </div>

                        <div class="pt-2">
                            <x-primary-button class="w-full justify-center">
                                Restablecer Contraseña
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-blank-layout>