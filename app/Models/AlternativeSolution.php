<?php

namespace App\Models;


use App\Models\Traits\TenantScoped;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AlternativeSolution extends Model
{
    use HasFactory, HasUlids, TenantScoped, SoftDeletes;

    protected $fillable = [
        'tenant_id',
        'case_id',
        'type',
        'proposal_date',
        'approved_at',
        'judge_name',
        'conditions',
        'compliance_deadline',
        'status',
        'revoked_reason',
        'revoked_at',
        'completed_at',
    ];

    protected $casts = [
        'proposal_date' => 'date',
        'approved_at' => 'date',
        'compliance_deadline' => 'date',
        'revoked_at' => 'date',
        'completed_at' => 'date',
    ];

    // Relationships

    public function legalCase()
    {
        return $this->belongsTo(LegalCase::class, 'case_id');
    }

    // Helpers
    public function getStatusLabelAttribute()
    {
        return match ($this->status) {
            'propuesta' => 'Propuesta',
            'aprobada' => 'Aprobada / En Curso',
            'cumplida' => 'Cumplida Totalmente',
            'revocada' => 'Revocada',
            default => ucfirst($this->status),
        };
    }
}