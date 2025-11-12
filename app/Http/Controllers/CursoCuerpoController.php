<?php

namespace App\Http\Controllers;

use App\Models\CursoCuerpo;
use App\Models\Curso;
use Illuminate\Http\Request;

class CursoCuerpoController extends Controller
{
    public function index()
    {
        $cursosCuerpo = CursoCuerpo::with('curso')->orderBy('id_curso_cuerpo', 'desc')->get();
        $cursos = Curso::orderBy('nombre_curso')->get();

        return view('gestion.cursoCuerpo', compact('cursosCuerpo', 'cursos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_curso' => 'required|exists:Curso,id_curso',
            'criterio_desempeno' => 'nullable|string',
            'unidad_didactica' => 'nullable|string',
            'react_desarrollo' => 'nullable|string',
            'react_evaluacion' => 'nullable|string',
            'cargah_teoria' => 'nullable|integer|min:0',
            'cargah_practica' => 'nullable|integer|min:0',
            'cargah_laboratorio' => 'nullable|integer|min:0',
            'porc_eval_ateorico' => 'nullable|numeric|min:0|max:100',
            'porc_eval_apractico' => 'nullable|numeric|min:0|max:100',
            'porc_eval_alaboratorio' => 'nullable|numeric|min:0|max:100',
            'pond_global_udidactica' => 'nullable|numeric|min:0|max:100',
            'semanas' => 'nullable|string|max:20',
        ]);

        CursoCuerpo::create($request->all());

        return redirect()->route('cursocuerpo.index')
                         ->with('success', 'Estructura del curso registrada exitosamente.');
    }

    public function update(Request $request, $id)
    {
        $cursoCuerpo = CursoCuerpo::findOrFail($id);

        $request->validate([
            'id_curso' => 'required|exists:Curso,id_curso',
            'criterio_desempeno' => 'nullable|string',
            'unidad_didactica' => 'nullable|string',
            'react_desarrollo' => 'nullable|string',
            'react_evaluacion' => 'nullable|string',
            'cargah_teoria' => 'nullable|integer|min:0',
            'cargah_practica' => 'nullable|integer|min:0',
            'cargah_laboratorio' => 'nullable|integer|min:0',
            'porc_eval_ateorico' => 'nullable|numeric|min:0|max:100',
            'porc_eval_apractico' => 'nullable|numeric|min:0|max:100',
            'porc_eval_alaboratorio' => 'nullable|numeric|min:0|max:100',
            'pond_global_udidactica' => 'nullable|numeric|min:0|max:100',
            'semanas' => 'nullable|string|max:20',
        ]);

        $cursoCuerpo->update($request->all());

        return redirect()->route('cursocuerpo.index')
                         ->with('success', 'Estructura del curso actualizada exitosamente.');
    }

    public function destroy($id)
    {
        $cursoCuerpo = CursoCuerpo::findOrFail($id);
        $cursoCuerpo->delete();

        return redirect()->route('cursocuerpo.index')
                         ->with('success', 'Estructura del curso eliminada exitosamente.');
    }
}
