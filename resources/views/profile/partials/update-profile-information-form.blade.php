<section>
    <!-- Header with Avatar and Basic Info -->
    <div class="flex items-start gap-6 mb-8 pb-8 border-b border-gray-100"
        x-data="{ avatar: null, avatarPreview: null }">
        <div class="relative group cursor-pointer" @click="document.getElementById('avatar-input').click()">
            <!-- Current Avatar / Initials -->
            <div
                class="h-24 w-24 rounded-full bg-gray-200 flex items-center justify-center text-3xl font-bold text-gray-500 overflow-hidden relative">
                <!-- If user has avatar, show it -->
                @if($user->hasMedia('avatar'))
                    <img src="{{ $user->getAvatarUrl() }}" alt="{{ $user->name }}" class="h-full w-full object-cover"
                        x-show="!avatarPreview">
                @else
                    <span x-show="!avatarPreview">{{ substr($user->name, 0, 2) }}</span>
                @endif

                <!-- New Upload Preview -->
                <template x-if="avatarPreview">
                    <img :src="avatarPreview" class="h-full w-full object-cover">
                </template>

                <!-- Overlay on Hover -->
                <div
                    class="absolute inset-0 bg-black/0 group-hover:bg-black/40 flex items-center justify-center transition-all duration-200">
                    <svg class="w-8 h-8 text-white opacity-0 group-hover:opacity-100" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </div>
            </div>


            <button type="button"
                class="absolute bottom-0 right-0 bg-[#1E293B] text-white p-2 rounded-full hover:bg-gray-700 transition-colors z-10">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                </svg>
            </button>
        </div>

        <div>
            <h3 class="text-xl font-bold text-[#111344]">{{ $user->name }}</h3>
            <p class="text-blue-600 font-medium">{{ $user->email }}</p>
            <div class="mt-1 text-sm text-gray-500">
                Fiscal Superior • ID: {{ $user->professional_license ?? 'FS-2024-1847' }}
            </div>
        </div>
    </div>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="space-y-6" enctype="multipart/form-data">
        <!-- Hidden Avatar Input -->
        <input type="file" id="avatar-input" name="avatar" class="hidden" accept="image/png, image/jpeg, image/webp"
            @change="
                const file = $event.target.files[0]; 
                const reader = new FileReader(); 
                reader.onload = (e) => { avatarPreview = e.target.result }; 
                reader.readAsDataURL(file);
            ">
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
                <x-text-input id="email" name="email" type="email"
                    class="mt-1 block w-full bg-slate-100 cursor-not-allowed" :value="old('email', $user->email)"
                    required readonly autocomplete="username" />
                <x-input-error class="mt-2" :messages="$errors->get('email')" />

                @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
                    <div class="mt-2">
                        <p class="text-sm text-gray-800">
                            {{ __('Your email address is unverified.') }}

                            <button form="send-verification"
                                class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-hidden focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                {{ __('Click here to re-send the verification email.') }}
                            </button>
                        </p>

                        @if (session('status') === 'verification-link-sent')
                            <p class="mt-2 font-medium text-sm text-green-600">
                                {{ __('A new verification link has been sent to your email address.') }}
                            </p>
                        @endif
                    </div>
                @endif
            </div>

            <!-- Cargo (Visual for now / placeholder) -->
            <div>
                <x-input-label for="position" :value="__('Cargo')" />
                <x-text-input id="position" name="position" type="text" class="mt-1 block w-full"
                    :value="old('position', $user->position)" />
                <x-input-error class="mt-2" :messages="$errors->get('position')" />
            </div>

            <!-- Phone -->
            <div>
                <x-input-label for="phone" :value="__('Teléfono')" />
                <x-text-input id="phone" name="phone" type="text" class="mt-1 block w-full" :value="old('phone', $user->phone ?? '+56 9 8765 4321')" />
                <x-input-error class="mt-2" :messages="$errors->get('phone')" />
            </div>
        </div>



        <div class="flex items-center justify-end gap-4 pt-4 border-t border-gray-100">
            <button type="button" class="text-sm font-medium text-gray-500 hover:text-gray-700">Cancelar</button>

            <x-primary-button class="bg-[#334D6E] hover:bg-[#243b55]">
                {{ __('Guardar cambios') }}
            </x-primary-button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600">{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>