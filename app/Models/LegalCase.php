<?php

namespace App\Models;

use App\Models\Traits\HasTenants;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class LegalCase extends Model implements HasMedia
{
    use HasFactory, HasUlids, HasTenants, SoftDeletes, InteractsWithMedia;

    protected $table = 'legal_cases';

    protected $fillable = [
        'tenant_id',
        'internal_folio',
        'nuc',
        'judicial_file_number',
        'case_alias',
        'crime_type',
        'crime_classification',
        'crime_severity',
        'stage',
        'status',
        'start_date',
        'close_date',
        'lead_lawyer_id',
        'assigned_to_id',
        'court_name',
        'prosecutor_name',
        'judge_name',
        'initial_hearing_date',
        'arraignment_date',
        'trial_date',
        'notes',
    ];

    protected $casts = [
        'start_date' => 'date',
        'close_date' => 'date',
        'initial_hearing_date' => 'datetime',
        'arraignment_date' => 'datetime',
        'trial_date' => 'datetime',
    ];

    // Media Library Collections
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('documents')
             ->useDisk('s3'); // Enforce S3 for documents
    }

    // Relationships

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    public function leadLawyer()
    {
        return $this->belongsTo(User::class, 'lead_lawyer_id');
    }

    public function assignedLawyer()
    {
        return $this->belongsTo(User::class, 'assigned_to_id');
    }

    public function stageHistory()
    {
        return $this->hasMany(ProceduralStageHistory::class, 'case_id')->orderByDesc('created_at');
    }

    public function participants()
    {
        return $this->belongsToMany(Participant::class, 'case_participants', 'case_id', 'participant_id')
            ->withPivot(['role', 'alias', 'is_detained', 'defense_attorney_name', 'notes'])
            ->withTimestamps();
    }

    public function hearings()
    {
        return $this->hasMany(Hearing::class, 'case_id');
    }

    public function deadlines()
    {
        return $this->hasMany(Deadline::class, 'case_id');
    }
    
    public function evidence()
    {
        return $this->hasMany(Evidence::class, 'case_id');
    }
}
