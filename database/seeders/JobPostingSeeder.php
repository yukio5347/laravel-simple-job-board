<?php

namespace Database\Seeders;

use App\Models\JobPosting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JobPostingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $publishedAt = today()->subDays(50);
        $closedAt = today()->subDays(1);
        JobPosting::factory()
                    ->count(50)
                    ->sequence(fn ($sequence) => ['closed_at' => $closedAt->addDays(1)])
                    ->create();

        // today's job posting
        JobPosting::factory()
                    ->create([
                        'closed_at' => today(),
                    ]);

        // expired job posting
        JobPosting::factory()
                    ->create([
                        'closed_at' => today()->subDays(1),
                    ]);

        // soft-deleted job posting
        JobPosting::factory()
                    ->create([
                        'closed_at' => today()->addDays(3),
                    ])
                    ->delete();
    }
}
