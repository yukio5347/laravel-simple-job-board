<?php

namespace Tests\Feature;

use App\Mail\JobApplicationReceived;
use App\Mail\JobApplicationSent;
use App\Models\JobApplication;
use App\Models\JobPosting;
use Illuminate\Support\Facades\Mail;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class JobApplicationTest extends TestCase
{
    public function test_apply_page_can_be_rendered(): void
    {
        $jobPosting = JobPosting::factory()->create([
            'closed_at' => today()->addDay(),
        ]);
        $response = $this->get(route('jobs.apply', $jobPosting))
                        ->assertInertia(fn (Assert $page) => $page
                            ->component('Jobs/Apply')
                            ->has('jobPosting', fn (Assert $page) => $page
                                ->has('id')
                                ->has('title')
                                ->missing('name')
                                ->missing('email')
                                ->missing('password')
                                ->missing('ip_address')
                                ->missing('user_agent')
                                ->etc()
                            )
                        );
        $response->assertStatus(200);
    }

    public function test_new_job_applications_can_be_sent(): void
    {
        Mail::fake();
        $jobPosting = JobPosting::factory()->create([
            'closed_at' => today()->addDay(),
        ]);
        $params = JobApplication::factory()->make()->toArray();
        $response = $this->post(route('jobs.apply', $jobPosting), $params);
        $response->assertSessionHas('message', __('You have applied for ":title".', ['title' => $jobPosting->title]));
        $response->assertRedirect(route('jobs.index'));
        $this->assertDatabaseHas('job_applications', $params);
        Mail::assertQueued(JobApplicationSent::class, function ($mail) use ($params) {
            return $mail->hasTo($params['email']);
        });
        Mail::assertQueued(JobApplicationReceived::class, function ($mail) use ($jobPosting) {
            return $mail->hasTo($jobPosting->email) &&
                   $mail->hasBcc(config('mail.admin'));
        });
    }
/*
|--------------------------------------------------------------------------
| Tests for expired jobs
|--------------------------------------------------------------------------
*/
    public function test_apply_page_returns_404_for_expired_jobs(): void
    {
        $jobPosting = JobPosting::factory()->create([
            'closed_at' => today()->subDay(),
        ]);
        $response = $this->get(route('jobs.show', $jobPosting));
        $response->assertStatus(404);
    }

    public function test_job_application_cannot_be_sent_for_expired_jobs(): void
    {
        Mail::fake();
        $jobPosting = JobPosting::factory()->create([
            'closed_at' => today()->subDay(),
        ]);
        $params = JobApplication::factory()->make()->toArray();
        $response = $this->post(route('jobs.apply', $jobPosting), $params);
        $response->assertSessionMissing('message');
        $response->assertStatus(404);
        $this->assertDatabaseMissing('job_applications', $params);
        Mail::assertNotQueued(JobApplicationSent::class, function ($mail) use ($params) {
            return $mail->hasTo($params['email']);
        });
        Mail::assertNotQueued(JobApplicationReceived::class, function ($mail) use ($jobPosting) {
            return $mail->hasTo($jobPosting->email) &&
                   $mail->hasBcc(config('mail.admin'));
        });
    }
/*
|--------------------------------------------------------------------------
| Others
|--------------------------------------------------------------------------
*/
    public function test_job_application_cannot_be_sent_for_the_second_time(): void
    {
        Mail::fake();
        $jobPosting = JobPosting::factory()->create(['closed_at' => today()->addDay()]);
        $jobApplication = JobApplication::factory()->create(['job_posting_id' => $jobPosting->id]);
        $response = $this->post(route('jobs.apply', $jobPosting), $jobApplication->toArray());
        $response->assertSessionHasErrors([
            'email' => __('You have already applied for this job.'),
        ]);
        Mail::assertNotQueued(JobApplicationSent::class, function ($mail) use ($jobApplication) {
            return $mail->hasTo($jobApplication->email);
        });
        Mail::assertNotQueued(JobApplicationReceived::class, function ($mail) use ($jobPosting) {
            return $mail->hasTo($jobPosting->email) &&
                   $mail->hasBcc(config('mail.admin'));
        });
    }
}
