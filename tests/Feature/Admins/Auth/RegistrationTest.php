<?php

namespace Tests\Feature\Admins\Auth;

use App\Modules\Admins\Models\Admin;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_screen_can_be_rendered(): void
    {
        $response = $this->get('/admin/register');

        $response->assertStatus(200);
    }

    public function test_new_admins_can_register(): void
    {
        $response = $this->post('/admin/register', [
            'name' => 'Test Admin',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $this->assertAuthenticatedAs(Admin::first(), 'admin');
        $response->assertRedirect('/admin');
    }
}
