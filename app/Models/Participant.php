<?php

namespace App\Models;

use App\Models\Traits\TenantScoped;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Participant extends Model
{
    use HasFactory, HasUlids, TenantScoped, SoftDeletes;

    protected $fillable = [
        'tenant_id',
        'type',
        'name',
        'rfc',
        'curp',
        'gender',
        'date_of_birth',
        'contact_details',
        'notes',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'contact_details' => 'encrypted:array', // Encrypted JSON
    ];

    public function cases()
    {
        return $this->belongsToMany(LegalCase::class, 'case_participants', 'participant_id', 'case_id')
            ->withPivot(['role', 'alias', 'is_detained', 'defense_attorney_name', 'notes'])
            ->withTimestamps();
    }
}