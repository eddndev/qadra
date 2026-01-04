<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeadlineType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'default_days',
        'business_days',
        'legal_basis',
    ];
}
