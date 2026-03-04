<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Salary;
use Illuminate\Http\Request;

class SalaryController extends Controller
{

    // List
    public function index()
    {
        return Salary::with('employee')->get();
    }

    // Create
    public function store(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'amount' => 'required|numeric',
            'salary_date' => 'required|date'
        ]);

        $salary = Salary::create($request->all());

        return response()->json([
            'message' => 'Salary created',
            'data' => $salary
        ]);
    }

    // Show single
    public function show($id)
    {
        return Salary::with('employee')->findOrFail($id);
    }

    // Update
    public function update(Request $request, $id)
    {
        $salary = Salary::findOrFail($id);

        $salary->update($request->all());

        return response()->json([
            'message' => 'Salary updated',
            'data' => $salary
        ]);
    }

    // Delete
    public function destroy($id)
    {
        Salary::findOrFail($id)->delete();

        return response()->json([
            'message' => 'Salary deleted'
        ]);
    }
    public function employeeSalary($employeeId)
{
    return Salary::where('employee_id', $employeeId)->get();
}

}

