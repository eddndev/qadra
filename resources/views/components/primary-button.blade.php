<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-3 bg-[#1E40AF] border border-transparent rounded-md font-bold text-sm text-white hover:bg-[#111344] focus:bg-[#111344] active:bg-[#111344] focus:outline-none focus:ring-2 focus:ring-[#1E40AF] focus:ring-offset-2 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>