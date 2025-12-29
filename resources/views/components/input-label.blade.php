@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-bold text-sm text-black']) }}>
    {{ $value ?? $slot }}
</label>