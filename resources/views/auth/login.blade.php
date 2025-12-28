<x-blank-layout>
    <div class="min-h-screen flex items-center justify-center bg-[#111344] p-4">
        <div class="w-full max-w-5xl bg-white rounded-xl shadow-2xl overflow-hidden flex flex-col md:flex-row">

            <!-- Left Side (Dark Blue) -->
            <div class="md:w-1/2 bg-[#1E293B] p-12 text-white flex flex-col justify-center relative overflow-hidden">
                <!-- Background Gradient Effect -->
                <div class="absolute inset-x-0 bottom-0 h-40 bg-gradient-to-t from-[#111344] to-transparent opacity-80">
                </div>

                <div class="relative z-10">
                    <!-- Brand -->
                    <div class="flex items-center gap-3 mb-8">
                        <x-application-logo class="h-12 w-12 text-white" />
                        <span class="text-4xl font-bold tracking-tight">Qadra</span>
                    </div>

                    <h1 class="text-3xl font-bold mb-4 leading-tight">
                        Gestión integral de expedientes y plazos penales
                    </h1>
                    <p class="text-blue-200 mb-8 text-lg">
                        Plataforma profesional para la gestión de actividad procesal penal
                    </p>

                    <ul class="space-y-4">
                        <li class="flex items-center gap-3">
                            <div class="bg-blue-500/20 p-1 rounded-full">
                                <svg class="w-5 h-5 text-blue-400" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                            <span class="text-gray-300">Control total de expedientes y plazos procesales</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <div class="bg-blue-500/20 p-1 rounded-full">
                                <svg class="w-5 h-5 text-blue-400" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                            <span class="text-gray-300">Alertas automáticas de vencimientos críticos</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <div class="bg-blue-500/20 p-1 rounded-full">
                                <svg class="w-5 h-5 text-blue-400" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                            <span class="text-gray-300">Acceso seguro desde cualquier ubicación</span>
                        </li>
                    </ul>

                    <div class="mt-12 flex items-center gap-2 text-sm text-gray-400">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                        <span>Conexión auténtica y cifrada</span>
                    </div>
                </div>
            </div>

            <!-- Right Side (Form) -->
            <div class="md:w-1/2 bg-[#E2E8F0] p-12 flex flex-col justify-center">
                <div class="max-w-md mx-auto w-full">
                    <h2 class="text-3xl font-bold text-[#111344] mb-2">Inicia sesión en Qadra</h2>
                    <p class="text-blue-600 mb-8 font-medium">Accede a tu plataforma de gestión procesal</p>

                    <!-- Session Status -->
                    <x-auth-session-status class="mb-4" :status="session('status')" />

                    <form method="POST" action="{{ route('login') }}" class="space-y-5">
                        @csrf

                        <!-- Email Address -->
                        <div>
                            <label for="email" class="block text-sm font-semibold text-[#111344] mb-1">Correo
                                electrónico</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <input id="email" type="email" name="email" :value="old('email')" required autofocus
                                    autocomplete="username"
                                    class="block w-full pl-10 pr-3 py-2.5 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm placeholder-gray-400"
                                    placeholder="usuario@fiscalia.gob.cl">
                            </div>
                            <x-input-error :messages="$errors->get('email')" class="mt-1" />
                        </div>

                        <!-- Password -->
                        <div>
                            <label for="password"
                                class="block text-sm font-semibold text-[#111344] mb-1">Contraseña</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                    </svg>
                                </div>
                                <input id="password" type="password" name="password" required
                                    autocomplete="current-password"
                                    class="block w-full pl-10 pr-10 py-2.5 bg-white border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm placeholder-gray-400"
                                    placeholder="••••••••••••••••">
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                    <svg class="h-5 w-5 text-gray-400 cursor-pointer hover:text-gray-600" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </div>
                            </div>
                            <x-input-error :messages="$errors->get('password')" class="mt-1" />
                        </div>

                        <!-- Include Remember Me & Forgot Password logic here or keep it minimum as in prototype -->
                        <div class="flex items-center justify-between">
                            <label for="remember_me" class="inline-flex items-center">
                                <input id="remember_me" type="checkbox"
                                    class="h-4 w-4 bg-gray-500 border-gray-300 rounded focus:ring-blue-500 text-[#1E293B]"
                                    name="remember">
                                <span class="ms-2 text-sm text-gray-600 font-medium">Recordar este dispositivo</span>
                            </label>
                        </div>

                        <div class="pt-2">
                            <button type="submit"
                                class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-bold text-white bg-[#1E40AF] hover:bg-[#111344] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#1E40AF] transition-colors">
                                Iniciar sesión
                            </button>
                        </div>

                        <div class="text-center mt-4">
                            @if (Route::has('password.request'))
                                <a class="text-sm font-medium text-gray-500 hover:text-blue-700"
                                    href="{{ route('password.request') }}">
                                    ¿Olvidaste tu contraseña?
                                </a>
                            @endif
                        </div>
                    </form>

                    <div class="mt-8 text-center text-xs text-blue-400">
                        Sistema de acceso controlado. Solo personal autorizado
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-blank-layout>