<?php

namespace App\Http\Controllers;

use App\Models\Departamento;
use Illuminate\Http\Request;

class DepartamentoController extends Controller
{
    public function index()
    {
        $departamentos = Departamento::orderBy('id_departamento', 'desc')->get();
        return view('gestion.departamento', compact('departamentos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre_departamento' => 'required|string|max:100',
            'desc_departamento' => 'nullable|string',
            'cod_departamento' => 'required|string|max:20|unique:Departamento,cod_departamento',
        ]);

        Departamento::create([
            'nombre_departamento' => $request->nombre_departamento,
            'desc_departamento' => $request->desc_departamento,
            'cod_departamento' => $request->cod_departamento,
        ]);

        return redirect()->route('departamentos.index')
                         ->with('success', 'Departamento registrado exitosamente.');
    }

    public function update(Request $request, $id)
    {
        $departamento = Departamento::findOrFail($id);

        $request->validate([
            'nombre_departamento' => 'required|string|max:100',
            'desc_departamento' => 'nullable|string',
            'cod_departamento' => 'required|string|max:20|unique:Departamento,cod_departamento,' . $departamento->id_departamento . ',id_departamento',
        ]);

        $departamento->update([
            'nombre_departamento' => $request->nombre_departamento,
            'desc_departamento' => $request->desc_departamento,
            'cod_departamento' => $request->cod_departamento,
        ]);

        return redirect()->route('departamentos.index')
                         ->with('success', 'Departamento actualizado exitosamente.');
    }

    public function destroy($id)
    {
        $departamento = Departamento::findOrFail($id);
        $departamento->delete();

        return redirect()->route('departamentos.index')
                         ->with('success', 'Departamento eliminado exitosamente.');
    }
}
