<?php

namespace Tests\Feature;

use App\Models\JobPosting;
use Illuminate\Support\Facades\Hash;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class JobPostingTest extends TestCase
{
    public function test_job_listing_page_can_be_rendered(): void
    {
        JobPosting::factory()->count(2)->create([
            'closed_at' => today()->addDay(),
        ]);
        $response = $this->get(route('jobs.index'))
                        ->assertInertia(fn (Assert $page) => $page
                            ->component('Jobs/Index')
                            ->has('paginator.data', 2, fn (Assert $page) => $page
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

    public function test_job_create_page_can_be_rendered(): void
    {
        $response = $this->get(route('jobs.create'))
                        ->assertInertia(fn (Assert $page) => $page
                            ->component('Jobs/Create')
                        );
        $response->assertStatus(200);
    }

    public function test_new_jobs_can_be_stored(): void
    {
        $params = JobPosting::factory()->make([
            'title' => fake()->word,
        ])->toArray();
        $params['closed_at'] = today()->addDay()->format('Y-m-d');
        $params['name'] = fake()->name;
        $params['email'] = fake()->freeEmail;
        $password = fake()->password;
        $response = $this->post(route('jobs.store'), array_merge($params, ['password' => $password]));
        $jobPosting = JobPosting::orderByDesc('id')->first();
        $response->assertSessionHas('message', __('Your job has been successfully posted!'));
        $response->assertRedirect(route('jobs.index'));
        $this->assertTrue(Hash::check($password, $jobPosting->password));
        $this->assertDatabaseHas('job_postings', $params);
    }

    public function test_job_detail_page_can_be_rendered(): void
    {
        $jobPosting = JobPosting::factory()->create([
            'closed_at' => today()->addDay(),
        ]);
        $response = $this->get(route('jobs.show', $jobPosting));
        $response->assertStatus(200);
        $response->assertViewIs('jobs.show');
    }

    public function test_job_edit_page_can_be_rendered(): void
    {
        $jobPosting = JobPosting::factory()->create([
            'closed_at' => today()->addDay(),
        ]);
        $response = $this->get(route('jobs.edit', $jobPosting))
                        ->assertInertia(fn (Assert $page) => $page
                            ->component('Jobs/Edit')
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

    public function test_jobs_can_be_updated(): void
    {
        $password = fake()->password;
        $jobPosting = JobPosting::factory()->create([
            'closed_at' => today()->addDay(),
            'email' => fake()->freeEmail,
            'password' => Hash::make($password),
        ]);
        $params = JobPosting::factory()->make([
            'title' => fake()->word,
        ])->toArray();
        $params['closed_at'] = today()->addDay()->format('Y-m-d');
        $params['email'] = $jobPosting->email;
        $response = $this->put(route('jobs.update', $jobPosting), array_merge($params, ['password' => $password]));
        $response->assertSessionHas('message', __('Your job has been successfully updated!'));
        $response->assertRedirect(route('jobs.index'));
        $this->assertDatabaseHas('job_postings', array_merge($params, ['id' => $jobPosting->id]));
    }

    public function test_job_delete_page_can_be_rendered(): void
    {
        $jobPosting = JobPosting::factory()->create([
            'closed_at' => today()->addDay(),
        ]);
        $response = $this->get(route('jobs.destroy.confirm', $jobPosting))
                        ->assertInertia(fn (Assert $page) => $page
                            ->component('Jobs/Delete')
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

    public function test_jobs_can_be_soft_deleted(): void
    {
        $password = fake()->password;
        $jobPosting = JobPosting::factory()->create([
            'closed_at' => today()->addDay(),
            'email' => fake()->freeEmail,
            'password' => Hash::make($password),
        ]);
        $params = [
            'email' => $jobPosting->email,
            'password' => $password,
        ];
        $response = $this->delete(route('jobs.destroy', $jobPosting), $params);
        $response->assertSessionHas('message', __('Your job has been deleted.'));
        $response->assertRedirect(route('jobs.index'));
        $this->assertSoftDeleted($jobPosting);
    }
/*
|--------------------------------------------------------------------------
| Tests for expired jobs
|--------------------------------------------------------------------------
*/
    public function test_expired_jobs_are_not_displayed_in_job_listing_page(): void
    {
        $jobPostings = JobPosting::factory()->count(2)->create([
            'closed_at' => today()->addDay(),
        ]);
        $jobPostings->first()->fill(['closed_at' => today()->subDay()])->save();
        $response = $this->get(route('jobs.index'))
                        ->assertInertia(fn (Assert $page) => $page
                            ->component('Jobs/Index')
                            ->has('paginator.data', 1, fn (Assert $page) => $page
                                ->where('id', $jobPostings->last()->id)
                                ->where('title', $jobPostings->last()->title)
                                ->etc()
                            )
                        );
    }

    public function test_job_detail_page_returns_404_for_expired_jobs(): void
    {
        $jobPosting = JobPosting::factory()->create([
            'closed_at' => today()->subDay(),
        ]);
        $response = $this->get(route('jobs.show', $jobPosting));
        $response->assertStatus(404);
    }

    public function test_job_edit_page_returns_404_for_expired_jobs(): void
    {
        $jobPosting = JobPosting::factory()->create([
            'closed_at' => today()->subDay(),
        ]);
        $response = $this->get(route('jobs.edit', $jobPosting));
        $response->assertStatus(404);
    }

    public function test_jobs_update_returns_404_for_expired_jobs(): void
    {
        $password = fake()->password;
        $jobPosting = JobPosting::factory()->create([
            'closed_at' => today()->subDay(),
            'email' => fake()->freeEmail,
            'password' => Hash::make($password),
        ]);
        $params = JobPosting::factory()->make([
            'title' => fake()->word,
        ])->toArray();
        $params['closed_at'] = today()->addDay()->format('Y-m-d');
        $params['email'] = $jobPosting->email;
        $response = $this->put(route('jobs.update', $jobPosting), array_merge($params, ['password' => $password]));
        $response->assertSessionMissing('message');
        $response->assertStatus(404);
        $this->assertDatabaseMissing('job_postings', [
            'id' => $jobPosting->id,
            'title' => $params['title'],
            'description' => $params['description'],
        ]);
    }

    public function test_job_delete_page_returns_404_for_expired_jobs(): void
    {
        $jobPosting = JobPosting::factory()->create([
            'closed_at' => today()->subDay(),
        ]);
        $response = $this->get(route('jobs.destroy.confirm', $jobPosting));
        $response->assertStatus(404);
    }

    public function test_jobs_destroy_returns_404_for_expired_jobs(): void
    {
        $password = fake()->password;
        $jobPosting = JobPosting::factory()->create([
            'closed_at' => today()->subDay(),
            'email' => fake()->freeEmail,
            'password' => Hash::make($password),
        ]);
        $params = [
            'email' => $jobPosting->email,
            'password' => $password,
        ];
        $response = $this->delete(route('jobs.destroy', $jobPosting), $params);
        $response->assertSessionMissing('message');
        $response->assertStatus(404);
        $this->assertNotSoftDeleted($jobPosting);
    }
/*
|--------------------------------------------------------------------------
| Tests for authentication
|--------------------------------------------------------------------------
*/
    public function test_jobs_cannot_be_updated_with_wrong_email(): void
    {
        $password = fake()->password;
        $jobPosting = JobPosting::factory()->create([
            'closed_at' => today()->addDay(),
            'email' => fake()->freeEmail,
            'password' => Hash::make($password),
        ]);
        $params = JobPosting::factory()->make([
            'title' => fake()->word,
        ])->toArray();
        $params['closed_at'] = today()->addDay()->format('Y-m-d');
        $response = $this->put(route('jobs.update', $jobPosting), array_merge($params, ['password' => $password]));
        $response->assertSessionHasErrors([
            'email' => __('auth.failed'),
            'password',
        ]);
        $this->assertDatabaseMissing('job_postings', [
            'id' => $jobPosting->id,
            'title' => $params['title'],
            'description' => $params['description'],
        ]);
    }

    public function test_jobs_cannot_be_updated_with_wrong_password(): void
    {
        $jobPosting = JobPosting::factory()->create([
            'closed_at' => today()->addDay(),
            'email' => fake()->freeEmail,
            'password' => Hash::make(fake()->password),
        ]);
        $params = JobPosting::factory()->make([
            'title' => fake()->word,
        ])->toArray();
        $params['closed_at'] = today()->addDay()->format('Y-m-d');
        $params['email'] = $jobPosting->email;
        $response = $this->put(route('jobs.update', $jobPosting), array_merge($params, ['password' => fake()->password]));
        $response->assertSessionHasErrors([
            'email' => __('auth.failed'),
            'password',
        ]);
        $this->assertDatabaseMissing('job_postings', [
            'id' => $jobPosting->id,
            'title' => $params['title'],
            'description' => $params['description'],
        ]);
    }

    public function test_jobs_cannot_be_soft_deleted_with_wrong_email(): void
    {
        $password = fake()->password;
        $jobPosting = JobPosting::factory()->create([
            'closed_at' => today()->addDay(),
            'email' => fake()->freeEmail,
            'password' => Hash::make($password),
        ]);
        $params = [
            'email' => fake()->freeEmail,
            'password' => $password,
        ];
        $response = $this->delete(route('jobs.destroy', $jobPosting), $params);
        $response->assertSessionHasErrors([
            'email' => __('auth.failed'),
            'password',
        ]);
        $this->assertNotSoftDeleted($jobPosting);
    }

    public function test_jobs_cannot_be_soft_deleted_with_wrong_password(): void
    {
        $jobPosting = JobPosting::factory()->create([
            'closed_at' => today()->addDay(),
            'email' => fake()->freeEmail,
            'password' => Hash::make(fake()->password),
        ]);
        $params = [
            'email' => fake()->freeEmail,
            'password' => fake()->password,
        ];
        $response = $this->delete(route('jobs.destroy', $jobPosting), $params);
        $response->assertSessionHasErrors([
            'email' => __('auth.failed'),
            'password',
        ]);
        $this->assertNotSoftDeleted($jobPosting);
    }
/*
|--------------------------------------------------------------------------
| Others
|--------------------------------------------------------------------------
*/
    public function test_duplicated_jobs_cannot_be_stored(): void
    {
        $name = fake()->name;
        $email = fake()->freeEmail;
        $jobPosting = JobPosting::factory()->create([
            'title' => fake()->word,
            'closed_at' => today()->addDay(),
            'name' => $name,
            'email' => $email,
        ]);
        $params = $jobPosting->toArray();
        $params['closed_at'] = today()->addDay()->format('Y-m-d');
        $params['name'] = $name;
        $params['email'] = $email;
        $password = fake()->password;
        $response = $this->post(route('jobs.store'), array_merge($params, ['password' => $password]));
        $response->assertSessionHasErrors([
            'title' => __('Your company has already posted ":title".', ['title' => $jobPosting->title]),
        ]);
    }
}
