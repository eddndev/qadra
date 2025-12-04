<?php

namespace App\Models;

use App\Models\Traits\TenantScoped;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Hearing extends Model
{
    use HasFactory, HasUlids, SoftDeletes, TenantScoped;

    protected $fillable = [
        'tenant_id',
        'case_id',
        'type',
        'scheduled_at',
        'duration_minutes',
        'courtroom',
        'virtual_link',
        'judge_participant_id',
        'status',
        'result_summary',
        'next_hearing_date',
        'attended_by',
    ];

    protected $casts = [
        'scheduled_at' => 'datetime',
        'next_hearing_date' => 'datetime',
        'attended_by' => 'array',
    ];

    public function case()
    {
        return $this->belongsTo(LegalCase::class, 'case_id');
    }

    public function judge()
    {
        return $this->belongsTo(Participant::class, 'judge_participant_id');
    }

    public function deadlines()
    {
        return $this->hasMany(Deadline::class);
    }
}