<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmployeeController extends Controller
{
    public function index(Company $company)
    {

        if ($company->tenant_id !== Auth::user()->tenant_id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $employees = $company->employees; // assuming hasMany relation
        return response()->json($employees);
    }

    public function store(Request $request, Company $company)
    {
        if ($company->tenant_id !== Auth::user()->tenant_id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|unique:employees,email',
            'phone' => 'nullable|string|max:20',
            'position' => 'nullable|string|max:100',
            'salary' => 'nullable|numeric',
        ]);

        $employee = $company->employees()->create($request->only([
            'name', 'email', 'phone', 'position', 'salary'
        ]));

        return response()->json([
            'message' => 'Employee created successfully',
            'data' => $employee
        ], 201);
    }

    public function update(Request $request, Employee $employee)
    {
        $company = $employee->company;
        if ($company->tenant_id !== Auth::user()->tenant_id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|nullable|email|unique:employees,email,' . $employee->id,
            'phone' => 'sometimes|nullable|string|max:20',
            'position' => 'sometimes|nullable|string|max:100',
            'salary' => 'sometimes|nullable|numeric',
        ]);

        $employee->update($request->only([
            'name', 'email', 'phone', 'position', 'salary'
        ]));

        return response()->json([
            'message' => 'Employee updated successfully',
            'data' => $employee->fresh()
        ]);
    }

    public function destroy(Employee $employee)
    {
        $company = $employee->company;
        if ($company->tenant_id !== Auth::user()->tenant_id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $employee->delete();

        return response()->json(['message' => 'Employee deleted successfully']);
    }

}
