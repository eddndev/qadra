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
                        Bienvenido al Equipo
                    </h1>
                    <p class="text-blue-200 mb-8 text-lg">
                        Has sido invitado a colaborar en una plataforma de gestión legal moderna y eficiente.
                    </p>

                    <div class="mt-8 flex items-center gap-2 text-sm text-gray-400">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        <span>Colaboración en tiempo real</span>
                    </div>
                </div>
            </div>

            <!-- Right Side (Form) -->
            <div class="md:w-1/2 bg-[#E2E8F0] p-12 flex flex-col justify-center">
                <div class="max-w-md mx-auto w-full">
                    <h2 class="text-2xl md:text-3xl font-bold text-[#111344] mb-2">Completa tu Registro</h2>
                    <div class="text-sm text-gray-600 mb-6 bg-white p-4 rounded-lg border border-gray-200 shadow-sm">
                        <p>Aceptando invitación para unirte a:</p>
                        <p class="font-bold text-lg text-blue-900">{{ $invitation->tenant->name }}</p>
                        <p class="text-xs text-gray-500 mt-1">Rol asignado: <span
                                class="font-semibold">{{ ucfirst($invitation->role) }}</span></p>
                    </div>

                    <form method="POST" action="{{ route('register.invited.store') }}" class="space-y-5">
                        @csrf

                        <input type="hidden" name="invitation_token" value="{{ $invitation->token }}">

                        <!-- Name -->
                        <div>
                            <x-input-label for="name" class="mb-1 !text-gray-900 !font-bold" :value="__('Nombre Completo')" />
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </div>
                                <x-text-input id="name" class="pl-10 pr-3 placeholder-gray-400" type="text" name="name"
                                    :value="old('name')" required autofocus autocomplete="name"
                                    placeholder="Tu nombre y apellido" />
                            </div>
                            <x-input-error :messages="$errors->get('name')" class="mt-1" />
                        </div>

                        <!-- Email Address (Readonly) -->
                        <div>
                            <x-input-label for="email" class="mb-1 !text-gray-900 !font-bold" :value="__('Correo Electrónico')" />
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <x-text-input id="email" class="pl-10 pr-3 bg-gray-100 cursor-not-allowed text-gray-500"
                                    type="email" name="email" :value="$invitation->email" readonly />
                            </div>
                            <x-input-error :messages="$errors->get('email')" class="mt-1" />
                        </div>

                        <!-- Password -->
                        <div>
                            <x-input-label for="password" class="mb-1 !text-gray-900 !font-bold" :value="__('Contraseña')" />
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                    </svg>
                                </div>
                                <x-text-input id="password" type="password" name="password" required
                                    autocomplete="new-password" class="pl-10 pr-4 placeholder-gray-400"
                                    placeholder="Crea una contraseña segura" />
                            </div>
                            <x-input-error :messages="$errors->get('password')" class="mt-1" />
                        </div>

                        <!-- Confirm Password -->
                        <div>
                            <x-input-label for="password_confirmation" class="mb-1 !text-gray-900 !font-bold"
                                :value="__('Confirmar Contraseña')" />
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                    </svg>
                                </div>
                                <x-text-input id="password_confirmation" type="password" name="password_confirmation"
                                    required autocomplete="new-password" class="pl-10 pr-4 placeholder-gray-400"
                                    placeholder="Repite la contraseña" />
                            </div>
                            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1" />
                        </div>

                        <div class="pt-2">
                            <x-primary-button class="w-full justify-center">
                                Completar Registro
                            </x-primary-button>
                        </div>
                    </form>

                    <div class="text-center mt-4">
                        <a class="text-sm font-medium text-gray-500 hover:text-blue-700" href="{{ route('login') }}">
                            ¿Ya tienes cuenta? <span class="underline">Inicia Sesión</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-blank-layout>