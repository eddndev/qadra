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
                    
                    <!-- Modern Progress Bar -->
                    <div class="mb-8" x-show="register_firm !== false">
                        <div class="relative flex items-center justify-between w-full mx-auto gap-x-2 transition-all duration-300"
                            :class="register_firm === true ? 'max-w-lg' : 'max-w-32'">
                            <div class="absolute left-0 top-1/2 transform -translate-y-1/2 w-full h-1 bg-gray-200 z-0"></div>
                            
                            <!-- Step 1: User -->
                            <div class="relative z-10 flex flex-col items-center">
                                <div class="w-8 h-8 rounded-full flex items-center justify-center font-bold text-sm transition-colors duration-300"
                                    :class="step >= 1 ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-500'">
                                    1
                                </div>
                                <span class="text-xs font-medium mt-1" :class="step >= 1 ? 'text-blue-600' : 'text-gray-400'">Usuario</span>
                            </div>

                            <!-- Step 2: Type -->
                            <div class="relative z-10 flex flex-col items-center">
                                <div class="w-8 h-8 rounded-full flex items-center justify-center font-bold text-sm transition-colors duration-300"
                                    :class="step >= 2 ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-500'">
                                    2
                                </div>
                                <span class="text-xs font-medium mt-1" :class="step >= 2 ? 'text-blue-600' : 'text-gray-400'">Tipo</span>
                            </div>

                            <!-- Step 3: Firm (Conditional) -->
                            <div class="relative z-10 flex flex-col items-center" x-show="register_firm === true">
                                <div class="w-8 h-8 rounded-full flex items-center justify-center font-bold text-sm transition-colors duration-300"
                                    :class="step >= 3 ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-500'">
                                    3
                                </div>
                                <span class="text-xs font-medium mt-1" :class="step >= 3 ? 'text-blue-600' : 'text-gray-400'">Despacho</span>
                            </div>

                            <!-- Step 4: Plan (Conditional) -->
                            <div class="relative z-10 flex flex-col items-center" x-show="register_firm === true">
                                <div class="w-8 h-8 rounded-full flex items-center justify-center font-bold text-sm transition-colors duration-300"
                                    :class="step >= 4 ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-500'">
                                    4
                                </div>
                                <span class="text-xs font-medium mt-1" :class="step >= 4 ? 'text-blue-600' : 'text-gray-400'">Plan</span>
                            </div>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('register') }}" id="registerForm" class="space-y-5">
                        @csrf

                        <!-- STEP 1: User Info -->
                        <div x-show="step === 1" x-transition @keydown.enter.prevent="nextStep()">
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
                            <!-- Password -->
                            <div class="mb-4" x-data="{ show: false }">
                                <x-input-label for="password" class="mb-1 !text-gray-900 !font-bold" :value="__('Contraseña')" />
                                <div class="relative">
                                    <x-text-input id="password" class="block mt-1 w-full pr-10" x-bind:type="show ? 'text' : 'password'" name="password" required autocomplete="new-password" />
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                        <button type="button" @click="show = !show" class="focus:outline-none text-gray-400 hover:text-gray-600 transition-colors">
                                            <svg x-show="!show" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                            <svg x-show="show" style="display: none;" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                            </div>

                            <!-- Confirm Password -->
                            <!-- Confirm Password -->
                            <div class="mb-6" x-data="{ show: false }">
                                <x-input-label for="password_confirmation" class="mb-1 !text-gray-900 !font-bold" :value="__('Confirmar Contraseña')" />
                                <div class="relative">
                                    <x-text-input id="password_confirmation" class="block mt-1 w-full pr-10" x-bind:type="show ? 'text' : 'password'" name="password_confirmation" required />
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                        <button type="button" @click="show = !show" class="focus:outline-none text-gray-400 hover:text-gray-600 transition-colors">
                                            <svg x-show="!show" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                            <svg x-show="show" style="display: none;" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
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
                        <div x-show="step === 3" x-transition style="display: none;" @keydown.enter.prevent="nextStep()">
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