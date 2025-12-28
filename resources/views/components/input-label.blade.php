@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-semibold text-sm text-[#111344] dark:text-gray-300']) }}>
    {{ $value ?? $slot }}
</label>