<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\storeUserRequest;
use Exception;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $result = User::latest()->whereIn('role_id', [2, 3])->get();
            return response()->json([
                'message' => 'Users fetched successfully',
                'data' => $result,
            ], 200);
        } catch (Exception $e) {
            return response()->json(['message' => 'An error occurred while fetching users', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(storeUserRequest $request)
    {
        try {
            $request = $request->validated();
            $result = User::create($request);
            return response()->json([
                'message' => 'User created successfully',
                'data' => $result,
            ], 201);
        } catch (Exception $e) {
            return response()->json(['message' => 'An error occurred while creating user', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $result = User::find($id);
            if (!$result) {
                return response()->json([
                    'message' => 'User not found'
                ], 404);
            }
            if ($result->role_id === 1) {
                return response()->json([
                    'message' => 'Access denied'
                ], 403);
            }
            return response()->json([
                'message' => 'User fetched successfully',
                'data' => $result,
            ], 200);
        } catch (Exception $e) {
            return response()->json(['message' => 'An error occurred while fetching user', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(storeUserRequest $request, string $id)
    {
        try {
            $request = $request->validated();
            $result = User::find($id);
            if (!$result) {
                return response()->json([
                    'message' => 'User not found'
                ], 404);
            }
            $result->update($request);
            return response()->json([
                'message' => 'User updated successfully',
                'data' => $result,
            ], 200);
        } catch (Exception $e) {
            return response()->json(['message' => 'An error occurred while updating user', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $result = User::findOrFail($id);
            if (!$result) {
                return response()->json([
                    'message' => 'User not found'
                ], 404);
            }
            if ($result->role_id === 1) {
                return response()->json([
                    'message' => 'Access denied'
                ], 403);
            }
            $result->delete();
            return response()->json([
                'message' => 'User deleted successfully',
            ], 200);
        } catch (Exception $e) {
            return response()->json(['message' => 'An error occurred while deleting user', 'error' => $e->getMessage()], 500);
        }
    }
}