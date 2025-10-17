<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    public function test_home_redirects_to_dashboard(): void
    {
        $response = $this->get(route('home'));

        $response->assertRedirect(route('dashboard'));
    }

    public function test_login_page_returns_successful_response(): void
    {
        $response = $this->get(route('login'));

        $response->assertStatus(200);
    }
}
