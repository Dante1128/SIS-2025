<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Persona;
use App\Models\Cargo;
use App\Models\CargoPersona;

class UsuarioController extends Controller
{

    public function listado()
    {
        $usuarios = Persona::with(['cargoPersona.cargo'])->get();
        return view('gestionUsuarios.listadoUsuarios', compact('usuarios'));
    }


    public function configuracion()
    {
        $usuarios = Persona::with(['cargoPersona.cargo'])->get();
        $cargos = Cargo::all();
        return view('gestionUsuarios.configuracionUsuarios', compact('usuarios', 'cargos'));
    }


    public function store(Request $request)
    {

        $usuario = new Persona();
        $usuario->nombres = $request->nombres;
        $usuario->apellidos = $request->apellidos;
        $usuario->email = $request->email;
        $usuario->genero = $request->genero;
        $usuario->celular = $request->celular;
        $usuario->cod_persona = $request->cod_persona;
        $usuario->save();


        if ($request->id_cargo) {
            CargoPersona::create([
                'id_cargo' => $request->id_cargo,
                'id_persona' => $usuario->id_persona,
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
        $usuario->cod_persona = $request->cod_persona;
        $usuario->save();


        if ($request->id_cargo) {
            CargoPersona::updateOrCreate(
                ['id_persona' => $id],
                ['id_cargo' => $request->id_cargo]
            );
        }

        return redirect()->route('usuarios.configuracion')->with('success', 'Usuario actualizado correctamente');
    }


    public function destroy($id)
    {
        CargoPersona::where('id_persona', $id)->delete();

        $usuario = Persona::findOrFail($id);
        $usuario->delete();

        return redirect()->route('usuarios.configuracion')->with('success', 'Usuario eliminado correctamente');
    }
}
