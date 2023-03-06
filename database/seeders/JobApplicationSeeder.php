<?php

namespace Database\Seeders;

use App\Models\JobApplication;
use App\Models\JobPosting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JobApplicationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $jobPosting = JobPosting::first();
        JobApplication::factory()
                        ->count(3)
                        ->for($jobPosting)
                        ->create();
    }
}
