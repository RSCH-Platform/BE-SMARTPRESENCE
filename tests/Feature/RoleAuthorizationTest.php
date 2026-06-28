<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Role;
use App\Models\BackupLog;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class RoleAuthorizationTest extends TestCase
{
    use RefreshDatabase;

    protected $superAdmin;
    protected $admin;
    protected $secretary;

    protected function setUp(): void
    {
        parent::setUp();

        // Create roles
        \Illuminate\Support\Facades\DB::table('roles')->insert(['id' => 1, 'role' => 'super_admin']);
        \Illuminate\Support\Facades\DB::table('roles')->insert(['id' => 2, 'role' => 'admin']);
        \Illuminate\Support\Facades\DB::table('roles')->insert(['id' => 3, 'role' => 'sekretaris']);

        $superAdminRole = Role::find(1);
        $adminRole = Role::find(2);
        $secretaryRole = Role::find(3);

        // Create users
        $this->superAdmin = User::factory()->hasAttached($superAdminRole)->create([
            'status' => 'active'
        ]);

        $this->admin = User::factory()->hasAttached($adminRole)->create([
            'status' => 'active'
        ]);

        $this->secretary = User::factory()->hasAttached($secretaryRole)->create([
            'status' => 'active'
        ]);
    }

    public function test_super_admin_can_access_backup_endpoints()
    {
        $token = $this->superAdmin->createToken('auth_token')->plainTextToken;

        // Index
        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token])->getJson('/api/backups');
        $response->assertStatus(200);

        // Stats
        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token])->getJson('/api/backups/stats');
        $response->assertStatus(200);
    }

    public function test_non_super_admin_cannot_access_backup_endpoints()
    {
        $tokenAdmin = $this->admin->createToken('auth_token')->plainTextToken;
        $tokenSecretary = $this->secretary->createToken('auth_token')->plainTextToken;

        $endpoints = [
            ['method' => 'getJson', 'url' => '/api/backups'],
            ['method' => 'getJson', 'url' => '/api/backups/stats'],
            ['method' => 'postJson', 'url' => '/api/backup', 'payload' => ['type' => 'database']],
            ['method' => 'getJson', 'url' => '/api/backup/1/download'],
            ['method' => 'deleteJson', 'url' => '/api/backup/1'],
            ['method' => 'postJson', 'url' => '/api/backup/1/cancel'],
        ];

        foreach ($endpoints as $endpoint) {
            // Admin test
            $response = $this->withHeaders(['Authorization' => 'Bearer ' . $tokenAdmin])
                             ->{$endpoint['method']}($endpoint['url'], $endpoint['payload'] ?? []);
            $response->assertStatus(403);

            // Secretary test
            $response = $this->withHeaders(['Authorization' => 'Bearer ' . $tokenSecretary])
                             ->{$endpoint['method']}($endpoint['url'], $endpoint['payload'] ?? []);
            $response->assertStatus(403);
        }
    }

    public function test_super_admin_can_upload_logo()
    {
        Storage::fake('public');

        $token = $this->superAdmin->createToken('auth_token')->plainTextToken;

        $file = UploadedFile::fake()->image('logo.png');

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token])
             ->postJson('/api/logo/upload', [
                 'image' => $file,
                 'type' => 'logo_kiri_sidebar'
             ]);

        $response->assertStatus(200);
        $response->assertJsonPath('data.key', 'logo_kiri_sidebar');
    }

    public function test_non_super_admin_cannot_upload_logo()
    {
        Storage::fake('public');
        $file = UploadedFile::fake()->image('logo.png');
        $payload = [
             'image' => $file,
             'type' => 'logo_kiri_sidebar'
        ];

        // Admin
        $tokenAdmin = $this->admin->createToken('auth_token')->plainTextToken;
        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $tokenAdmin])
                         ->postJson('/api/logo/upload', $payload);
        $response->assertStatus(403);

        // Secretary
        $tokenSecretary = $this->secretary->createToken('auth_token')->plainTextToken;
        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $tokenSecretary])
                         ->postJson('/api/logo/upload', $payload);
        $response->assertStatus(403);
    }
}
