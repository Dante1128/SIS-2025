<?php

namespace App\Http\Controllers;

use App\Models\Area;
use Illuminate\Http\Request;

class AreaController extends Controller
{
    public function index()
    {
        $areas = Area::orderBy('id_area', 'desc')->get();
        return view('gestion.area', compact('areas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:50|unique:Area,nombre',
            'descripcion' => 'nullable|string|max:100',
        ]);

        Area::create([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
        ]);

        return redirect()->route('areas.index')
                         ->with('success', 'Área registrada exitosamente.');
    }

    public function update(Request $request, $id)
    {
        $area = Area::findOrFail($id);

        $request->validate([
            'nombre' => 'required|string|max:50|unique:Area,nombre,' . $area->id_area . ',id_area',
            'descripcion' => 'nullable|string|max:100',
        ]);

        $area->update([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
        ]);

        return redirect()->route('areas.index')
                         ->with('success', 'Área actualizada exitosamente.');
    }

    public function destroy($id)
    {
        $area = Area::findOrFail($id);
        $area->delete();

        return redirect()->route('areas.index')
                         ->with('success', 'Área eliminada exitosamente.');
    }
}
