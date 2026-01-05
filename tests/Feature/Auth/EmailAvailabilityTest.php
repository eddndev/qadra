<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EmailAvailabilityTest extends TestCase
{
    use RefreshDatabase;

    public function test_email_creates_availability_check_success(): void
    {
        $response = $this->postJson(route('check.email'), [
            'email' => 'newuser@example.com',
        ]);

        $response->assertStatus(200)
                 ->assertJson([
                     'available' => true,
                 ]);
    }

    public function test_existing_email_returns_unavailable(): void
    {
        User::factory()->create([
            'email' => 'existing@example.com',
        ]);

        $response = $this->postJson(route('check.email'), [
            'email' => 'existing@example.com',
        ]);

        $response->assertStatus(200)
                 ->assertJson([
                     'available' => false,
                     'message' => 'Este correo electrónico ya está registrado.',
                 ]);
    }

    public function test_invalid_email_format_returns_validation_error(): void
    {
        $response = $this->postJson(route('check.email'), [
            'email' => 'not-an-email',
        ]);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['email']);
    }
}
