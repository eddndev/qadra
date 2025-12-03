<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class CaseParticipant extends Pivot
{
    use HasFactory;

    protected $table = 'case_participants';

    public $incrementing = true;

    protected $fillable = [
        'case_id',
        'participant_id',
        'role',
        'alias',
        'is_detained',
        'defense_attorney_name',
        'notes',
    ];

    protected $casts = [
        'is_detained' => 'boolean',
    ];
}