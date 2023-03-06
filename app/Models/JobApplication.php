<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobApplication extends Model
{
    use HasFactory;

    public const GENDER = [
        'Male',
        'Female',
        'Others',
    ];

    /**
     * Get the job posting that owns the job application.
     */
    public function jobPosting()
    {
        return $this->belongsTo(JobPosting::class);
    }
}
