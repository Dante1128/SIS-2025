<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Persona;
use App\Models\Cargo;
use App\Models\Rol;

class UsuarioController extends Controller
{
    
    public function listado()
    {
        $usuarios = Persona::with(['cargo', 'rol'])->get();
        return view('gestionUsuarios.listadoUsuarios', compact('usuarios'));
    }

    
    public function configuracion()
    {
        $usuarios = Persona::with(['cargo', 'rol'])->get();
        $cargos = Cargo::all();
        $roles = Rol::all();
        return view('gestionUsuarios.configuracionUsuarios', compact('usuarios', 'cargos', 'roles'));
    }


    public function store(Request $request)
    {
        $usuario = new Persona();
        $usuario->nombres = $request->nombres;
        $usuario->apellidos = $request->apellidos;
        $usuario->email = $request->email;
        $usuario->genero = $request->genero;
        $usuario->celular = $request->celular;
        $usuario->id_cargo = $request->id_cargo;
        $usuario->id_rol = $request->id_rol;
        $usuario->save();

        return redirect()->route('usuarios.configuracion')->with('success', 'Usuario creado correctamente');
    }

 
    public function update(Request $request, $id)
{
    $usuario = Persona::findOrFail($id);
    $usuario->nombres = $request->nombres;
    $usuario->apellidos = $request->apellidos;
    $usuario->email = $request->email;
    $usuario->genero = $request->genero;
    $usuario->celular = $request->celular;
    $usuario->save();

    $cargo = Cargo::where('id_persona', $id)->first();
    if($cargo){
        $cargo->nombre_cargo = $request->nombre_cargo;
        $cargo->desc_cargo = $request->desc_cargo;
        $cargo->save();
    }

  
    $rol = Rol::where('id_persona', $id)->first();
    if($rol){
        $rol->nombre_rol = $request->nombre_rol;
        $rol->desc_rol = $request->desc_rol;
        $rol->save();
    }

    return redirect()->route('usuarios.configuracion')->with('success', 'Usuario actualizado correctamente');
}



    public function destroy($id)
    {
        $usuario = Persona::findOrFail($id);
        $usuario->delete();

        return redirect()->route('usuarios.configuracion')->with('success', 'Usuario eliminado correctamente');
    }
}
