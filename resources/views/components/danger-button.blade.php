<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-2 bg-[#A52A2A] border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-[#7f1d1d] active:bg-[#7f1d1d] focus:outline-none focus:ring-2 focus:ring-[#A52A2A] focus:ring-offset-2 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
