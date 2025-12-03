<div class="relative ml-3" x-data="{ open: false }">
    <div>
        <button @click="open = !open" type="button" class="flex items-center max-w-xs text-sm font-bold text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" id="user-menu-button" aria-expanded="false" aria-haspopup="true">
            <span class="sr-only">Abrir menú de despacho</span>
            <div class="flex items-center px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md">
                <span class="mr-2">{{ $currentTenant->name ?? 'Seleccionar Despacho' }}</span>
                <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
            </div>
        </button>
    </div>

    <!-- Dropdown menu -->
    <div x-show="open" @click.away="open = false" class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white dark:bg-gray-700 ring-1 ring-black ring-opacity-5 focus:outline-none" role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1" style="display: none;">
        <div class="px-4 py-2 text-xs text-gray-500 dark:text-gray-400 border-b border-gray-200 dark:border-gray-600">
            Mis Despachos
        </div>
        
        @foreach($tenants as $tenant)
            <button 
                wire:click="switchTenant('{{ $tenant->id }}')" 
                class="block w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-600 {{ $currentTenant && $currentTenant->id === $tenant->id ? 'bg-indigo-50 dark:bg-indigo-900 font-bold' : '' }}" 
                role="menuitem">
                {{ $tenant->name }}
            </button>
        @endforeach

        <div class="border-t border-gray-200 dark:border-gray-600 mt-1 pt-1">
            <a href="{{ route('register') }}" class="block px-4 py-2 text-sm text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300 hover:bg-gray-100 dark:hover:bg-gray-600">
                + Crear Nuevo Despacho
            </a>
        </div>
    </div>
</div>
