<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\storeEmployeeRequest;
use App\Models\Employee;
use Exception;

class EmployeeController extends Controller
{
    public function index()
    {
        try {
            $result = Employee::latest()->paginate(50);
            return response()->json([
                'message' => 'Employees fetched successfully',
                'data' => $result,
            ], 200);
        }catch (Exception $e) {
            return response()->json(['message' => 'An error occurred while fetching employees', 'error' => $e->getMessage()], 500);
        }
    }

    public function store(storeEmployeeRequest $request)
    {
        try {
            $request = $request->validated();
            $request['password'] = bcrypt($request['password']);
            $result = Employee::create($request);
            return response()->json([
            'message' => 'Employee created successfully',
            'data' => $result,
            ], 201);
        }catch (Exception $e) {
            return response()->json(['message' => 'An error occurred while creating employee', 'error' => $e->getMessage()], 500);
        }
    }

    public function show(string $id)
    {
        try{
            $result = Employee::find($id);
            if (!$result) {
                return response()->json([
                    'message' => 'Employee not found'
                ], 404);
            }
            if($result->role_id === 1) {
                return response()->json([
                    'message' => 'Access denied'
                ], 403);
            }
            return response()->json([
                'message' => 'Employee fetched successfully',
                'data' => $result,
            ], 200);
        }catch (Exception $e) {
            return response()->json(['message' => 'An error occurred while fetching employee', 'error' => $e->getMessage()], 500);
        }
    }

    public function update(storeEmployeeRequest $request, string $id)
    {
       try{
        $request = $request->validated();
        $result = Employee::find($id);
        if (!$result) {
            return response()->json([
                'message' => 'Employee not found'
            ], 404);
        }
        $result->update($request);
        return response()->json([
            'message' => 'Employee updated successfully',
            'data' => $result,
        ], 200);
       }catch (Exception $e) {
            return response()->json(['message' => 'An error occurred while updating employee', 'error' => $e->getMessage()], 500);
        }
    }


    public function destroy(string $id)
    {
        try{
            $result = Employee::findOrFail($id);
            if (!$result) {
                return response()->json([
                    'message' => 'Employee not found'
                ], 404);
            }
            $result->delete();
            return response()->json([
                'message' => 'Employee deleted successfully',
            ], 200);
        } catch (Exception $e) {
            return response()->json(['message' => 'An error occurred while deleting employee', 'error' => $e->getMessage()], 500);
        }
    }
}