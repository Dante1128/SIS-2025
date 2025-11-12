<?php

namespace App\Http\Controllers;

use App\Models\Bibliografia;
use App\Models\Curso;
use Illuminate\Http\Request;

class BibliografiaController extends Controller
{
    public function index()
    {
        $bibliografias = Bibliografia::with('curso')->orderBy('id_biblio', 'desc')->get();
        $cursos = Curso::orderBy('nombre_curso')->get();

        return view('gestion.bibliografia', compact('bibliografias', 'cursos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_curso' => 'required|exists:Curso,id_curso',
            'autor' => 'required|string|max:100',
            'anio' => 'nullable|integer|min:1900|max:' . date('Y'),
            'titulo' => 'required|string|max:200',
            'editorial' => 'nullable|string|max:50',
            'id_edicion' => 'nullable|integer|min:1',
            'pais_ciudad' => 'nullable|string|max:100',
        ]);

        Bibliografia::create($request->all());

        return redirect()->route('bibliografia.index')
                         ->with('success', 'Bibliografía registrada exitosamente.');
    }

    public function update(Request $request, $id)
    {
        $bibliografia = Bibliografia::findOrFail($id);

        $request->validate([
            'id_curso' => 'required|exists:Curso,id_curso',
            'autor' => 'required|string|max:100',
            'anio' => 'nullable|integer|min:1900|max:' . date('Y'),
            'titulo' => 'required|string|max:200',
            'editorial' => 'nullable|string|max:50',
            'id_edicion' => 'nullable|integer|min:1',
            'pais_ciudad' => 'nullable|string|max:100',
        ]);

        $bibliografia->update($request->all());

        return redirect()->route('bibliografia.index')
                         ->with('success', 'Bibliografía actualizada exitosamente.');
    }

    public function destroy($id)
    {
        $bibliografia = Bibliografia::findOrFail($id);
        $bibliografia->delete();

        return redirect()->route('bibliografia.index')
                         ->with('success', 'Bibliografía eliminada exitosamente.');
    }
}
