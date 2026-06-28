<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthApiTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        DB::table('roles')->insert(['id' => 1, 'role' => 'super_admin']);
    }

    public function test_user_can_login_with_correct_credentials()
    {
        $user = User::factory()->create([
            'nip' => '1234567890',
            'password' => \Illuminate\Support\Facades\Hash::make('password123'),
            'status' => 'active',
            'role_id' => 1,
        ]);

        $response = $this->postJson('/api/login', [
            'nip' => '1234567890',
            'password' => 'password123',
        ]);

        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'message',
                     'token',
                     'user'
                 ]);
    }

    public function test_user_cannot_login_with_incorrect_password()
    {
        $user = User::factory()->create([
            'nip' => '1234567890',
            'password' => \Illuminate\Support\Facades\Hash::make('password123'),
            'status' => 'active',
            'role_id' => 1,
        ]);

        $response = $this->postJson('/api/login', [
            'nip' => '1234567890',
            'password' => 'wrongpassword',
        ]);

        $response->assertStatus(401)
                 ->assertJson([
                     'message' => 'NIP atau password salah'
                 ]);
    }

    public function test_inactive_user_cannot_login()
    {
        $user = User::factory()->create([
            'nip' => '0987654321',
            'password' => \Illuminate\Support\Facades\Hash::make('password123'),
            'status' => 'inactive',
            'role_id' => 1,
        ]);

        $response = $this->postJson('/api/login', [
            'nip' => '0987654321',
            'password' => 'password123',
        ]);

        $response->assertStatus(403)
                 ->assertJson([
                     'message' => 'User tidak aktif'
                 ]);
    }

    public function test_user_can_logout()
    {
        $user = User::factory()->create([
            'nip' => '1234567890',
            'password' => 'password123',
            'status' => 'active',
            'role_id' => 1,
        ]);
        
        $token = $user->createToken('auth_token')->plainTextToken;

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->postJson('/api/logout');

        $response->assertStatus(200)
                 ->assertJson([
                     'message' => 'Logout berhasil'
                 ]);
    }

    public function test_login_requires_nip()
    {
        $response = $this->postJson('/api/login', [
            'password' => 'password123',
        ]);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors('nip');
    }

    public function test_login_requires_password()
    {
        $response = $this->postJson('/api/login', [
            'nip' => '1234567890',
        ]);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors('password');
    }

    public function test_user_cannot_login_with_non_existent_nip()
    {
        $response = $this->postJson('/api/login', [
            'nip' => 'nobody',
            'password' => 'password123',
        ]);

        $response->assertStatus(401)
                 ->assertJson([
                     'message' => 'NIP atau password salah'
                 ]);
    }
}
