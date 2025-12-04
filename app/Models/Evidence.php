<?php

namespace App\Models;

use App\Models\Traits\HasTenants;
use App\Models\Traits\TenantScoped;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Evidence extends Model
{
    use HasFactory, HasUlids, HasTenants, TenantScoped, SoftDeletes;

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
        return match($this->status) {
            'en_custodia' => 'En Custodia',
            'en_fiscalia' => 'En Fiscalía',
            'en_juzgado' => 'En Juzgado',
            'destruido' => 'Destruido',
            'devuelto' => 'Devuelto',
            default => $this->status,
        };
    }
}