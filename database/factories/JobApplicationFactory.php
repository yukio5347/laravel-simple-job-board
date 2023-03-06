<?php

namespace Database\Factories;

use App\Models\JobApplication;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\JobApplication>
 */
class JobApplicationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => fake()->name,
            'email' => fake()->unique()->safeEmail,
            'telephone' => fake()->phoneNumber,
            'address' => fake()->address,
            'birthday' => fake()->date,
            'gender' => fake()->randomElement(JobApplication::GENDER),
            'description' => "This is the description. " . fake()->realText . "\n\n" . fake()->realText,
            'education' => "This is the education. " . fake()->realText . "\n\n" . fake()->realText,
            'work_history' => "This is the work histories. " . fake()->realText . "\n\n" . fake()->realText,
            'certificates' => "This is the certificates. " . fake()->realText . "\n\n" . fake()->realText,
            'ip_address' => fake()->ipv6,
            'user_agent' => fake()->userAgent,
        ];
    }
}
