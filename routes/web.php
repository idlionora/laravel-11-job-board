<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmployerController;
use App\Http\Controllers\JobApplicationController;
use App\Http\Controllers\MyJobApplicationController;
use App\Http\Controllers\MyJobController;
use App\Http\Controllers\PlacementController;
use Illuminate\Support\Facades\Route;

Route::get('', fn() => to_route('placements.index'));

Route::resource('placements', PlacementController::class)
->only(['index', 'show']);

Route::get('login', fn() => to_route('auth.create'))->name('login');
// rerouting because laravel has default reroute to 'login' for inauthenticated user
Route::resource('auth', AuthController::class)
->only(['create', 'store']);

Route::delete('logout', fn() => to_route('auth.destroy'))->name('logout');
Route::delete('auth', [AuthController::class, 'destroy'])
->name('auth.destroy');

Route::middleware('auth')->group(function() {
    Route::resource('placement.application', JobApplicationController::class)
    ->only(['create', 'store']);

    Route::resource('my-job-applications', MyJobApplicationController::class)
    ->only(['index', 'destroy']);    

    Route::resource('employer', EmployerController::class)
    ->only(['create', 'store']);

    Route::middleware('employer')
    ->resource('my-jobs', MyJobController::class);
});
// we can check all the shortcuts in Kernel.php
