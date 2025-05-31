<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Str;
use App\Models\User;

class ListingTest extends TestCase
{

    private string $token;
    private User $user;

    protected function setUp(): void
    {
        parent::setUp();

        // Create a test user
        $password = Str::random(10);
        $user = User::factory()->create([
            'email' => 'testuser@example.com',
            'password' => bcrypt('secret123'),
        ]);
        $this->user = $user;
        $this->token = base64_encode($user->email . $password);
    }

    public function test_unauthenticated_user_cannot_access_availability()
    {
        $this->getJson('/api/availability')
            ->assertStatus(403);
    }

    protected function tearDown(): void
    {
        $this->user->delete();
    }
}
