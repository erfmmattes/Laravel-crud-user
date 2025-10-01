<?php
namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_user()
    {
        $response = $this->postJson('/api/users', [
            'name' => 'Teste',
            'email' => 'teste@teste.com',
            'password' => '123456',
        ]);

        $response->assertStatus(201)
            ->assertJson([
                'name' => 'Teste',
                'email' => 'teste@teste.com',
            ]);
    }

    public function test_list_users()
    {
        User::factory()->count(2)->create();

        $response = $this->getJson('/api/users');

        $response->assertStatus(200)
            ->assertJsonCount(2);
    }

    public function test_show_user()
    {
        $user = User::factory()->create();

        $response = $this->getJson("/api/users/{$user->id}");

        $response->assertStatus(200)
            ->assertJson([
                'id' => $user->id,
                'email' => $user->email,
            ]);
    }

    public function test_show_user_not_found()
    {
        $response = $this->getJson('/api/users/9999');

        $response->assertStatus(404)
            ->assertJson(['message' => 'User not found']);
    }

    public function test_update_user()
    {
        $user = User::factory()->create();

        $response = $this->putJson("/api/users/{$user->id}", [
            'name' => 'Updated Name',
            'email' => 'updated@example.com',
            'password' => 'newpassword',
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'name' => 'Updated Name',
                'email' => 'updated@example.com',
            ]);
    }

    public function test_update_user_not_found()
    {
        $response = $this->putJson('/api/users/9999', [
            'name' => 'Updated Name',
        ]);

        $response->assertStatus(404)
            ->assertJson(['message' => 'User not found']);
    }

    public function test_delete_user()
    {
        $user = User::factory()->create();

        $response = $this->deleteJson("/api/users/{$user->id}");

        $response->assertStatus(204);

        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }

    public function test_delete_user_not_found()
    {
        $response = $this->deleteJson('/api/users/9999');

        $response->assertStatus(404)
            ->assertJson(['message' => 'User not found']);
    }
}