<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EarningSetting extends Model
{
    use HasFactory;

    protected $table = 'earning_settings';

    protected $fillable = [
        'base_earning',
        'tailored_bonus',
    ];
}
