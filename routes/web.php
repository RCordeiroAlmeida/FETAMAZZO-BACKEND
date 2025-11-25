<?php

use App\Http\Controllers\ProccessController;
use Illuminate\Support\Facades\Route;


Route::get('/proccess/{codigo}',[ProccessController::class, 'search']);
