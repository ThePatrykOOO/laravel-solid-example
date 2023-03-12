<?php

use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\EmployeeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::apiResource('departments', DepartmentController::class);
Route::post('departments/report/{department}/{type}', [DepartmentController::class, 'generateReportListOfEmployees']
)->middleware('throttle:6,1440');


Route::apiResource('employees', EmployeeController::class);
