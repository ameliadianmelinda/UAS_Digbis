<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Event;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CheckoutLoginFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_checkout_only_shows_google_login_and_summary(): void
    {
        $category = Category::create(['name' => 'Musik']);
        Event::create([
            'category_id' => $category->id,
            'title' => 'Concert Test',
            'description' => 'Desc',
            'date' => now()->addDay(),
            'location' => 'Jakarta',
            'price' => 150000,
            'stock' => 100,
        ]);

        $response = $this->get('/checkout/1');

        $response->assertOk();
        $response->assertSee('Continue with Google');
        $response->assertSee('Pesanan Anda');
        $response->assertDontSee('📦 Data Pemesan');
        $response->assertDontSee('No. WhatsApp');
    }

    public function test_authenticated_checkout_shows_buyer_form_after_login(): void
    {
        $category = Category::create(['name' => 'Musik']);
        Event::create([
            'category_id' => $category->id,
            'title' => 'Concert Test',
            'description' => 'Desc',
            'date' => now()->addDay(),
            'location' => 'Jakarta',
            'price' => 150000,
            'stock' => 100,
        ]);

        $user = User::factory()->create([
            'name' => 'Google User',
            'email' => 'google@example.com',
            'role' => User::ROLE_USER,
            'status' => User::STATUS_ACTIVE,
        ]);

        $response = $this->actingAs($user)->get('/checkout/1');

        $response->assertOk();
        $response->assertSee('📦 Data Pemesan');
        $response->assertSee('No. WhatsApp');
        $response->assertDontSee('Continue with Google');
    }
}
