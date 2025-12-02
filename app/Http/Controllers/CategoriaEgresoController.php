<?php

namespace App\Http\Controllers;

use App\Models\CategoriaEgreso;
use Illuminate\Http\Request;

class CategoriaEgresoController extends Controller
{
    public function index()
    {
        $categorias = CategoriaEgreso::all();
        return view('catalogos.categorias_egreso.index', compact('categorias'));
    }

    public function create()
    {
        return view('catalogos.categorias_egreso.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string',
            'descripcion' => 'nullable|string',
        ]);

        CategoriaEgreso::create($request->all());
        return redirect()->route('catalogos.categorias-egreso.index')->with('success', 'Categoría de egreso creada exitosamente.');
    }

    public function show($id)
    {
        $categoria = CategoriaEgreso::findOrFail($id);
        return response()->json($categoria);
    }

    public function edit($id)
    {
        $categoria = CategoriaEgreso::findOrFail($id);
        return view('catalogos.categorias_egreso.edit', compact('categoria'));
    }

    public function update(Request $request, $id)
    {
        $categoria = CategoriaEgreso::findOrFail($id);
        
        $request->validate([
            'nombre' => 'required|string',
            'descripcion' => 'nullable|string',
        ]);

        $categoria->update($request->all());
        return redirect()->route('catalogos.categorias-egreso.index')->with('success', 'Categoría de egreso actualizada exitosamente.');
    }

    public function destroy($id)
    {
        $categoria = CategoriaEgreso::findOrFail($id);
        $categoria->delete();
        return redirect()->route('catalogos.categorias-egreso.index')->with('success', 'Categoría de egreso eliminada exitosamente.');
    }
}
