<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-2 bg-[#1E40AF] dark:bg-[#1E40AF] border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-[#111344] dark:hover:bg-[#111344] focus:bg-[#111344] active:bg-[#111344] focus:outline-none focus:ring-2 focus:ring-[#1E40AF] focus:ring-offset-2 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
