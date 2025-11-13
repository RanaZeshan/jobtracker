<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'assigned_to_id',
        'description',
        'target_applications',
        'application_limit',
        'completed_applications',
        'is_active',
        'is_paused',
        'status',
        'date_created',
        'date_completed',
    ];

    protected $casts = [
        'is_active'      => 'boolean',
        'is_paused'      => 'boolean',
        'date_created'   => 'datetime',
        'date_completed' => 'datetime',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function assignee()
    {
        return $this->belongsTo(User::class, 'assigned_to_id');
    }
}
