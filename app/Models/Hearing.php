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

    /**
     * Get the status configuration including colors and labels.
     */
    public function getStatusConfigAttribute(): array
    {
        return match ($this->status) {
            'programada' => [
                'label' => 'Programada',
                'color' => '#4F46E5', // Indigo
                'bg_class' => 'bg-blue-100',
                'text_class' => 'text-blue-800',
                'icon_color' => 'text-blue-400',
            ],
            'celebrada' => [
                'label' => 'Celebrada',
                'color' => '#10B981', // Green
                'bg_class' => 'bg-green-100',
                'text_class' => 'text-green-800',
                'icon_color' => 'text-green-400',
            ],
            'cancelada' => [
                'label' => 'Cancelada',
                'color' => '#EF4444', // Red
                'bg_class' => 'bg-red-100',
                'text_class' => 'text-red-800',
                'icon_color' => 'text-red-400',
            ],
            'reprogramada' => [
                'label' => 'Reprogramada',
                'color' => '#F59E0B', // Yellow
                'bg_class' => 'bg-yellow-100',
                'text_class' => 'text-yellow-800',
                'icon_color' => 'text-yellow-400',
            ],
            default => [
                'label' => ucfirst($this->status),
                'color' => '#6B7280', // Gray
                'bg_class' => 'bg-gray-100',
                'text_class' => 'text-gray-800',
                'icon_color' => 'text-gray-400',
            ],
        };
    }

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