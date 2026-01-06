<section>
    <!-- Unsaved Changes Banner -->
    @if($hasChanges)
        <div x-data="{ show: true }" x-show="show" x-transition
            class="mb-6 p-4 bg-amber-50 border-l-4 border-amber-400 text-amber-700 flex items-center justify-between shadow-sm">
            <div class="flex items-center">
                <svg class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
                <span class="font-medium">Tienes cambios sin guardar en tu perfil.</span>
            </div>
            <button wire:click="save"
                class="text-sm bg-amber-600 text-white px-3 py-1 rounded hover:bg-amber-700 transition-colors">
                Guardar ahora
            </button>
        </div>
    @endif

    <!-- Header with Avatar and Basic Info -->
    <div class="flex items-start gap-6 mb-8 pb-8 border-b border-gray-100">
        <div class="relative group cursor-pointer" onclick="document.getElementById('avatar-input').click()">
            <!-- Current Avatar / Initials / Preview -->
            <div
                class="h-24 w-24 rounded-full bg-gray-200 flex items-center justify-center text-3xl font-bold text-gray-500 overflow-hidden relative">
                @if($avatar)
                    <img src="{{ $avatar->temporaryUrl() }}" class="h-full w-full object-cover">
                @elseif($avatarUrl)
                    <img src="{{ $avatarUrl }}" alt="{{ $name }}" class="h-full w-full object-cover">
                @else
                    <span>{{ substr($name, 0, 2) }}</span>
                @endif

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

                <!-- Loading Spinner for Avatar -->
                <div wire:loading wire:target="avatar"
                    class="absolute inset-0 bg-white/60 flex items-center justify-center">
                    <svg class="animate-spin h-6 w-6 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                        </circle>
                        <path class="opacity-75" fill="currentColor"
                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                        </path>
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
            <h3 class="text-xl font-bold text-[#111344]">{{ $name }}</h3>
            <p class="text-blue-600 font-medium">{{ $email }}</p>
            <div class="mt-1 text-sm text-gray-500">
                Fiscal Superior • ID: {{ Auth::user()->professional_license ?? 'FS-2024-1847' }}
            </div>
        </div>
    </div>

    <form wire:submit="save" class="space-y-6">
        <!-- Hidden Avatar Input -->
        <input type="file" id="avatar-input" wire:model="avatar" class="hidden"
            accept="image/png, image/jpeg, image/webp">

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Name -->
            <div>
                <x-input-label for="name" :value="__('Nombre completo')" />
                <x-text-input id="name" wire:model.blur="name" type="text" class="mt-1 block w-full" required autofocus
                    autocomplete="name" />
                <x-input-error class="mt-2" :messages="$errors->get('name')" />
            </div>

            <!-- Email -->
            <div>
                <x-input-label for="email" :value="__('Correo electrónico')" />
                <x-text-input id="email" wire:model.blur="email" type="email"
                    class="mt-1 block w-full bg-slate-100 cursor-not-allowed" required readonly
                    autocomplete="username" />
                <x-input-error class="mt-2" :messages="$errors->get('email')" />
            </div>

            <!-- Cargo -->
            <div>
                <x-input-label for="position" :value="__('Cargo')" />
                <x-text-input id="position" wire:model.blur="position" type="text" class="mt-1 block w-full" />
                <x-input-error class="mt-2" :messages="$errors->get('position')" />
            </div>

            <!-- Phone -->
            <div>
                <x-input-label for="phone" :value="__('Teléfono')" />
                <x-text-input id="phone" wire:model.blur="phone" type="text" class="mt-1 block w-full" />
                <x-input-error class="mt-2" :messages="$errors->get('phone')" />
            </div>
        </div>

        <div class="flex items-center justify-end gap-4 pt-4 border-t border-gray-100">
            <button type="button" wire:click="mount"
                class="text-sm font-medium text-gray-500 hover:text-gray-700">Cancelar</button>

            <x-primary-button class="bg-[#334D6E] hover:bg-[#243b55]">
                <span wire:loading.remove wire:target="save">{{ __('Guardar cambios') }}</span>
                <span wire:loading wire:target="save">Guardando...</span>
            </x-primary-button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600">{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>