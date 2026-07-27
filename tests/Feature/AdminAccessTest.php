<?php

namespace Tests\Feature;

use Tests\TestCase;

class AdminAccessTest extends TestCase
{
    public function test_guest_is_redirected_to_admin_login_when_accessing_admin_dashboard(): void
    {
        $response = $this->get('/admin/dashboard');

        $response->assertRedirect('/admin/login');
    }
}
