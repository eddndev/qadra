@props(['disabled' => false])

<style>
    input::-ms-reveal,
    input::-ms-clear {
        display: none;
    }
</style>
<input @disabled($disabled) {{ $attributes->merge(['class' => 'w-full border-gray-300 text-[#111344] focus:border-[#1E40AF] focus:ring-[#1E40AF] rounded-lg shadow-sm py-2.5 px-4']) }}>