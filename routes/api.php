<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\API\CompanyController;
use App\Http\Controllers\API\EmployeeController;
use App\Http\Controllers\API\AttendanceController;
use App\Http\Controllers\API\SalaryController;
use App\Http\Controllers\API\CompanyCostController;


/*
|--------------------------------------------------------------------------
| Public Login Route
|--------------------------------------------------------------------------
*/

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


/*
|--------------------------------------------------------------------------
| Protected Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth:sanctum')->group(function () {

    // Logged user info
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // Logout
    Route::post('/logout', function (Request $request) {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logged out successfully'
        ]);
    });


    /*
    |--------------------------------------------------------------------------
    | Admin Routes
    |--------------------------------------------------------------------------
    */

    Route::middleware('role:admin')->group(function () {

        // Company CRUD
        Route::apiResource('companies', CompanyController::class);

        // Company Employees
        Route::prefix('companies/{company}')->group(function () {

            // Employee list
            Route::get('/employees', [EmployeeController::class, 'index']);

            // Create employee
            Route::post('/employees', [EmployeeController::class, 'store']);

        });

        // Employee update/delete
        Route::put('/employees/{employee}', [EmployeeController::class, 'update']);
        Route::delete('/employees/{employee}', [EmployeeController::class, 'destroy']);

    });


    /*
    |--------------------------------------------------------------------------
    | Employee System
    |--------------------------------------------------------------------------
    */

    // Attendance
    Route::apiResource('attendances', AttendanceController::class);

    // Salary
    Route::apiResource('salaries', SalaryController::class);

    // Employee salary history
    Route::get('employees/{id}/salaries', [SalaryController::class, 'employeeSalary']);

    // Company Costs
    Route::apiResource('company-costs', CompanyCostController::class);

    // Company cost list
    Route::get('/company/{company_id}/costs', [CompanyCostController::class, 'companyCosts']);

});