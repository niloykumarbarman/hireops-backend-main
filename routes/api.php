<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Api\CompanyController;
use App\Http\Controllers\API\EmployeeController;
use App\Http\Controllers\API\AttendanceController;
use App\Http\Controllers\Api\SalaryController;
use App\Http\Controllers\Api\CompanyCostController;



// Public login route
Route::post('/login', function (Request $request) {
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    if (!Auth::attempt($request->only('email', 'password'))) {
        return response()->json([
            'message' => 'The provided credentials are incorrect.'
        ], 401);
    }

    $user = Auth::user();
    $token = $user->createToken('auth_token')->plainTextToken;

    return response()->json([
        'token' => $token,
        'user' => $user
    ]);
});

// Authenticated user info
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Logout
Route::middleware('auth:sanctum')->post('/logout', function (Request $request) {
    $request->user()->currentAccessToken()->delete();
    return response()->json(['message' => 'Logged out successfully']);
});

// Admin only routes
// Admin only routes (Spatie role middleware)
Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {
    // Company CRUD (apiResource )
    Route::apiResource('companies', CompanyController::class);

    // Company-specific Employees (nested routes)
    Route::prefix('companies/{company}')->group(function () {
        // Employee list for a specific company
        Route::get('/employees', [EmployeeController::class, 'index']);

        // Create new employee under a company
        Route::post('/employees', [EmployeeController::class, 'store']);
    });

    // Global employee routes (update & delete - ID )
    Route::put('/employees/{employee}', [EmployeeController::class, 'update']);
    Route::delete('/employees/{employee}', [EmployeeController::class, 'destroy']);
});
Route::apiResource('attendances', AttendanceController::class);

Route::apiResource('salaries', SalaryController::class);

Route::get('employees/{id}/salaries', [SalaryController::class, 'employeeSalary']);
Route::apiResource('company-costs', CompanyCostController::class);
Route::get('/company/{company_id}/costs', [CompanyCostController::class, 'companyCosts']);
