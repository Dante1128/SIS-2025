<?php

use Illuminate\Support\Facades\Route;

use App\http\Controllers\GestionController;
use App\Http\Controllers\DominioSubdominioController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\DepartamentoController;
use App\Http\Controllers\ProgramaController;
use App\Http\Controllers\AreaController;
use App\Http\Controllers\CursoController;
use App\Http\Controllers\CursoCuerpoController;
use App\Http\Controllers\BibliografiaController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\PrerequisitosController;
use App\Http\Controllers\SubsecuenteController;

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
//--------Gestión de Usuarios--------------
Route::get('/usuarios', [UsuarioController::class, 'listado'])->name('usuarios.listado');
Route::get('/usuarios/configuracion', [UsuarioController::class, 'configuracion'])->name('usuarios.configuracion');
Route::post('/usuarios', [UsuarioController::class, 'store'])->name('usuarios.store');
Route::put('/usuarios/{id}', [UsuarioController::class, 'update'])->name('usuarios.update');
Route::delete('/usuarios/{id}', [UsuarioController::class, 'destroy'])->name('usuarios.destroy');
//---------Departamentos------
Route::get('/departamentos', [DepartamentoController::class, 'index'])->name('departamentos.index');
Route::post('/departamentos', [DepartamentoController::class, 'store'])->name('departamentos.store');
Route::put('/departamentos/{id}', [DepartamentoController::class, 'update'])->name('departamentos.update');
Route::delete('/departamentos/{id}', [DepartamentoController::class, 'destroy'])->name('departamentos.destroy');
//---------Programas----------
Route::get('/programas', [ProgramaController::class, 'index'])->name('programas.index');
Route::post('/programas', [ProgramaController::class, 'store'])->name('programas.store');
Route::put('/programas/{id}', [ProgramaController::class, 'update'])->name('programas.update');
Route::delete('/programas/{id}', [ProgramaController::class, 'destroy'])->name('programas.destroy');
//---------Area--------
Route::get('/areas', [AreaController::class, 'index'])->name('areas.index');
Route::post('/areas', [AreaController::class, 'store'])->name('areas.store');
Route::put('/areas/{id}', [AreaController::class, 'update'])->name('areas.update');
Route::delete('/areas/{id}', [AreaController::class, 'destroy'])->name('areas.destroy');
//--------Curso----------
Route::get('/cursos', [CursoController::class, 'index'])->name('cursos.index');
Route::post('/cursos', [CursoController::class, 'store'])->name('cursos.store');
Route::put('/cursos/{id}', [CursoController::class, 'update'])->name('cursos.update');
Route::delete('/cursos/{id}', [CursoController::class, 'destroy'])->name('cursos.destroy');
//---------CursoCuerpo---------
Route::get('/curso-cuerpo', [CursoCuerpoController::class, 'index'])->name('cursocuerpo.index');
Route::post('/curso-cuerpo', [CursoCuerpoController::class, 'store'])->name('cursocuerpo.store');
Route::put('/curso-cuerpo/{id}', [CursoCuerpoController::class, 'update'])->name('cursocuerpo.update');
Route::delete('/curso-cuerpo/{id}', [CursoCuerpoController::class, 'destroy'])->name('cursocuerpo.destroy');
//---------Bibliografia---------
Route::get('/bibliografia', [BibliografiaController::class, 'index'])->name('bibliografia.index');
Route::post('/bibliografia', [BibliografiaController::class, 'store'])->name('bibliografia.store');
Route::put('/bibliografia/{id}', [BibliografiaController::class, 'update'])->name('bibliografia.update');
Route::delete('/bibliografia/{id}', [BibliografiaController::class, 'destroy'])->name('bibliografia.destroy');
//------Perfil--------
Route::get('/perfiles', [PerfilController::class, 'index'])->name('perfiles.index');
Route::post('/perfiles', [PerfilController::class, 'store'])->name('perfiles.store');
Route::put('/perfiles/{id}', [PerfilController::class, 'update'])->name('perfiles.update');
Route::delete('/perfiles/{id}', [PerfilController::class, 'destroy'])->name('perfiles.destroy');
//-------Prerequisitos-------
Route::get('/prerequisitos', [PrerequisitosController::class, 'index'])->name('prerequisitos.index');
Route::post('/prerequisitos', [PrerequisitosController::class, 'store'])->name('prerequisitos.store');
Route::put('/prerequisitos/{id}', [PrerequisitosController::class, 'update'])->name('prerequisitos.update');
Route::delete('/prerequisitos/{id}', [PrerequisitosController::class, 'destroy'])->name('prerequisitos.destroy');
//-------Subsecuente---------
Route::get('/subsecuentes', [SubsecuenteController::class, 'index'])->name('subsecuentes.index');
Route::post('/subsecuentes', [SubsecuenteController::class, 'store'])->name('subsecuentes.store');
Route::put('/subsecuentes/{id}', [SubsecuenteController::class, 'update'])->name('subsecuentes.update');
Route::delete('/subsecuentes/{id}', [SubsecuenteController::class, 'destroy'])->name('subsecuentes.destroy');
