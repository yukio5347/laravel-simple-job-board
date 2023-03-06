<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobPosting extends Model
{
    use HasFactory;

    public const EMPLOYMENT_TYPE = [
        'FULL_TIME',
        'PART_TIME',
        'CONTRACTOR',
        'TEMPORARY',
        'INTERN',
    ];

    public const SALARY_UNIT = [
        'HOUR',
        'DAY',
        'WEEK',
        'MONTH',
        'YEAR',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'published_at' => 'date',
        'closed_at' => 'date',
        'is_remote' => 'boolean',
    ];


    /**
     * Get the job applications for the job posting.
     */
    public function jobApplications()
    {
        return $this->hasMany(JobApplications::class);
    }

    /**
     * Get the employment_type as displaying text
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function employmentTypeText(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => __($this->employment_type),
        );
    }

    /**
     * Get the salary_unit as displaying text
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function salaryUnitText(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => __($this->salary_unit),
        );
    }
}
