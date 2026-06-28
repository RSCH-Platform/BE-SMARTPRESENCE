<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Role;
use App\Models\MeetingRoom;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class MeetingRoomApiTest extends TestCase
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

    public function test_can_fetch_meeting_rooms()
    {
        MeetingRoom::create(['name' => 'Ruang A', 'location' => 'Lantai 1', 'capacity' => 10, 'is_active' => true]);
        MeetingRoom::create(['name' => 'Ruang B', 'location' => 'Lantai 2', 'capacity' => 20, 'is_active' => false]);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->getJson('/api/meeting-rooms');

        $response->assertStatus(200)
                 ->assertJsonPath('data.data.0.name', 'Ruang A')
                 ->assertJsonPath('data.total', 2);
    }

    public function test_can_create_meeting_room()
    {
        $payload = [
            'name' => 'Ruang C',
            'location' => 'Lantai 3',
            'capacity' => 15,
            'is_active' => true
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->postJson('/api/meeting-room', $payload);

        $response->assertStatus(201)
                 ->assertJsonPath('data.name', 'Ruang C');

        $this->assertDatabaseHas('meeting_rooms', ['name' => 'Ruang C']);
    }

    public function test_can_show_meeting_room()
    {
        $room = MeetingRoom::create(['name' => 'Ruang D', 'location' => 'Lantai 4', 'capacity' => 50, 'is_active' => true]);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->getJson('/api/meeting-room/' . $room->id);

        $response->assertStatus(200)
                 ->assertJsonPath('data.name', 'Ruang D');
    }

    public function test_can_update_meeting_room()
    {
        $room = MeetingRoom::create(['name' => 'Old Room', 'location' => 'Lantai 4', 'capacity' => 50, 'is_active' => true]);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->patchJson('/api/meeting-room/' . $room->id, [
            'name' => 'New Room'
        ]);

        $response->assertStatus(200)
                 ->assertJsonPath('data.name', 'New Room');

        $this->assertDatabaseHas('meeting_rooms', ['name' => 'New Room']);
    }

    public function test_can_toggle_meeting_room_status()
    {
        $room = MeetingRoom::create(['name' => 'Toggle Room', 'location' => 'Lantai 5', 'capacity' => 30, 'is_active' => true]);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->patchJson('/api/meeting-room/' . $room->id . '/toggle-status');

        $response->assertStatus(200);

        $this->assertDatabaseHas('meeting_rooms', [
            'id' => $room->id,
            'is_active' => false
        ]);
    }

    public function test_can_delete_meeting_room()
    {
        $room = MeetingRoom::create(['name' => 'Delete Room', 'location' => 'Lantai 5', 'capacity' => 30, 'is_active' => true]);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->deleteJson('/api/meeting-room/' . $room->id);

        $response->assertStatus(200);

        $this->assertSoftDeleted('meeting_rooms', ['id' => $room->id]);
    }
}
