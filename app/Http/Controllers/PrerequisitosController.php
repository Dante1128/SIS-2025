<?php

namespace App\Http\Controllers;

use App\Models\Prerequisitos;
use App\Models\Curso;
use Illuminate\Http\Request;

class PrerequisitosController extends Controller
{
    public function index()
    {
        $prerequisitos = Prerequisitos::with('curso')->orderBy('id_prerequisitos', 'desc')->get();
        $cursos = Curso::orderBy('nombre_curso')->get();

        return view('gestion.prerequisitos', compact('prerequisitos', 'cursos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_curso' => 'required|exists:Curso,id_curso',
            'desc_prerequisito' => 'required|string|max:100',
        ]);

        Prerequisitos::create($request->all());

        return redirect()->route('prerequisitos.index')
                         ->with('success', 'Prerequisito registrado exitosamente.');
    }

    public function update(Request $request, $id)
    {
        $prerequisito = Prerequisitos::findOrFail($id);

        $request->validate([
            'id_curso' => 'required|exists:Curso,id_curso',
            'desc_prerequisito' => 'required|string|max:100',
        ]);

        $prerequisito->update($request->all());

        return redirect()->route('prerequisitos.index')
                         ->with('success', 'Prerequisito actualizado exitosamente.');
    }

    public function destroy($id)
    {
        $prerequisito = Prerequisitos::findOrFail($id);
        $prerequisito->delete();

        return redirect()->route('prerequisitos.index')
                         ->with('success', 'Prerequisito eliminado exitosamente.');
    }
}
