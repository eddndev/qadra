<?php

namespace App\Models;

use App\Models\Traits\TenantScoped;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Deadline extends Model
{
    use HasFactory, HasUlids, SoftDeletes, TenantScoped;

    protected $fillable = [
        'tenant_id',
        'case_id',
        'hearing_id',
        'title',
        'description',
        'expires_at',
        'is_fatal',
        'reminder_config',
        'status',
        'completed_at',
        'completed_by',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'completed_at' => 'datetime',
        'is_fatal' => 'boolean',
        'reminder_config' => 'array',
    ];

    public function case()
    {
        return $this->belongsTo(LegalCase::class, 'case_id');
    }

    public function hearing()
    {
        return $this->belongsTo(Hearing::class);
    }

    public function completer()
    {
        return $this->belongsTo(User::class, 'completed_by');
    }
}