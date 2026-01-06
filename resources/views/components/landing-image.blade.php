@props(['key', 'class' => '', 'alt' => ''])

@php
    $asset = \App\Models\LandingPageAsset::where('asset_key', $key)->first();
    $media = $asset ? $asset->getFirstMedia('default') : null;
@endphp

@if ($media)
    <picture class="{{ $class }}">
        <source srcset="{{ $media->getTemporaryUrl(now()->addMinutes(60), 'avif') }}" type="image/avif">
        <source srcset="{{ $media->getTemporaryUrl(now()->addMinutes(60), 'webp') }}" type="image/webp">
        <img src="{{ $media->getTemporaryUrl(now()->addMinutes(60)) }}" alt="{{ $alt ?: $asset->description }}"
            class="{{ $class }} object-cover w-full h-full" loading="lazy">
    </picture>
@else
    <!-- Fallback if asset key not found or no media attached -->
    <div class="{{ $class }} bg-neutral-200 flex items-center justify-center text-neutral-400">
        <span class="text-xs">Image: {{ $key }}</span>
    </div>
@endif