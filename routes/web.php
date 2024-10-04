<?php

use App\Http\Controllers\PlacementController;
use Illuminate\Support\Facades\Route;

Route::get('', fn() => to_route('placements.index'));

Route::resource('placements', PlacementController::class)
->only(['index', 'show']);
