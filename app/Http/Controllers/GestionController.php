<?php

namespace App\Http\Controllers;

use App\Models\Gestion;
use Illuminate\Http\Request;

class GestionController extends Controller
{
    public function index()
    {
        $gestiones = Gestion::orderBy('id_gestion', 'desc')->get();
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

        Gestion::create($request->all());

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
        $gestion->delete();
        
        return redirect()->route('gestiones.index')
                         ->with('success', 'Gestión eliminada exitosamente.');
    }
}