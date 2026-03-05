<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employee;

class EmployeeController extends Controller
{

    public function index()
    {
        return response()->json(Employee::all());
    }

    public function store(Request $request)
    {

        $employee = Employee::create($request->all());

        return response()->json([
            'message' => 'Employee created successfully',
            'data' => $employee
        ]);

    }

    public function show($id)
    {
        return response()->json(Employee::findOrFail($id));
    }

    public function update(Request $request, $id)
    {

        $employee = Employee::findOrFail($id);

        $employee->update($request->all());

        return response()->json([
            'message' => 'Employee updated successfully',
            'data' => $employee
        ]);

    }

    public function destroy($id)
    {

        Employee::destroy($id);

        return response()->json([
            'message' => 'Employee deleted successfully'
        ]);

    }

}