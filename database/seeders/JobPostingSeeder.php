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
        $publishedAt = today()->subMonth();
        $closedAt = today()->subDays(5);
        JobPosting::factory()
                    ->count(50)
                    ->sequence(fn ($sequence) => ['published_at' => $publishedAt->addDays(1)])
                    ->sequence(fn ($sequence) => ['closed_at' => $closedAt->addDays(1)])
                    ->create();
    }
}
