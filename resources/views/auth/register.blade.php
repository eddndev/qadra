<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Section: Datos del Despacho -->
        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Datos del Despacho</h3>

        <!-- Company Name -->
        <div>
            <x-input-label for="company_name" :value="__('Nombre del Despacho')" />
            <x-text-input id="company_name" class="block mt-1 w-full" type="text" name="company_name" :value="old('company_name')" required autofocus />
            <x-input-error :messages="$errors->get('company_name')" class="mt-2" />
        </div>

        <!-- RFC -->
        <div class="mt-4">
            <x-input-label for="tax_id" :value="__('RFC del Despacho')" />
            <x-text-input id="tax_id" class="block mt-1 w-full uppercase" type="text" name="tax_id" :value="old('tax_id')" required placeholder="XAXX010101000" />
            <x-input-error :messages="$errors->get('tax_id')" class="mt-2" />
        </div>

        <!-- Plan Selection -->
        <div class="mt-4">
            <x-input-label for="plan_id" :value="__('Plan')" />
            <select id="plan_id" name="plan_id" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                @foreach($plans as $plan)
                    <option value="{{ $plan->id }}" {{ old('plan_id') == $plan->id ? 'selected' : '' }}>
                        {{ $plan->name }} - ${{ number_format($plan->price_monthly / 100, 2) }}/mes ({{ $plan->max_users }} usuarios)
                    </option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('plan_id')" class="mt-2" />
        </div>

        <hr class="my-6 border-gray-300 dark:border-gray-700">

        <!-- Section: Datos del Usuario (Owner) -->
        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Datos del Administrador</h3>

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Nombre Completo')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Correo Electrónico')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Contraseña')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirmar Contraseña')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-hidden focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('login') }}">
                {{ __('¿Ya tienes cuenta?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Registrar Despacho') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
