<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Role;
use App\Models\Employee;
use App\Models\Meeting;
use App\Models\MeetingRoom;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class DashboardApiTest extends TestCase
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

    public function test_can_fetch_dashboard_data()
    {
        // Create an employee
        // Create an employee type
        $employeeType = \App\Models\EmployeeType::create(['employee_type' => 'PNS']);

        // Create an employee
        Employee::create([
            'nip' => '12345',
            'full_name' => 'Budi',
            'employee_type_id' => $employeeType->id,
            'is_active' => true
        ]);
        
        // Create a room
        $room = MeetingRoom::create(['name' => 'Ruang Utama', 'location' => 'Lantai 1', 'capacity' => 10, 'is_active' => true]);

        // Create a meeting
        Meeting::create([
            'title' => 'Rapat Penting',
            'room_id' => $room->id,
            'start_time' => Carbon::now()->subHour(),
            'end_time' => Carbon::now()->addHour(),
            'created_by' => $this->adminUser->id,
            'status' => 'menunggu'
        ]);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->getJson('/api/dashboard');

        $response->assertStatus(200)
                 ->assertJsonPath('data.summary.total_employees', 1)
                 ->assertJsonPath('data.summary.meetings_today', 1);
    }
}
