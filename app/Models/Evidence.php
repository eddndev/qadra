<?php

namespace App\Models;


use App\Models\Traits\TenantScoped;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Evidence extends Model implements HasMedia
{
    use HasFactory, HasUlids, TenantScoped, SoftDeletes, InteractsWithMedia;

    protected $table = 'evidence';

    protected $fillable = [
        'tenant_id',
        'case_id',
        'chain_of_custody_folio',
        'description',
        'type',
        'current_location',
        'status',
        'collected_at',
        'collected_by',
        'notes',
    ];

    protected $casts = [
        'collected_at' => 'datetime',
    ];

    // Media Library Configuration
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('evidence_photos')
            ->useDisk(config('filesystems.default', 'public')); // Use default disk (likely s3 in prod, public in local)
            // Or force S3 if required: ->useDisk('s3');
    }

    // Relationships

    public function legalCase()
    {
        return $this->belongsTo(LegalCase::class, 'case_id');
    }

    public function chainOfCustodyEntries()
    {
        return $this->hasMany(ChainOfCustodyEntry::class, 'evidence_id')->orderByDesc('movement_at');
    }

    // Helper to get current status label
    public function getStatusLabelAttribute()
    {
        return match ($this->status) {
            'en_custodia' => 'En Custodia',
            'en_fiscalia' => 'En Fiscalía',
            'en_juzgado' => 'En Juzgado',
            'destruido' => 'Destruido',
            'devuelto' => 'Devuelto',
            default => $this->status,
        };
    }
}