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
                        Verifica tu Email
                    </h1>
                    <p class="text-blue-200 mb-8 text-lg">
                        Para comenzar a usar la plataforma, necesitamos confirmar que tu correo electrónico es real.
                    </p>

                    <div class="mt-8 flex items-center gap-2 text-sm text-gray-400">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        <span>Revisa tu bandeja de entrada</span>
                    </div>
                </div>
            </div>

            <!-- Right Side (Form) -->
            <div class="md:w-1/2 bg-[#E2E8F0] p-12 flex flex-col justify-center">
                <div class="max-w-md mx-auto w-full">
                    <h2 class="text-3xl font-bold text-[#111344] mb-2">¡Casi lista tu cuenta!</h2>
                    <p class="text-gray-600 mb-6 font-medium">
                        Gracias por registrarte. Antes de empezar, ¿podrías verificar tu dirección de correo electrónico
                        haciendo clic en el enlace que te acabamos de enviar?
                    </p>

                    <p class="text-sm text-gray-500 mb-8">
                        Si no recibiste el correo, con gusto te enviaremos otro.
                    </p>

                    @if (session('status') == 'verification-link-sent')
                        <div
                            class="mb-6 font-medium text-sm text-green-600 bg-green-50 p-4 rounded-lg border border-green-200">
                            {{ __('Se ha enviado un nuevo enlace de verificación a la dirección de correo electrónico que proporcionaste durante el registro.') }}
                        </div>
                    @endif

                    <div class="space-y-4">
                        <form method="POST" action="{{ route('verification.send') }}">
                            @csrf
                            <x-primary-button class="w-full justify-center">
                                {{ __('Reenviar Email de Verificación') }}
                            </x-primary-button>
                        </form>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="w-full text-center text-sm text-gray-500 hover:text-gray-900 underline focus:outline-none">
                                {{ __('Cerrar Sesión') }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-blank-layout>