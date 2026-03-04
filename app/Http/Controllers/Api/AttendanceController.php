<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    // LIST + SEARCH
    public function index(Request $request)
    {
        $query = Attendance::with('employee');

        // search by employee_id
        if ($request->employee_id) {
            $query->where('employee_id', $request->employee_id);
        }

        // search by date
        if ($request->date) {
            $query->whereDate('date', $request->date);
        }

        return response()->json($query->latest()->get());
    }

    // CREATE
    public function store(Request $request)
    {
        $attendance = Attendance::create($request->all());

        return response()->json([
            'message' => 'Attendance created',
            'data' => $attendance
        ]);
    }

    // SHOW
    public function show($id)
    {
        $attendance = Attendance::with('employee')->findOrFail($id);

        return response()->json($attendance);
    }

    // UPDATE
    public function update(Request $request, $id)
    {
        $attendance = Attendance::findOrFail($id);

        $attendance->update($request->all());

        return response()->json([
            'message' => 'Attendance updated',
            'data' => $attendance
        ]);
    }

    // DELETE
    public function destroy($id)
    {
        Attendance::findOrFail($id)->delete();

        return response()->json([
            'message' => 'Attendance deleted'
        ]);
    }
}
