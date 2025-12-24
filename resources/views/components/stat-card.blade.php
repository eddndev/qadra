@props(['title', 'count', 'icon' => null, 'iconColor' => 'text-blue-500', 'bgIcon' => 'bg-blue-50', 'borderColor' => null])

<div class="bg-white overflow-hidden rounded-xl shadow-sm border {{ $borderColor ? 'border-' . $borderColor : 'border-gray-200' }} p-5 flex items-start justify-between">
    <div>
        <p class="text-sm font-medium text-gray-500 mb-1 truncate">{{ $title }}</p>
        <h3 class="text-2xl font-bold text-gray-900">{{ $count }}</h3>
    </div>
    @if($icon)
        <div class="p-3 rounded-lg {{ $bgIcon }}">
            {{ $icon }}
        </div>
    @endif
</div>
