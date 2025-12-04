<?php

namespace App\Models;

use App\Models\Traits\TenantScoped;
use Spatie\MediaLibrary\MediaCollections\Models\Media as SpatieMedia;

class Media extends SpatieMedia
{
    use TenantScoped;
    
    // Spatie Media table uses 'id' (bigint) as PK, which is fine.
    // TenantScoped handles the 'tenant_id' logic.
}