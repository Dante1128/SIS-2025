<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dominio;
use App\Models\Subdominio;

class DominioSubdominioController extends Controller
{
    public function index()
    {
        $dominios = Dominio::with('subdominios')->get();
        return view('dominioSubdominio.dominioSubDominio', compact('dominios'));
    }

    public function storeDominio(Request $request)
    {
        $request->validate([
            'descripcion_dominio' => 'required|max:150'
        ]);

        Dominio::create([
            'descripcion' => $request->descripcion_dominio,
            'estado' => true, 
        ]);

        return back()->with('success', 'Dominio registrado correctamente');
    }

    public function storeSubdominio(Request $request)
    {
        $request->validate([
            'descripcion_subdominio' => 'required|max:150',
            'id_dominio' => 'required|exists:dominio,id_dominio',
        ]);

        Subdominio::create([
            'descripcion' => $request->descripcion_subdominio,
            'id_dominio' => $request->id_dominio,
            'estado' => true, 
        ]);

        return back()->with('success', 'Subdominio registrado correctamente');
    }


    public function editDominio($id)
    {
        $dominio = Dominio::findOrFail($id);
        return view('dominioSubdominio.editDominio', compact('dominio'));
    }

    public function updateDominio(Request $request, $id)
    {
        $request->validate([
            'descripcion' => 'required|max:150',
        ]);

        $dominio = Dominio::findOrFail($id);
        $dominio->update([
            'descripcion' => $request->descripcion,
        ]);

        return redirect()->route('dominioSubdominio')->with('success', 'Dominio actualizado correctamente');
    }

    public function toggleDominio($id)
    {
        $dominio = Dominio::findOrFail($id);
        $dominio->estado = !$dominio->estado;
        $dominio->save();

        return back()->with('success', 'Estado del dominio actualizado');
    }


    public function editSubdominio($id)
    {
        $subdominio = Subdominio::findOrFail($id);
        $dominios = Dominio::all(); 
        return view('dominioSubdominio.editSubdominio', compact('subdominio', 'dominios'));
    }

    public function updateSubdominio(Request $request, $id)
    {
        $request->validate([
            'descripcion' => 'required|max:150',
            'id_dominio' => 'required|exists:dominio,id_dominio',
        ]);

        $subdominio = Subdominio::findOrFail($id);
        $subdominio->update([
            'descripcion' => $request->descripcion,
            'id_dominio' => $request->id_dominio,
        ]);

        return redirect()->route('dominioSubdominio')->with('success', 'Subdominio actualizado correctamente');
    }
    public function toggleSubdominio($id)
    {
        $subdominio = Subdominio::findOrFail($id);
        $subdominio->estado = !$subdominio->estado;
        $subdominio->save();

        return back()->with('success', 'Estado del subdominio actualizado');
    }
}
