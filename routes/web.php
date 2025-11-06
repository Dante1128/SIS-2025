<?php

use Illuminate\Support\Facades\Route;

use App\http\Controllers\GestionController;
use App\Http\Controllers\DominioSubdominioController;

Route::get('/', function () {
    return view('base');
});

Route::resource('gestiones', GestionController::class);




Route::get('/dominio-subdominio', [DominioSubdominioController::class, 'index'])->name('dominioSubdominio');

Route::post('/dominio', [DominioSubdominioController::class, 'storeDominio'])->name('dominio.store');
Route::put('/dominio/{id}', [DominioSubdominioController::class, 'updateDominio'])->name('dominio.update');
Route::patch('/dominio/{id}/toggle', [DominioSubdominioController::class, 'toggleDominio'])->name('dominio.toggle');

Route::post('/subdominio', [DominioSubdominioController::class, 'storeSubdominio'])->name('subdominio.store');
Route::put('/subdominio/{id}', [DominioSubdominioController::class, 'updateSubdominio'])->name('subdominio.update');
Route::patch('/subdominio/{id}/toggle', [DominioSubdominioController::class, 'toggleSubdominio'])->name('subdominio.toggle');