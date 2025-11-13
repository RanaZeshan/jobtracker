<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable; // <-- important
use Illuminate\Notifications\Notifiable;


class User extends Authenticatable
{
   use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'profile_picture',
    ];

    /**
     * The attributes that should be hidden for arrays / JSON.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // -----------------------------
    // Relationships
    // -----------------------------

    // Tasks assigned to this user (team member)
    public function tasks()
    {
        return $this->hasMany(Task::class, 'assigned_to_id');
    }

    // Applications submitted by this user (team member)
    public function applications()
    {
        return $this->hasMany(Application::class, 'team_id');
    }

    // -----------------------------
    // Helper methods
    // -----------------------------

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }
}
