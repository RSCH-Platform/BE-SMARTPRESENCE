<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\LoginController;
use App\Http\Controllers\EmployeeController;

Route::post('/login', [LoginController::class, 'login']);

Route::get('/employees', [EmployeeController::class, 'index']);
Route::get('/employees/{id}', [EmployeeController::class, 'show']);