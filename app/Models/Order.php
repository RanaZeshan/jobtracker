<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'job_role',
        'applications_requested',
        'resume_file',
        'notes',
        'status',
        'date_submitted',
    ];

    protected $casts = [
        'applications_requested' => 'integer',
        'date_submitted'         => 'datetime',
    ];
}
