<?php

namespace App\Http\Controllers;

use App\Models\Perfil;
use App\Models\Programa;
use App\Models\Curso;
use Illuminate\Http\Request;

class PerfilController extends Controller
{
    public function index()
    {
        $perfiles = Perfil::with(['programa', 'curso'])
                          ->orderBy('id_perfil', 'desc')
                          ->get();

        $programas = Programa::orderBy('nombre_programa')->get();
        $cursos = Curso::orderBy('nombre_curso')->get();

        return view('gestion.perfil', compact('perfiles', 'programas', 'cursos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_programa' => 'required|exists:Programa,id_programa',
            'id_curso' => 'required|exists:Curso,id_curso',
        ]);

        Perfil::create($request->all());

        return redirect()->route('perfiles.index')
                         ->with('success', 'Perfil registrado exitosamente.');
    }

    public function update(Request $request, $id)
    {
        $perfil = Perfil::findOrFail($id);

        $request->validate([
            'id_programa' => 'required|exists:Programa,id_programa',
            'id_curso' => 'required|exists:Curso,id_curso',
        ]);

        $perfil->update($request->all());

        return redirect()->route('perfiles.index')
                         ->with('success', 'Perfil actualizado exitosamente.');
    }

    public function destroy($id)
    {
        $perfil = Perfil::findOrFail($id);
        $perfil->delete();

        return redirect()->route('perfiles.index')
                         ->with('success', 'Perfil eliminado exitosamente.');
    }
}
