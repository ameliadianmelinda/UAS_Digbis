<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PartnerLoginFeedbackTest extends TestCase
{
    use RefreshDatabase;

    public function test_suspended_partner_login_returns_clear_error_and_keeps_email_input(): void
    {
        $email = 'partner-suspended@example.com';

        User::factory()->create([
            'name' => 'Suspended Tenant',
            'email' => $email,
            'password' => bcrypt('password123'),
            'role' => User::ROLE_TENANT,
            'status' => User::STATUS_SUSPENDED,
        ]);

        $this->get('/partner/login')
            ->assertOk();

        $response = $this->from('/partner/login')->post('/partner/login', [
            'email' => $email,
            'password' => 'password123',
        ]);

        $response->assertRedirect('/partner/login');
        $response->assertSessionHasErrors(['email']);
        $response->assertSessionHas('errors');
        $response->assertSessionHasInput('email', $email);
        $this->assertGuest();
    }
}
