@props(['caseNumber', 'title', 'location', 'date', 'status', 'statusColor' => 'blue'])

@php
    $borderClass = match($statusColor) {
        'red' => 'border-l-4 border-l-[#A52A2A]',
        'green' => 'border-l-4 border-l-[#2F855A]',
        'blue' => 'border-l-4 border-l-[#1E40AF]',
        'yellow', 'amber' => 'border-l-4 border-l-[#D97706]', // Assuming amber/orange for intermediate
        default => 'border-l-4 border-l-[#1E40AF]',
    };

    $badgeClass = match($statusColor) {
        'red' => 'bg-red-50 text-[#A52A2A]',
        'green' => 'bg-green-50 text-[#2F855A]',
        'blue' => 'bg-blue-50 text-[#1E40AF]',
        'yellow', 'amber' => 'bg-amber-50 text-[#D97706]',
        default => 'bg-blue-50 text-[#1E40AF]',
    };
@endphp

<div {{ $attributes->merge(['class' => 'bg-white rounded-lg shadow-sm hover:shadow-md transition-shadow duration-200 border border-t-0 border-b-0 border-r-0 border-gray-200 ' . $borderClass]) }}>
    <div class="p-5 border border-gray-200 rounded-r-lg border-l-0 h-full flex flex-col justify-between">
        <div>
            <div class="text-xs text-gray-400 font-medium mb-1">{{ $caseNumber }}</div>
            <h4 class="text-base font-bold text-[#111344] mb-2 leading-tight line-clamp-2">
                {{ $title }}
            </h4>
            
            <div class="flex items-center text-xs text-gray-500 mb-1">
                <svg class="h-3.5 w-3.5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                </svg>
                <span class="truncate">{{ $location }}</span>
            </div>
            
            <div class="flex items-center text-xs text-gray-500">
                <svg class="h-3.5 w-3.5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                {{ $date }}
            </div>
        </div>

        <div class="mt-4">
            <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-xs font-medium {{ $badgeClass }}">
                {{ $status }}
            </span>
        </div>
    </div>
</div>
