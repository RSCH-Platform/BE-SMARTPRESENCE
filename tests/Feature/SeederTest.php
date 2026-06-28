<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\SmartPresenceSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SeederTest extends TestCase
{
    use RefreshDatabase;

    public function test_super_admin_has_correct_role_from_seeder()
    {
        // Jalankan seeder
        $this->seed(SmartPresenceSeeder::class);

        // Cari user dengan NIP 0000.00001
        $user = User::where('nip', '0000.00001')->first();

        // Pastikan user ditemukan
        $this->assertNotNull($user, 'User dengan NIP 0000.00001 tidak ditemukan');

        // Pastikan user memiliki role super_admin (id = 1)
        $this->assertTrue($user->roles->contains('id', 1), 'User tidak memiliki role Super Admin (id=1)');
        $this->assertTrue($user->roles->contains('role', 'super_admin'), 'User tidak memiliki role bernama super_admin');

        // Pastikan user tidak memiliki role lain secara tidak sengaja (opsional)
        $this->assertCount(1, $user->roles, 'User harusnya hanya memiliki 1 role');
    }
}
