<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Role;
use App\Models\WorkUnit;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class WorkUnitApiTest extends TestCase
{
    use RefreshDatabase;

    protected $adminUser;
    protected $token;

    protected function setUp(): void
    {
        parent::setUp();
        
        DB::table('roles')->insert(['id' => 1, 'role' => 'super_admin']);
        $adminRole = Role::find(1);
        
        $this->adminUser = User::factory()->hasAttached($adminRole)->create([
            'status' => 'active',
        ]);
        
        $this->token = $this->adminUser->createToken('auth_token')->plainTextToken;
    }

    public function test_can_fetch_work_units()
    {
        WorkUnit::create(['work_unit' => 'Puskesmas A']);
        WorkUnit::create(['work_unit' => 'Puskesmas B']);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->getJson('/api/work-units-manage');

        $response->assertStatus(200)
                 ->assertJsonPath('data.data.0.work_unit', 'Puskesmas A')
                 ->assertJsonPath('data.total', 2);
    }

    public function test_can_create_work_unit()
    {
        $payload = ['work_unit' => 'Dinas Kesehatan'];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->postJson('/api/work-unit', $payload);

        $response->assertStatus(201)
                 ->assertJsonPath('data.work_unit', 'Dinas Kesehatan');

        $this->assertDatabaseHas('work_units', ['work_unit' => 'Dinas Kesehatan']);
    }

    public function test_can_show_work_unit()
    {
        $unit = WorkUnit::create(['work_unit' => 'Puskesmas C']);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->getJson('/api/work-unit/' . $unit->id);

        $response->assertStatus(200)
                 ->assertJsonPath('data.work_unit', 'Puskesmas C');
    }

    public function test_can_update_work_unit()
    {
        $unit = WorkUnit::create(['work_unit' => 'Old Unit']);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->patchJson('/api/work-unit/' . $unit->id, [
            'work_unit' => 'New Unit'
        ]);

        $response->assertStatus(200)
                 ->assertJsonPath('data.work_unit', 'New Unit');

        $this->assertDatabaseHas('work_units', ['work_unit' => 'New Unit']);
    }

    public function test_can_delete_work_unit()
    {
        $unit = WorkUnit::create(['work_unit' => 'To Delete']);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->deleteJson('/api/work-unit/' . $unit->id);

        $response->assertStatus(200);

        $this->assertDatabaseMissing('work_units', ['id' => $unit->id]);
    }
}
