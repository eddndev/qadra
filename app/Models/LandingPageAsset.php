<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class LandingPageAsset extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = ['asset_key', 'description'];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('default')
            ->singleFile();
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('webp')
            ->format('webp')
            ->width(1920) // Max width HD
            ->optimize();

        $this->addMediaConversion('avif')
            ->format('avif')
            ->width(1920) // Max width HD
            ->optimize();

        // Thumbnail for optimization/previews if needed
        $this->addMediaConversion('thumb')
            ->width(300)
            ->height(300);
    }
}
