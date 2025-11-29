<?php

namespace App\Http\Controllers;

use App\Models\CategoriaEgreso;
use Illuminate\Http\Request;

class CategoriaEgresoController extends Controller
{
    public function index()
    {
        $categorias = CategoriaEgreso::all();
        return response()->json($categorias);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string',
            'descripcion' => 'nullable|string',
        ]);

        $categoria = CategoriaEgreso::create($request->all());
        return response()->json($categoria, 201);
    }

    public function show($id)
    {
        $categoria = CategoriaEgreso::findOrFail($id);
        return response()->json($categoria);
    }

    public function update(Request $request, $id)
    {
        $categoria = CategoriaEgreso::findOrFail($id);
        
        $request->validate([
            'nombre' => 'required|string',
            'descripcion' => 'nullable|string',
        ]);

        $categoria->update($request->all());
        return response()->json($categoria);
    }

    public function destroy($id)
    {
        $categoria = CategoriaEgreso::findOrFail($id);
        $categoria->delete();
        return response()->json(null, 204);
    }
}

