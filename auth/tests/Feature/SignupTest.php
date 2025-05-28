<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;


class SignUpTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function testSignUpWithUnmatchedPassword(): void
    {
        $response = $this->post('/signup', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'secret123',
            'password_confirmation' => 'different123',
        ]);

        $response->assertSessionHasErrors(['password']);
        $this->assertDatabaseMissing('users', ['email' => 'john@example.com']);
    }

    public function testSignUpWithShortPassword(): void
    {
        $response = $this->post('/signup', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => '123',
            'password_confirmation' => '123',
        ]);

        $response->assertSessionHasErrors(['password']);
        $this->assertDatabaseMissing('users', ['email' => 'john@example.com']);
    }

    public function testSuccessfulSignup(): void
    {
        $response = $this->post('/signup', [
            'name' => 'Alice Smith',
            'email' => 'alice@example.com',
            'password' => 'validPassword123',
            'password_confirmation' => 'validPassword123',
        ]);

        $response->assertRedirect('/'); // or wherever you redirect after signup
        $this->assertDatabaseHas('users', ['email' => 'alice@example.com']);
    }

}
