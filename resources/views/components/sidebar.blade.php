<div class="relative z-40 lg:hidden hidden" role="dialog" aria-modal="true" id="mobile-sidebar">
    <div class="fixed inset-0 bg-gray-900/80 backdrop-blur-sm transition-opacity opacity-100"></div>

    <div class="fixed inset-0 flex">
        <div class="relative mr-16 flex w-full max-w-xs flex-1 transform transition duration-300 ease-in-out translate-x-0">
            <div class="absolute left-full top-0 flex w-16 justify-center pt-5">
                <button type="button" 
                    onclick="document.getElementById('mobile-sidebar').classList.add('hidden')"
                    class="-m-2.5 p-2.5 text-white hover:text-gray-300">
                    <span class="sr-only">Close sidebar</span>
                    <svg class="size-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Sidebar Content for Mobile -->
             <div class="flex flex-grow flex-col overflow-y-auto bg-[#111344] pt-5 pb-4 ring-1 ring-white/10">
                <div class="flex flex-shrink-0 items-center px-4">
                    <!-- Logo -->
                    <div class="flex items-center gap-2 text-white font-bold text-xl">
                        <svg class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3" />
                        </svg>
                        <span>Qadra</span>
                    </div>
                </div>
                 <nav class="mt-8 flex-1 flex flex-col px-2 pb-4 space-y-1">
                     @include('components.sidebar-nav-output')
                </nav>
            </div>
        </div>
    </div>
</div>

<!-- Static Sidebar for Desktop -->
<div class="hidden lg:fixed lg:inset-y-0 lg:flex lg:w-64 lg:flex-col">
    <!-- Sidebar component, swap this element with another sidebar if you like -->
    <div class="flex flex-grow flex-col overflow-y-auto bg-[#111344] pt-5">
        <div class="flex flex-shrink-0 items-center px-4">
            <!-- Logo -->
            <div class="flex items-center gap-2 text-white font-bold text-xl">
                <svg class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3" />
                </svg>
                <span>Qadra</span>
            </div>
        </div>
        <nav class="mt-8 flex-1 flex flex-col px-2 pb-4 space-y-1">
            @include('components.sidebar-nav-output')
        </nav>
    </div>
</div>
