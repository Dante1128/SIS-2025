<?php

use Illuminate\Support\Facades\Route;

use App\http\Controllers\GestionController;

Route::get('/', function () {
    return view('base');
});

Route::resource('gestiones', GestionController::class);