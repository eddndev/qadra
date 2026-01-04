<?php

namespace App\Models;


use App\Models\Traits\TenantScoped;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Activity extends Model implements HasMedia
{
    use HasFactory, HasUlids, TenantScoped, SoftDeletes, InteractsWithMedia;

    protected $fillable = [
        'tenant_id',
        'case_id',
        'performed_by',
        'type',
        'title',
        'description',
        'performed_at',
        'duration_minutes',
    ];

    protected $casts = [
        'performed_at' => 'datetime',
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('attachments')
            ->useDisk('s3');
    }

    // Relationships

    public function legalCase()
    {
        return $this->belongsTo(LegalCase::class, 'case_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'performed_by');
    }

    // Helper for icons based on type
    public function getIconAttribute()
    {
        return match ($this->type) {
            'Llamada Telefónica' => 'phone',
            'Email' => 'envelope',
            'Reunión' => 'users',
            'Visita a Juzgado' => 'building-columns',
            'Presentación de Escrito' => 'file-signature',
            'Diligencia' => 'briefcase',
            'Visita Carcelaria' => 'lock',
            default => 'check-circle',
        };
    }
}