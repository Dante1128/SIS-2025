<?php

namespace App\Http\Controllers;

use App\Models\Gestion;
use Illuminate\Http\Request;

class GestionController extends Controller
{
    public function index()
    {
        $gestiones = Gestion::orderBy('id_gestion', 'desc')->paginate(10);
        return view('gestion.gestion', compact('gestiones'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'num_resolucion' => 'required|string|max:20',
            'desc_gestion' => 'nullable|string',
            'fecha_inicio' => 'required|date',
            'fecha_final' => 'required|date|after_or_equal:fecha_inicio',
        ]);

        Gestion::create($request->all());

        return redirect()->route('gestiones.index')
                         ->with('success', 'Gestión creada exitosamente.');
    }

    public function edit(Gestion $gestione)
    {
        $gestiones = Gestion::orderBy('id_gestion', 'desc')->paginate(10);
        
        return view('gestion.gestion', [
            'gestiones' => $gestiones,
            'gestionToEdit' => $gestione
        ]);
    }

    public function update(Request $request, Gestion $gestione)
    {
        $request->validate([
            'num_resolucion' => 'required|string|max:20',
            'desc_gestion' => 'nullable|string',
            'fecha_inicio' => 'required|date',
            'fecha_final' => 'required|date|after_or_equal:fecha_inicio',
        ]);

        $gestione->update($request->all());

        return redirect()->route('gestiones.index')
                         ->with('success', 'Gestión actualizada exitosamente.');
    }

    public function destroy(Gestion $gestione)
    {
        $gestione->delete();
        
        return redirect()->route('gestiones.index')
                         ->with('success', 'Gestión eliminada exitosamente.');
    }
}