<div class="relative ml-3" x-data="{ open: false }">
    <div>
        <button @click="open = !open" type="button"
            class="flex items-center max-w-xs text-sm font-bold text-gray-700 bg-white rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
            id="user-menu-button" aria-expanded="false" aria-haspopup="true">
            <span class="sr-only">Abrir menú de despacho</span>
            <div
                class="flex items-center px-3 py-2 border border-gray-300 rounded-full bg-white hover:bg-gray-50 transition ease-in-out duration-150">
                <span class="mr-2 text-gray-700">{{ $currentTenant->name ?? 'Seleccionar Despacho' }}</span>
                <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                    fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd"
                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                        clip-rule="evenodd" />
                </svg>
            </div>
        </button>
    </div>

    <!-- Dropdown menu -->
    <div x-show="open" @click.away="open = false"
        class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none"
        role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1" style="display: none;">
        <div class="px-4 py-2 text-xs text-gray-500 border-b border-gray-200">
            Mis Despachos
        </div>

        @foreach($tenants as $tenant)
            <button wire:click="switchTenant('{{ $tenant->id }}')"
                class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 {{ $currentTenant && $currentTenant->id === $tenant->id ? 'bg-indigo-50 font-bold' : '' }}"
                role="menuitem">
                {{ $tenant->name }}
            </button>
        @endforeach

        <div class="border-t border-gray-200 mt-1 pt-1">
            <a href="{{ route('tenant.create') }}"
                class="block px-4 py-2 text-sm text-indigo-600 hover:text-indigo-900 hover:bg-gray-100">
                + Crear Nuevo Despacho
            </a>
        </div>
    </div>
</div>