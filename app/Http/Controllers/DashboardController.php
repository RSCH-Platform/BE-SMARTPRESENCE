<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Meeting;
use App\Models\MeetingRoom;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Get dashboard data including summary statistics,
     * today's meetings, and room usage timeline.
     */
    public function index(Request $request)
    {
        try {
            $requestedDate = $request->query('date', Carbon::today()->toDateString());
            $todayDate = Carbon::today()->toDateString();

            // Auto-update meeting statuses based on current time
            $this->autoUpdateStatuses($todayDate);
            if ($requestedDate !== $todayDate) {
                $this->autoUpdateStatuses($requestedDate);
            }

            // statistik - Always use today
            $totalEmployees = Employee::where('is_active', true)->count();
            $meetingsToday = Meeting::whereDate('start_time', $todayDate)->count();
            $meetingsPending = Meeting::whereDate('start_time', $todayDate)
                ->where('status', 'menunggu')
                ->count();
            $meetingsCompleted = Meeting::whereDate('start_time', $todayDate)
                ->where('status', 'selesai')
                ->count();

            // Rapat hari ini dengan detail - Always use today
            $todaysMeetings = Meeting::whereDate('start_time', $todayDate)
                ->with(['room:id,name,location', 'creator:id,username', 'participants', 'attendances'])
                ->orderBy('start_time', 'asc')
                ->get()
                ->map(function ($meeting) {
                    $participantsCount = $meeting->participants->count();
                    $attendancePresent = $meeting->attendances->where('status', 'hadir')->count();
                    $attendanceAbsent = $participantsCount - $attendancePresent;

                    return [
                        'id' => $meeting->id,
                        'title' => $meeting->title,
                        'start_time' => $meeting->start_time->toIso8601String(),
                        'end_time' => $meeting->end_time->toIso8601String(),
                        'status' => $meeting->status,
                        'room' => $meeting->room,
                        'creator' => $meeting->creator,
                        'participants_count' => $participantsCount,
                        'attendance_present' => $attendancePresent,
                        'attendance_absent' => $attendanceAbsent > 0 ? $attendanceAbsent : 0,
                    ];
                });

            // Penggunaan ruang (Uses requested timeline date)
            $roomUsage = MeetingRoom::where('is_active', true)
                ->with(['meetings' => function ($query) use ($requestedDate) {
                    $query->whereDate('start_time', $requestedDate)
                        ->select('id', 'title', 'room_id', 'start_time', 'end_time', 'status')
                        ->orderBy('start_time', 'asc');
                }])
                ->get()
                ->map(function ($room) {
                    return [
                        'id' => $room->id,
                        'name' => $room->name,
                        'meetings' => $room->meetings->map(function ($meeting) {
                            return [
                                'id' => $meeting->id,
                                'title' => $meeting->title,
                                'start_time' => $meeting->start_time->toIso8601String(),
                                'end_time' => $meeting->end_time->toIso8601String(),
                                'status' => $meeting->status,
                            ];
                        }),
                    ];
                });

            return response()->json([
                'message' => 'Dashboard data fetched successfully',
                'data' => [
                    'date' => $todayDate,
                    'summary' => [
                        'total_employees' => $totalEmployees,
                        'meetings_today' => $meetingsToday,
                        'meetings_pending' => $meetingsPending,
                        'meetings_completed' => $meetingsCompleted,
                    ],
                    'todays_meetings' => $todaysMeetings,
                    'room_usage' => $roomUsage,
                ],
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'An error occurred while fetching dashboard data',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Auto-update meeting statuses based on current time.
     * - menunggu:     now < start_time
     * - berlangsung:  start_time <= now <= end_time
     * - selesai:      now > end_time
     */
    private function autoUpdateStatuses(string $date)
    {
        $now = Carbon::now();

        $meetings = Meeting::whereDate('start_time', $date)
            ->where('status', '!=', 'dibatalkan')
            ->get();

        foreach ($meetings as $meeting) {
            $newStatus = $meeting->status;

            if ($now->greaterThan($meeting->end_time)) {
                $newStatus = 'selesai';
            } elseif ($now->greaterThanOrEqualTo($meeting->start_time) && $now->lessThanOrEqualTo($meeting->end_time)) {
                $newStatus = 'berlangsung';
            } else {
                $newStatus = 'menunggu';
            }

            if ($newStatus !== $meeting->status) {
                $meeting->update(['status' => $newStatus]);
            }
        }
    }
}
