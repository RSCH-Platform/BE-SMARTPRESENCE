<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Role;
use App\Models\EmployeeType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class EmployeeTypeApiTest extends TestCase
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

    public function test_can_fetch_employee_types()
    {
        EmployeeType::create(['employee_type' => 'PNS']);
        EmployeeType::create(['employee_type' => 'Honorer']);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->getJson('/api/employee-types-manage');

        $response->assertStatus(200)
                 ->assertJsonPath('data.data.0.employee_type', 'PNS')
                 ->assertJsonPath('data.total', 2);
    }

    public function test_can_create_employee_type()
    {
        $payload = ['employee_type' => 'Kontrak'];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->postJson('/api/employee-type', $payload);

        $response->assertStatus(201)
                 ->assertJsonPath('data.employee_type', 'Kontrak');

        $this->assertDatabaseHas('employee_types', ['employee_type' => 'Kontrak']);
    }

    public function test_can_show_employee_type()
    {
        $type = EmployeeType::create(['employee_type' => 'PNS']);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->getJson('/api/employee-type/' . $type->id);

        $response->assertStatus(200)
                 ->assertJsonPath('data.employee_type', 'PNS');
    }

    public function test_can_update_employee_type()
    {
        $type = EmployeeType::create(['employee_type' => 'Old Type']);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->patchJson('/api/employee-type/' . $type->id, [
            'employee_type' => 'New Type'
        ]);

        $response->assertStatus(200)
                 ->assertJsonPath('data.employee_type', 'New Type');

        $this->assertDatabaseHas('employee_types', ['employee_type' => 'New Type']);
    }

    public function test_can_delete_employee_type()
    {
        $type = EmployeeType::create(['employee_type' => 'To Delete']);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->deleteJson('/api/employee-type/' . $type->id);

        $response->assertStatus(200);

        $this->assertDatabaseMissing('employee_types', ['id' => $type->id]);
    }
}
