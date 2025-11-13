<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use App\Models\Client;
use App\Models\User;

class Application extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'team_id',
        'job_title',
        'company_applied_to',
        'job_link',
        'source_site',
        'location',
        'status',
        'applied_on',
        'earning',
        'tailored_resume',
        'resume_file',
        'sheet_row_key', 
    ];

    protected $casts = [
        'applied_on'      => 'datetime',
        'tailored_resume' => 'boolean',
        'earning'         => 'float',
    ];

    /**
     * Boot method to register model events
     */
    protected static function boot()
    {
        parent::boot();

        // Automatically delete resume file when application is deleted
        static::deleting(function ($application) {
            if ($application->resume_file && Storage::disk('public')->exists($application->resume_file)) {
                Storage::disk('public')->delete($application->resume_file);
            }
        });
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    // Existing relation (if used elsewhere)
    public function team()
    {
        return $this->belongsTo(User::class, 'team_id');
    }

    // New relation used by admin applications page
    public function teamMember()
    {
        return $this->belongsTo(User::class, 'team_id');
    }
}
