<?php

namespace App\Http\Controllers;

use App\Models\MeetingRoom;
use App\Http\Requests\storeMeetingRoomRequest;
use Exception;
class MeetingsRoomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $result = MeetingRoom::latest()->paginate(10);
            return response()->json([
                'message' => 'Meeting rooms fetched successfully',
                'data' => $result,
            ], 200);
        } catch (Exception $e) {
            return response()->json(['message' => 'An error occurred while fetching meeting rooms', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(storeMeetingRoomRequest $request)
    {
        try {
            $request = $request->validated();
            $result = MeetingRoom::create($request);
            return response()->json([
                'message' => 'Meeting room created successfully',
                'data' => $result,
            ], 201);
        } catch (Exception $e) {
            return response()->json(['message' => 'An error occurred while creating meeting room', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $result = MeetingRoom::find($id);
            if (!$result) {
                return response()->json([
                    'message' => 'Meeting room not found'
                ], 404);
            }
            return response()->json([
                'message' => 'Meeting room fetched successfully',
                'data' => $result,
            ], 200);
        } catch (Exception $e) {
            return response()->json(['message' => 'An error occurred while fetching meeting room', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(storeMeetingRoomRequest $request, string $id)
    {
        try {
            $request = $request->validated();
            $result = MeetingRoom::find($id);
            if (!$result) {
                return response()->json([
                    'message' => 'Meeting room not found'
                ], 404);
            }
            $result->update($request);
            return response()->json([
                'message' => 'Meeting room updated successfully',
                'data' => $result,
            ], 200);
        } catch (Exception $e) {
            return response()->json(['message' => 'An error occurred while updating meeting room', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $result = MeetingRoom::findOrFail($id);
            if (!$result) {
                return response()->json([
                    'message' => 'Meeting room not found'
                ], 404);
            }
            $result->delete();
            return response()->json([
                'message' => 'Meeting room deleted successfully',
            ], 200);
        } catch (Exception $e) {
            return response()->json(['message' => 'An error occurred while deleting meeting room', 'error' => $e->getMessage()], 500);
        }
    }
}