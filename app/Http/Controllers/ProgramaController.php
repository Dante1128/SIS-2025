<?php

namespace App\Http\Controllers;

use App\Models\Programa;
use App\Models\Departamento;
use App\Models\Gestion;
use Illuminate\Http\Request;

class ProgramaController extends Controller
{
    public function index()
    {
        $programas = Programa::with(['departamento', 'gestion'])
                             ->orderBy('id_programa', 'desc')
                             ->get();

        $departamentos = Departamento::orderBy('nombre_departamento')->get();
        $gestiones = Gestion::orderBy('fecha_inicio', 'desc')->get();

        return view('gestion.programa', compact('programas', 'departamentos', 'gestiones'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_departamento' => 'required|exists:Departamento,id_departamento',
            'id_gestion' => 'required|exists:Gestion,id_gestion',
            'cod_programa' => 'required|string|max:20|unique:Programa,cod_programa',
            'nombre_programa' => 'required|string|max:150',
            'num_resolucion' => 'nullable|string|max:20',
        ]);

        Programa::create($request->all());

        return redirect()->route('programas.index')
                         ->with('success', 'Programa registrado exitosamente.');
    }

    public function update(Request $request, $id)
    {
        $programa = Programa::findOrFail($id);

        $request->validate([
            'id_departamento' => 'required|exists:Departamento,id_departamento',
            'id_gestion' => 'required|exists:Gestion,id_gestion',
            'cod_programa' => 'required|string|max:20|unique:Programa,cod_programa,' . $programa->id_programa . ',id_programa',
            'nombre_programa' => 'required|string|max:150',
            'num_resolucion' => 'nullable|string|max:20',
        ]);

        $programa->update($request->all());

        return redirect()->route('programas.index')
                         ->with('success', 'Programa actualizado exitosamente.');
    }

    public function destroy($id)
    {
        $programa = Programa::findOrFail($id);
        $programa->delete();

        return redirect()->route('programas.index')
                         ->with('success', 'Programa eliminado exitosamente.');
    }
}
