<?php

namespace Tests\Feature;

use App\Mail\ContactReceived;
use App\Mail\ContactSent;
use Illuminate\Support\Facades\Mail;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class ContactTest extends TestCase
{
    public function test_contact_page_can_be_rendered(): void
    {
        $response = $this->get(route('contact'))
                        ->assertInertia(fn (Assert $page) => $page
                            ->component('Contacts/Create')
                        );
        $response->assertStatus(200);
    }

    public function test_new_inquiries_can_be_sent(): void
    {
        Mail::fake();
        $params = [
            'name' => fake()->name,
            'email' => fake()->freeEmail,
            'message' => fake()->realText,
        ];
        $response = $this->post(route('contact'), $params)
                        ->assertInertia(fn (Assert $page) => $page
                            ->component('Contacts/Thanks')
                        );
        $response->assertSessionHas('message', __('Thank you for your inquiry'));
        $this->assertDatabaseHas('contacts', $params);
        Mail::assertQueued(ContactSent::class, function ($mail) use ($params) {
            return $mail->hasTo($params['email']);
        });
        Mail::assertQueued(ContactReceived::class, function ($mail) {
            return $mail->hasTo(config('mail.admin'));
        });
    }
}
