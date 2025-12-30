<x-blank-layout>
    <div class="min-h-screen flex items-center justify-center bg-[#111344] p-4">
        <div class="w-full max-w-5xl bg-white rounded-xl shadow-2xl overflow-hidden flex flex-col md:flex-row">

            <!-- Left Side (Dark Blue) - Hidden on Mobile -->
            <div class="hidden md:flex md:w-1/2 bg-[#1E293B] p-12 text-white flex-col justify-center relative overflow-hidden">
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
                        Únete a la plataforma legal más avanzada
                    </h1>
                    <p class="text-blue-200 mb-8 text-lg">
                        Gestiona expedientes, automatiza plazos y colabora con tu equipo en tiempo real.
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
                            <span class="text-gray-300">Prueba gratuita de 30 días para despachos</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <div class="bg-blue-500/20 p-1 rounded-full">
                                <svg class="w-5 h-5 text-blue-400" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                            <span class="text-gray-300">Sin tarjeta de crédito requerida para empezar</span>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Right Side (Wizard Form) -->
            <div class="md:w-1/2 bg-[#E2E8F0] p-8 md:p-12 flex flex-col justify-center"
                x-data="{
                    step: 1,
                    register_firm: null,
                    nextStep() {
                        if (this.step === 1) {
                            // Validate Step 1 (Basic HTML5 validation handled by browser on submit, but for wizard we simulate)
                            if (!document.getElementById('name').checkValidity() ||
                                !document.getElementById('email').checkValidity() ||
                                !document.getElementById('password').checkValidity() ||
                                !document.getElementById('password_confirmation').checkValidity()) {
                                // Trigger browser validation UI
                                document.getElementById('registerForm').reportValidity();
                                return;
                            }
                        }
                        this.step++;
                    },
                    prevStep() {
                        this.step--;
                    },
                    selectFirmOption(option) {
                        this.register_firm = option;
                        if (option === false) {
                            // User chose NOT to register a firm, submit form immediately
                            // We need to ensure required firm fields are NOT required in this case
                            // But since we are submitting, we handle validation server-side for optionality
                            document.getElementById('registerForm').submit();
                        } else {
                            this.nextStep();
                        }
                    }
                }">
                
                <div class="max-w-md mx-auto w-full">
                    <h2 class="text-2xl md:text-3xl font-bold text-[#111344] mb-2">Crear Cuenta</h2>
                    
                    <!-- Progress Indicator -->
                    <div class="flex items-center gap-2 mb-6 text-sm font-medium text-gray-500" x-show="register_firm !== false">
                        <span :class="step >= 1 ? 'text-blue-600' : ''">Usuario</span>
                        <span>/</span>
                        <span :class="step >= 2 ? 'text-blue-600' : ''">Tipo</span>
                        <span x-show="register_firm === true">
                            <span>/</span>
                            <span :class="step >= 3 ? 'text-blue-600' : ''">Despacho</span>
                            <span>/</span>
                            <span :class="step >= 4 ? 'text-blue-600' : ''">Plan</span>
                        </span>
                    </div>

                    <form method="POST" action="{{ route('register') }}" id="registerForm" class="space-y-5">
                        @csrf

                        <!-- STEP 1: User Info -->
                        <div x-show="step === 1" x-transition>
                             <p class="text-gray-600 mb-6 font-medium">Comencemos con tus datos personales.</p>
                            
                            <!-- Name -->
                            <div class="mb-4">
                                <x-input-label for="name" class="mb-1 !text-gray-900 !font-bold" :value="__('Nombre Completo')" />
                                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus />
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>

                            <!-- Email -->
                            <div class="mb-4">
                                <x-input-label for="email" class="mb-1 !text-gray-900 !font-bold" :value="__('Correo Electrónico')" />
                                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>

                            <!-- Password -->
                            <div class="mb-4">
                                <x-input-label for="password" class="mb-1 !text-gray-900 !font-bold" :value="__('Contraseña')" />
                                <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
                                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                            </div>

                            <!-- Confirm Password -->
                            <div class="mb-6">
                                <x-input-label for="password_confirmation" class="mb-1 !text-gray-900 !font-bold" :value="__('Confirmar Contraseña')" />
                                <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required />
                                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                            </div>

                            <x-primary-button type="button" @click="nextStep()" class="w-full justify-center">
                                Siguiente
                            </x-primary-button>
                        </div>

                        <!-- STEP 2: Firm Decision -->
                        <div x-show="step === 2" x-transition style="display: none;">
                            <p class="text-gray-600 mb-6 font-medium text-lg">¿Quieres registrar un despacho?</p>

                            <div class="grid grid-cols-1 gap-4">
                                <button type="button" @click="selectFirmOption(true)"
                                    class="p-4 border-2 border-gray-200 rounded-xl hover:border-blue-500 hover:bg-blue-50 transition text-left group">
                                    <div class="font-bold text-gray-900 group-hover:text-blue-700">Sí, crear un Despacho</div>
                                    <div class="text-sm text-gray-500 mt-1">
                                        Para abogados y equipos. Incluye gestión de casos, plazos y prueba gratis de 30 días.
                                    </div>
                                </button>

                                <button type="button" @click="selectFirmOption(false)"
                                    class="p-4 border-2 border-gray-200 rounded-xl hover:border-blue-500 hover:bg-blue-50 transition text-left group">
                                    <div class="font-bold text-gray-900 group-hover:text-blue-700">No, solo crear mi cuenta</div>
                                    <div class="text-sm text-gray-500 mt-1">
                                        Para usuarios invitados, paralegales independientes o si te unirás a un equipo existente más tarde.
                                    </div>
                                </button>
                            </div>

                            <button type="button" @click="prevStep()" class="mt-6 text-sm text-gray-500 hover:text-gray-900">
                                ← Volver
                            </button>
                        </div>

                        <!-- STEP 3: Firm Info -->
                        <div x-show="step === 3" x-transition style="display: none;">
                            <p class="text-gray-600 mb-6 font-medium">Datos del Despacho.</p>

                            <!-- Company Name -->
                            <div class="mb-4">
                                <x-input-label for="company_name" class="mb-1 !text-gray-900 !font-bold" :value="__('Nombre del Despacho')" />
                                <x-text-input id="company_name" class="block mt-1 w-full" type="text" name="company_name" :value="old('company_name')" />
                                <x-input-error :messages="$errors->get('company_name')" class="mt-2" />
                            </div>

                            <!-- RFC -->
                            <div class="mb-6">
                                <x-input-label for="tax_id" class="mb-1 !text-gray-900 !font-bold" :value="__('RFC del Despacho')" />
                                <x-text-input id="tax_id" class="block mt-1 w-full uppercase" type="text" name="tax_id" :value="old('tax_id')" placeholder="XAXX010101000" />
                                <x-input-error :messages="$errors->get('tax_id')" class="mt-2" />
                            </div>

                            <div class="flex gap-4">
                                <button type="button" @click="prevStep()" class="w-1/3 py-2 text-gray-600 hover:bg-gray-100 rounded-md">
                                    Atrás
                                </button>
                                <x-primary-button type="button" @click="nextStep()" class="w-2/3 justify-center">
                                    Ver Planes
                                </x-primary-button>
                            </div>
                        </div>

                        <!-- STEP 4: Plan Selection -->
                        <div x-show="step === 4" x-transition style="display: none;">
                            <p class="text-gray-600 mb-4 font-medium">Elige tu plan mensual.</p>
                            
                            <div class="bg-blue-50 border border-blue-100 rounded-lg p-3 mb-4 flex gap-3">
                                <svg class="w-6 h-6 text-blue-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                </svg>
                                <div class="text-sm text-blue-800">
                                    <strong>Prueba Gratuita de 30 Días</strong> activada automáticamente. No se realizará ningún cargo hoy.
                                </div>
                            </div>

                            <div class="space-y-3 mb-6">
                                @foreach($plans as $plan)
                                    <label class="relative flex items-start p-4 border rounded-lg cursor-pointer hover:border-blue-500 hover:bg-white transition-colors
                                        {{ old('plan_id') == $plan->id ? 'border-blue-500 bg-blue-50' : 'border-gray-200 bg-gray-50' }}">
                                        <div class="flex items-center h-5">
                                            <input id="plan_{{ $plan->id }}" name="plan_id" type="radio" value="{{ $plan->id }}" 
                                                {{ $loop->first ? 'checked' : '' }}
                                                class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <span class="block font-bold text-gray-900">{{ $plan->name }}</span>
                                            <span class="block text-gray-500">{{ $plan->description }}</span>
                                            <span class="block mt-1 font-semibold text-blue-600">
                                                ${{ number_format($plan->price_monthly / 100, 2) }} MXN / mes
                                            </span>
                                        </div>
                                    </label>
                                @endforeach
                            </div>

                             <div class="flex gap-4">
                                <button type="button" @click="prevStep()" class="w-1/3 py-2 text-gray-600 hover:bg-gray-100 rounded-md">
                                    Atrás
                                </button>
                                <x-primary-button class="w-2/3 justify-center">
                                    Completar Registro
                                </x-primary-button>
                            </div>
                        </div>

                    </form>

                    <div class="text-center mt-6" x-show="step === 1">
                        <a class="text-sm font-bold text-[#1E40AF] hover:text-[#111344]"
                            href="{{ route('login') }}">
                            ¿Ya tienes cuenta? <span class="underline">Inicia Sesión</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-blank-layout>