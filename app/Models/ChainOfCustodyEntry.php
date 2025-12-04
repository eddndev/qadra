<?php

namespace App\Models;

use App\Models\Traits\HasTenants;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChainOfCustodyEntry extends Model
{
    use HasFactory, HasUlids, HasTenants;

    // No timestamps handling by Eloquent as we only have created_at
    public $timestamps = false;

    protected $fillable = [
        'tenant_id',
        'evidence_id',
        'movement_at',
        'given_by',
        'given_by_badge',
        'received_by',
        'received_by_badge',
        'reason',
        'location',
        'condition',
        'registered_by',
    ];

    protected $casts = [
        'movement_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($model) {
            $model->created_at = $model->created_at ?? now();
        });
    }

    // Relationships

    public function evidence()
    {
        return $this->belongsTo(Evidence::class);
    }

    public function registeredBy()
    {
        return $this->belongsTo(User::class, 'registered_by');
    }
}
