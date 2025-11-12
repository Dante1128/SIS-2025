<?php

namespace App\Http\Controllers;

use App\Models\Subsecuente;
use App\Models\Curso;
use Illuminate\Http\Request;

class SubsecuenteController extends Controller
{
    public function index()
    {
        $subsecuentes = Subsecuente::with('curso')->orderBy('id_subsecuente', 'desc')->get();
        $cursos = Curso::orderBy('nombre_curso')->get();

        return view('gestion.subsecuente', compact('subsecuentes', 'cursos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_curso' => 'required|exists:Curso,id_curso',
            'desc_subsecuente' => 'required|string|max:100',
        ]);

        Subsecuente::create($request->all());

        return redirect()->route('subsecuentes.index')
                         ->with('success', 'Curso subsecuente registrado exitosamente.');
    }

    public function update(Request $request, $id)
    {
        $subsecuente = Subsecuente::findOrFail($id);

        $request->validate([
            'id_curso' => 'required|exists:Curso,id_curso',
            'desc_subsecuente' => 'required|string|max:100',
        ]);

        $subsecuente->update($request->all());

        return redirect()->route('subsecuentes.index')
                         ->with('success', 'Curso subsecuente actualizado exitosamente.');
    }

    public function destroy($id)
    {
        $subsecuente = Subsecuente::findOrFail($id);
        $subsecuente->delete();

        return redirect()->route('subsecuentes.index')
                         ->with('success', 'Curso subsecuente eliminado exitosamente.');
    }
}
