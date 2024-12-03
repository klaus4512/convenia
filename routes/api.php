<?php

use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\EmployeeFileUploadController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');


Route::group(['middleware' => 'auth:api'], function () {
    Route::resource('employee', EmployeeController::class)->only(['index', 'store', 'update', 'destroy']);
    Route::resource('employee_file_upload', EmployeeFileUploadController::class)->only(['store']);
});
