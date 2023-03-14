<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Js;

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
        'created_at',
        'employment_type_text',
        'employment_type_color',
        'salary_unit_text',
        'short_work_place',
        'work_place',
        'short_salary',
        'salary',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'employment_type_text',
        'employment_type_color',
        'salary_unit_text',
        'short_work_place',
        'work_place',
        'short_salary',
        'salary',
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
     * Get the employment_type tag color
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function employmentTypeColor(): Attribute
    {
        switch ($this->employment_type) {
            case 'FULL_TIME':
                $color = 'text-sky-600 bg-sky-100';
                break;

            case 'PART_TIME':
                $color = 'text-orange-600 bg-orange-100';
                break;

            case 'CONTRACTOR':
                $color = 'text-violet-600 bg-violet-100';
                break;

            case 'TEMPORARY':
                $color = 'text-red-600 bg-red-100';
                break;

            case 'INTERN':
                $color = 'text-green-600 bg-green-100';
                break;

            default:
                $color = 'text-gray-700 bg-gray-200';
                break;
        }

        return Attribute::make(
            get: fn ($value) => $color,
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
     * Get the short work place
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function shortWorkPlace(): Attribute
    {
        $address = [];
        if ($this->locality) {
            $address[] = $this->locality;
        }
        if ($this->region && $this->region !== $this->locality) {
            $address[] = $this->region;
        }
        $workPlace = implode(', ', $address);

        if ($this->is_remote) {
            $workPlace = $workPlace ? __('Remote') . " / {$workPlace}" : __('Remote');
        }

        return Attribute::make(
            get: fn ($value) => $workPlace,
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
            $workPlace = $workPlace ? __('Remote') . " / {$workPlace}" : __('Remote');
        }

        return Attribute::make(
            get: fn ($value) => $workPlace,
        );
    }

    /**
     * Get the short salary
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function shortSalary(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => config('app.currency') . ' ' . number_format($this->salary_min) . ' / ' . $this->salary_unit_text,
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
