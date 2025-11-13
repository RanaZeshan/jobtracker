<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientIntake extends Model
{
    use HasFactory;

    protected $table = 'client_intakes';

    protected $fillable = [
        'full_name',
        'email',
        'phone',
        'employment_status',
        'job_titles',
        'experience_level',
        'education',
        'skills',
        'job_type',
        'locations',
        'salary',
        'availability',
        'visa_status',
        'linkedin',
        'career_goals',
        'country',
        'languages',
        'references',
        'notes',
        'resume_file',
        'cover_letter_file',
    ];

    protected $casts = [
        'skills'    => 'array',
        'job_type'  => 'array',
        'languages' => 'array',
        'created_at'=> 'datetime',
        'updated_at'=> 'datetime',
    ];
}
