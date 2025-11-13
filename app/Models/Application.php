<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
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
