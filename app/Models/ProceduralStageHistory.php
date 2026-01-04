<?php

namespace App\Models;

use App\Models\Traits\TenantScoped;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProceduralStageHistory extends Model
{
    use HasFactory, HasUlids, TenantScoped;

    // No updated_at for immutable history
    const UPDATED_AT = null;

    protected $fillable = [
        'tenant_id',
        'case_id',
        'previous_stage',
        'new_stage',
        'previous_status',
        'new_status',
        'reason',
        'changed_by',
    ];

    public function case()
    {
        return $this->belongsTo(LegalCase::class, 'case_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'changed_by');
    }
}