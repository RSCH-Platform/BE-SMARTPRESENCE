<?php

namespace App\Http\Controllers;

use App\Models\EmployeeType;
use App\Http\Requests\StoreEmployeeTypeRequest;
use App\Http\Requests\UpdateEmployeeTypeRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Exception;

class EmployeeTypeController extends Controller
{
    /**
     * Daftar jabatan dengan search.
     *
     * Query params:
     *  - search   : cari berdasarkan nama jabatan
     *  - per_page : jumlah per halaman (default 10)
     */
    public function index(Request $request)
    {
        try {
            $query = EmployeeType::select('id', 'employee_type', 'created_at')
                ->withCount('employees');

            // Search berdasarkan nama jabatan
            if ($request->filled('search')) {
                $search = $request->query('search');
                $query->where('employee_type', 'like', "%{$search}%");
            }

            $perPage = (int) $request->query('per_page', 10);
            $result = $query->latest()->paginate($perPage);

            return response()->json([
                'message' => 'Employee types fetched successfully',
                'data' => $result,
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'An error occurred while fetching employee types',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Tambah jabatan baru.
     */
    public function store(StoreEmployeeTypeRequest $request)
    {
        try {
            $validated = $request->validated();
            $result = EmployeeType::create($validated);
            $result->loadCount('employees');

            Cache::forget('employee_types');

            return response()->json([
                'message' => 'Employee type created successfully',
                'data' => $result,
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'An error occurred while creating employee type',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Detail jabatan.
     */
    public function show(string $id)
    {
        try {
            $result = EmployeeType::withCount('employees')->find($id);
            if (!$result) {
                return response()->json([
                    'message' => 'Employee type not found',
                ], 404);
            }

            return response()->json([
                'message' => 'Employee type fetched successfully',
                'data' => $result,
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'An error occurred while fetching employee type',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Update jabatan.
     */
    public function update(UpdateEmployeeTypeRequest $request, string $id)
    {
        try {
            $result = EmployeeType::find($id);
            if (!$result) {
                return response()->json([
                    'message' => 'Employee type not found',
                ], 404);
            }

            $validated = $request->validated();
            $result->update($validated);
            $result->loadCount('employees');

            Cache::forget('employee_types');

            return response()->json([
                'message' => 'Employee type updated successfully',
                'data' => $result,
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'An error occurred while updating employee type',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Hapus jabatan.
     */
    public function destroy(string $id)
    {
        try {
            $result = EmployeeType::withCount('employees')->find($id);
            if (!$result) {
                return response()->json([
                    'message' => 'Employee type not found',
                ], 404);
            }

            if ($result->employees_count > 0) {
                return response()->json([
                    'message' => 'Jabatan tidak dapat dihapus karena masih memiliki ' . $result->employees_count . ' karyawan',
                ], 422);
            }

            $result->delete();
            Cache::forget('employee_types');

            return response()->json([
                'message' => 'Employee type deleted successfully',
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'An error occurred while deleting employee type',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
