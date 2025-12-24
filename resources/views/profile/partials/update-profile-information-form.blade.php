<section>
    <!-- Header with Avatar and Basic Info -->
    <div class="flex items-start gap-6 mb-8 pb-8 border-b border-gray-100 dark:border-gray-700">
        <div class="relative">
            <div class="h-24 w-24 rounded-full bg-gray-200 flex items-center justify-center text-3xl font-bold text-gray-500">
                {{ substr($user->name, 0, 2) }}
            </div>
            <button class="absolute bottom-0 right-0 bg-[#1E293B] text-white p-2 rounded-full hover:bg-gray-700 transition-colors">
                 <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
            </button>
        </div>

        <div>
            <h3 class="text-xl font-bold text-[#111344] dark:text-gray-100">{{ $user->name }}</h3>
            <p class="text-blue-600 dark:text-blue-400 font-medium">{{ $user->email }}</p>
            <div class="mt-1 text-sm text-gray-500">
                Fiscal Superior • ID: {{ $user->professional_license ?? 'FS-2024-1847' }}
            </div>
        </div>
    </div>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="space-y-6">
        @csrf
        @method('patch')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Name -->
            <div>
                <x-input-label for="name" :value="__('Nombre completo')" />
                <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
                <x-input-error class="mt-2" :messages="$errors->get('name')" />
            </div>

            <!-- Email -->
            <div>
                <x-input-label for="email" :value="__('Correo electrónico')" />
                <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
                <x-input-error class="mt-2" :messages="$errors->get('email')" />

                @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                    <div class="mt-2">
                        <p class="text-sm text-gray-800 dark:text-gray-200">
                            {{ __('Your email address is unverified.') }}

                            <button form="send-verification" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-hidden focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                                {{ __('Click here to re-send the verification email.') }}
                            </button>
                        </p>

                        @if (session('status') === 'verification-link-sent')
                            <p class="mt-2 font-medium text-sm text-green-600 dark:text-green-400">
                                {{ __('A new verification link has been sent to your email address.') }}
                            </p>
                        @endif
                    </div>
                @endif
            </div>

            <!-- Cargo (Visual for now / placeholder) -->
            <div>
                <x-input-label for="cargo" :value="__('Cargo')" />
                <x-text-input id="cargo" name="cargo" type="text" class="mt-1 block w-full" value="Fiscal Superior" />
                <!-- Note: 'cargo' is not in User model fillable yet, so it won't persist without backend changes. -->
            </div>

            <!-- Phone -->
            <div>
                <x-input-label for="phone" :value="__('Teléfono')" />
                <x-text-input id="phone" name="phone" type="text" class="mt-1 block w-full" :value="old('phone', $user->phone ?? '+56 9 8765 4321')" />
                 <x-input-error class="mt-2" :messages="$errors->get('phone')" />
            </div>
        </div>

        <!-- Digital Signature -->
        <div class="mt-6">
            <x-input-label :value="__('Firma digital')" class="mb-2" />
            <div class="border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-lg p-8 text-center bg-gray-50 dark:bg-gray-900/50 hover:bg-gray-100 transition-colors cursor-pointer group">
                <div class="flex flex-col items-center justify-center text-gray-500 dark:text-gray-400">
                    <p class="mb-2 font-medium">Arrastra tu firma digital o haz clic para seleccionar</p>
                    <span class="text-blue-600 group-hover:underline">Seleccionar archivo</span>
                </div>
            </div>
        </div>

        <div class="flex items-center justify-end gap-4 pt-4 border-t border-gray-100 dark:border-gray-700">
            <button type="button" class="text-sm font-medium text-gray-500 hover:text-gray-700">Cancelar</button>
            
            <x-primary-button class="bg-[#334D6E] hover:bg-[#243b55]">
                {{ __('Guardar cambios') }}
            </x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600 dark:text-gray-400"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
