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
        $usuario->save();

    
        if ($request->id_cargo) {
            Cargo::create([
                'id_persona' => $usuario->id_persona,
                'nombre_cargo' => $request->nombre_cargo,
                'desc_cargo' => $request->desc_cargo
            ]);
        }

    
        if ($request->id_rol) {
            Rol::create([
                'id_persona' => $usuario->id_persona,
                'nombre_rol' => $request->nombre_rol,
                'desc_rol' => $request->desc_rol
            ]);
        }

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

       
        if ($request->id_cargo) {
            Cargo::updateOrCreate(
                ['id_persona' => $id],
                ['nombre_cargo' => $request->nombre_cargo, 'desc_cargo' => $request->desc_cargo]
            );
        }

    
        if ($request->id_rol) {
            Rol::updateOrCreate(
                ['id_persona' => $id],
                ['nombre_rol' => $request->nombre_rol, 'desc_rol' => $request->desc_rol]
            );
        }

        return redirect()->route('usuarios.configuracion')->with('success', 'Usuario actualizado correctamente');
    }

 
    public function destroy($id)
    {
        $usuario = Persona::findOrFail($id);
        $usuario->delete();

       
        Cargo::where('id_persona', $id)->delete();
        Rol::where('id_persona', $id)->delete();

        return redirect()->route('usuarios.configuracion')->with('success', 'Usuario eliminado correctamente');
    }
}
