<?php

namespace Tests\Feature;

use Tests\TestCase;

class HomeTest extends TestCase
{
    public function test_home_page_can_be_rendered(): void
    {
        $response = $this->get(route('home'));
        $response->assertStatus(200);
        $response->assertViewIs('home');
    }
}
