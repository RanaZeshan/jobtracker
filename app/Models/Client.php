<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'company',
        'email',
        'notes',
        'google_sheet_id',
        'application_status',
        'target_applications',
        'deleted',
        'deleted_at',
    ];

    protected $casts = [
        'deleted' => 'boolean',
        'deleted_at' => 'datetime',
    ];

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function applications()
    {
        return $this->hasMany(Application::class);
    }
}
