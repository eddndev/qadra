@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-lg shadow-sm py-2.5']) }}>