<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Persona;
use App\Models\Cargo;
use App\Models\Rol;

class UsuarioController extends Controller
{
    // Listado de usuarios
    public function listado()
    {
        $usuarios = Persona::with(['cargo', 'rol'])->get();
        return view('gestionUsuarios.listadoUsuarios', compact('usuarios'));
    }

    // Configuración de usuarios
    public function configuracion()
    {
        $usuarios = Persona::with(['cargo', 'rol'])->get();
        $cargos = Cargo::all();
        $roles = Rol::all();
        return view('gestionUsuarios.configuracionUsuarios', compact('usuarios', 'cargos', 'roles'));
    }

    // Crear nuevo usuario
    public function store(Request $request)
    {
        // Crear usuario
        $usuario = new Persona();
        $usuario->nombres = $request->nombres;
        $usuario->apellidos = $request->apellidos;
        $usuario->email = $request->email;
        $usuario->genero = $request->genero;
        $usuario->celular = $request->celular;
        $usuario->save();

        // Crear cargo solo si se seleccionó
        if ($request->id_cargo) {
            Cargo::create([
                'id_persona' => $usuario->id_persona,
                'nombre_cargo' => $request->nombre_cargo,
                'desc_cargo' => $request->desc_cargo
            ]);
        }

        // Crear rol solo si se seleccionó
        if ($request->id_rol) {
            Rol::create([
                'id_persona' => $usuario->id_persona,
                'nombre_rol' => $request->nombre_rol,
                'desc_rol' => $request->desc_rol
            ]);
        }

        return redirect()->route('usuarios.configuracion')->with('success', 'Usuario creado correctamente');
    }

    // Actualizar usuario
    public function update(Request $request, $id)
    {
        $usuario = Persona::findOrFail($id);
        $usuario->nombres = $request->nombres;
        $usuario->apellidos = $request->apellidos;
        $usuario->email = $request->email;
        $usuario->genero = $request->genero;
        $usuario->celular = $request->celular;
        $usuario->save();

        // Actualizar o crear cargo
        if ($request->id_cargo) {
            Cargo::updateOrCreate(
                ['id_persona' => $id],
                ['nombre_cargo' => $request->nombre_cargo, 'desc_cargo' => $request->desc_cargo]
            );
        }

        // Actualizar o crear rol
        if ($request->id_rol) {
            Rol::updateOrCreate(
                ['id_persona' => $id],
                ['nombre_rol' => $request->nombre_rol, 'desc_rol' => $request->desc_rol]
            );
        }

        return redirect()->route('usuarios.configuracion')->with('success', 'Usuario actualizado correctamente');
    }

    // Eliminar usuario
    public function destroy($id)
    {
        $usuario = Persona::findOrFail($id);
        $usuario->delete();

        // Opcional: eliminar cargos y roles relacionados
        Cargo::where('id_persona', $id)->delete();
        Rol::where('id_persona', $id)->delete();

        return redirect()->route('usuarios.configuracion')->with('success', 'Usuario eliminado correctamente');
    }
}
