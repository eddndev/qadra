@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-[#1E40AF] dark:focus:border-[#1E40AF] focus:ring-[#1E40AF] dark:focus:ring-[#1E40AF] rounded-md shadow-sm']) }}>
