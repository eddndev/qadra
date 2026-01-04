<?php

namespace App\Models;


use App\Models\Traits\TenantScoped;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PrecautionaryMeasure extends Model
{
    use HasFactory, HasUlids, TenantScoped, SoftDeletes;

    protected $fillable = [
        'tenant_id',
        'case_id',
        'participant_id',
        'measure_type_id',
        'description',
        'imposed_at',
        'judge_name',
        'review_date',
        'expires_at',
        'status',
        'revoked_reason',
        'revoked_at',
    ];

    protected $casts = [
        'imposed_at' => 'date',
        'review_date' => 'date',
        'expires_at' => 'date',
        'revoked_at' => 'date',
    ];

    // Relationships

    public function legalCase()
    {
        return $this->belongsTo(LegalCase::class, 'case_id');
    }

    public function participant()
    {
        return $this->belongsTo(Participant::class, 'participant_id');
    }

    public function measureType()
    {
        return $this->belongsTo(PrecautionaryMeasureType::class, 'measure_type_id');
    }

    // Helper to determine alert level based on review_date
    public function getReviewAlertLevelAttribute()
    {
        if (!$this->review_date || $this->status !== 'vigente') {
            return 'none';
        }

        $days = now()->diffInDays($this->review_date, false);

        if ($days < 0)
            return 'expired'; // Vencida
        if ($days <= 30)
            return 'critical'; // Urgente (preparar audiencia)
        if ($days <= 60)
            return 'warning'; // Atención

        return 'ok';
    }
}