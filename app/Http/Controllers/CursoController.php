<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use App\Models\Programa;
use App\Models\Area;
use Illuminate\Http\Request;

class CursoController extends Controller
{
    public function index()
    {
        $cursos = Curso::with(['programa', 'area'])
                       ->orderBy('id_curso', 'desc')
                       ->get();

        $programas = Programa::orderBy('nombre_programa')->get();
        $areas = Area::orderBy('nombre')->get();

        return view('gestion.curso', compact('cursos', 'programas', 'areas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_programa' => 'required|exists:Programa,id_programa',
            'id_area' => 'required|exists:Area,id_area',
            'codigo_curso' => 'required|string|max:20|unique:Curso,codigo_curso',
            'nombre_curso' => 'required|string|max:100',
            'id_semestre' => 'nullable|integer|min:1',
            'id_ciclo_formacion' => 'nullable|integer|min:1',
            'cant_semanas_sem' => 'nullable|integer|min:1',
            'competencia_curso' => 'nullable|string',
        ]);

        Curso::create($request->all());

        return redirect()->route('cursos.index')
                         ->with('success', 'Curso registrado exitosamente.');
    }

    public function update(Request $request, $id)
    {
        $curso = Curso::findOrFail($id);

        $request->validate([
            'id_programa' => 'required|exists:Programa,id_programa',
            'id_area' => 'required|exists:Area,id_area',
            'codigo_curso' => 'required|string|max:20|unique:Curso,codigo_curso,' . $curso->id_curso . ',id_curso',
            'nombre_curso' => 'required|string|max:100',
            'id_semestre' => 'nullable|integer|min:1',
            'id_ciclo_formacion' => 'nullable|integer|min:1',
            'cant_semanas_sem' => 'nullable|integer|min:1',
            'competencia_curso' => 'nullable|string',
        ]);

        $curso->update($request->all());

        return redirect()->route('cursos.index')
                         ->with('success', 'Curso actualizado exitosamente.');
    }

    public function destroy($id)
    {
        $curso = Curso::findOrFail($id);
        $curso->delete();

        return redirect()->route('cursos.index')
                         ->with('success', 'Curso eliminado exitosamente.');
    }
}
