<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AppointmentController;

Route::get('/jsontest', [AppointmentController::class, 'test']);