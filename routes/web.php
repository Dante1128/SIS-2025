<?php

use Illuminate\Support\Facades\Route;

use App\http\Controllers\GestionController;
use App\Http\Controllers\DominioSubdominioController;

Route::get('/', function () {
    return view('base');
});
//--------GESTIONES--------------
Route::get('/gestiones', [GestionController::class, 'index'])->name('gestiones.index');
Route::post('/gestiones', [GestionController::class, 'store'])->name('gestiones.store');
Route::put('/gestiones/{id}', [GestionController::class, 'update'])->name('gestiones.update');
Route::delete('/gestiones/{id}', [GestionController::class, 'destroy'])->name('gestiones.destroy');
//--------DOMINIO----------
Route::get('/dominio-subdominio', [DominioSubdominioController::class, 'index'])->name('dominioSubdominio');
Route::post('/dominio', [DominioSubdominioController::class, 'storeDominio'])->name('dominio.store');
Route::put('/dominio/{id}', [DominioSubdominioController::class, 'updateDominio'])->name('dominio.update');
Route::patch('/dominio/{id}/toggle', [DominioSubdominioController::class, 'toggleDominio'])->name('dominio.toggle');
//--------SUBDOMINIO-------
Route::post('/subdominio', [DominioSubdominioController::class, 'storeSubdominio'])->name('subdominio.store');
Route::put('/subdominio/{id}', [DominioSubdominioController::class, 'updateSubdominio'])->name('subdominio.update');
Route::patch('/subdominio/{id}/toggle', [DominioSubdominioController::class, 'toggleSubdominio'])->name('subdominio.toggle');