<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserNameFormattingTest extends TestCase
{
    use RefreshDatabase;

    public function test_staff_account_name_uses_three_parts_and_capitalizes_each_word(): void
    {
        $admin = User::factory()->create([
            'name' => 'System Administrator',
            'email' => 'admin@example.com',
            'role' => 'System Administrator',
            'status' => 'active',
        ]);

        $this->actingAs($admin);

        $response = $this->post(route('users.store'), [
            'first_name' => 'juan',
            'middle_name' => 'de la',
            'last_name' => 'cruz',
            'email' => 'juan.cruz@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'role' => 'Official',
        ]);

        $response->assertRedirect(route('users.index'));
        $this->assertDatabaseHas('users', [
            'email' => 'juan.cruz@example.com',
            'name' => 'Juan De La Cruz',
        ]);
    }

    public function test_profile_name_is_split_into_first_middle_and_last_name_parts(): void
    {
        $admin = User::factory()->create([
            'name' => 'Juan Dela Cruz',
            'email' => 'juan@example.com',
            'role' => 'System Administrator',
            'status' => 'active',
        ]);

        $this->actingAs($admin);

        $response = $this->put(route('account.profile.update'), [
            'first_name' => 'maria',
            'middle_name' => 'santos',
            'last_name' => 'reyes',
            'email' => 'maria.reyes@example.com',
        ]);

        $response->assertSessionHasNoErrors();
        $this->assertDatabaseHas('users', [
            'id' => $admin->id,
            'name' => 'Maria Santos Reyes',
            'email' => 'maria.reyes@example.com',
        ]);
    }
}
