<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JobPosting extends Model
{
    use HasFactory, SoftDeletes;

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
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'description',
        'closed_at',
        'employment_type',
        'address',
        'locality',
        'region',
        'postal_code',
        'is_remote',
        'salary_min',
        'salary_max',
        'salary_unit',
        'company_name',
        'company_description',
        'name',
        'email',
        'password',
        'ip_address',
        'user_agent',
    ];

    /**
     * The attributes that should be visible in arrays.
     *
     * @var array
     */
    protected $visible = [
        'id',
        'title',
        'description',
        'closed_at',
        'employment_type',
        'address',
        'locality',
        'region',
        'postal_code',
        'is_remote',
        'salary_min',
        'salary_max',
        'salary_unit',
        'company_name',
        'company_description',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'closed_at' => 'date',
        'is_remote' => 'boolean',
    ];


    /**
     * Get the job applications for the job posting.
     */
    public function jobApplications()
    {
        return $this->hasMany(JobApplication::class);
    }

    /**
     * Scope a query to only include active job postings.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('closed_at', '>=', today());
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

    /**
     * Get the work place
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function workPlace(): Attribute
    {
        $address = [];
        if ($this->address) {
            $address[] = $this->address;
        }
        if ($this->locality && $this->locality !== $this->address) {
            $address[] = $this->locality;
        }
        if ($this->region && $this->region !== $this->locality) {
            $address[] = $this->region;
        }
        if ($this->postcode && $this->postcode !== $this->address && $this->postcode !== $this->locality) {
            $address[] = $this->postcode;
        }
        $workPlace = implode(', ', $address);

        if ($this->is_remote) {
            $workPlace += $workPlace ? 'Remote: ' : 'Remote';
        }

        return Attribute::make(
            get: fn ($value) => $workPlace,
        );
    }

    /**
     * Get the salary
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function salary(): Attribute
    {
        $salary = config('app.currency') . ' ' . number_format($this->salary_min);
        if ($this->salary_max) {
            $salary .= ' ~ ' . number_format($this->salary_max);
        }
        $salary .= ' / ' . $this->salary_unit_text;

        return Attribute::make(
            get: fn ($value) => $salary,
        );
    }
}
