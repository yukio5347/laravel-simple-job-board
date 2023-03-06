<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\JobPosting;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\JobPosting>
 */
class JobPostingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'title' => fake()->jobTitle,
            'description' => fake()->realText . "\n\n" . fake()->realText,
            'published_at' => fake()->date,
            'closed_at' => fake()->date,
            'employment_type' => fake()->randomElement(JobPosting::EMPLOYMENT_TYPE),
            'address' => fake()->streetAddress,
            'locality' => fake()->city,
            'region' => fake()->state,
            'postal_code' => fake()->postcode,
            'is_remote' => false,
            'salary_min' => fake()->numberBetween(3000, 6000),
            'salary_max' => fake()->numberBetween(7000, 10000),
            'salary_unit' => fake()->randomElement(JobPosting::SALARY_UNIT),
            'company_name' => fake()->company,
            'company_description' => fake()->realText . "\n\n" . fake()->realText,
            'name' => fake()->name,
            'email' => fake()->unique()->safeEmail,
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'ip_address' => fake()->ipv6,
            'user_agent' => fake()->userAgent,
        ];
    }
}
