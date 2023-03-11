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
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'telephone',
        'address',
        'birthday',
        'gender',
        'description',
        'education',
        'work_history',
        'certificates',
        'ip_address',
        'user_agent',
    ];

    /**
     * Get the job posting that owns the job application.
     */
    public function jobPosting()
    {
        return $this->belongsTo(JobPosting::class);
    }
}
