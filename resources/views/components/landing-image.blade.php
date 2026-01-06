@props(['key', 'class' => '', 'alt' => ''])

@php
    $asset = \App\Models\LandingPageAsset::where('asset_key', $key)->first();
    $media = $asset ? $asset->getFirstMedia('default') : null;
@endphp

@if ($media)
    <picture>
        @if($media->hasGeneratedConversion('avif'))
            <source srcset="{{ $media->getTemporaryUrl(now()->addMinutes(60), 'avif') }}" type="image/avif">
        @endif
        @if($media->hasGeneratedConversion('webp'))
            <source srcset="{{ $media->getTemporaryUrl(now()->addMinutes(60), 'webp') }}" type="image/webp">
        @endif
        <img src="{{ $media->getTemporaryUrl(now()->addMinutes(60)) }}" alt="{{ $alt ?: $asset->description }}"
            class="{{ $class }}" loading="lazy">
    </picture>
@else
    <!-- Fallback if asset key not found or no media attached -->
    <div class="{{ $class }} bg-neutral-200 flex items-center justify-center text-neutral-400">
        <span class="text-xs">Image: {{ $key }}</span>
    </div>
@endif