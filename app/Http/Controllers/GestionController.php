<?php

namespace App\Http\Controllers;

use App\Models\Gestion;
use Illuminate\Http\Request;

class GestionController extends Controller
{
    public function index()
    {
        $gestiones = Gestion::where('estado', 1)->orderBy('id_gestion', 'desc')->get();
        return view('gestion.gestion', compact('gestiones'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'num_resolucion' => 'required|string|max:20',
            'desc_gestion' => 'nullable|string|max:255',
            'fecha_inicio' => 'required|date',
            'fecha_final' => 'required|date|after_or_equal:fecha_inicio',
        ]);

        $gestion = new Gestion();
        $gestion->num_resolucion = $request->num_resolucion;
        $gestion->desc_gestion = $request->desc_gestion;
        $gestion->fecha_inicio = $request->fecha_inicio;
        $gestion->fecha_final = $request->fecha_final;
        $gestion->estado = 1;
        $gestion->save();

        return redirect()->route('gestiones.index')
            ->with('success', 'Gestión creada exitosamente.');
    }

    public function update(Request $request, $id)
    {
        $gestion = Gestion::findOrFail($id);

        $request->validate([
            'num_resolucion' => 'required|string|max:20',
            'desc_gestion' => 'nullable|string|max:255',
            'fecha_inicio' => 'required|date',
            'fecha_final' => 'required|date|after_or_equal:fecha_inicio',
        ]);

        $gestion->update($request->all());

        return redirect()->route('gestiones.index')
            ->with('success', 'Gestión actualizada exitosamente.');
    }

    public function destroy($id)
    {
        $gestion = Gestion::findOrFail($id);
        $gestion->update(['estado' => 0]);

        return redirect()->route('gestiones.index')
            ->with('success', 'Gestión eliminada exitosamente.');
    }
}
