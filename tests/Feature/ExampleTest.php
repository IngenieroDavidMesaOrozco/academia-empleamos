<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        // Seeding the user because the root route logs in the first user
        User::factory()->create([
            'name' => 'Admin User',
            'username' => 'admin_user',
            'email' => 'admin@example.com'
        ]);

        $response = $this->get('/');

        // Expect redirect to admin.dashboard
        $response->assertStatus(302);
        $response->assertRedirect(route('admin.dashboard'));
    }
}
