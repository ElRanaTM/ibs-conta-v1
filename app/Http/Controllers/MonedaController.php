<?php

namespace App\Http\Controllers;

use App\Models\Moneda;
use Illuminate\Http\Request;

class MonedaController extends Controller
{
    public function index()
    {
        $monedas = Moneda::all();
        return response()->json($monedas);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string',
            'abreviatura' => 'required|string|max:5',
            'simbolo' => 'required|string|max:5',
            'es_local' => 'boolean',
        ]);

        $moneda = Moneda::create($request->all());
        return response()->json($moneda, 201);
    }

    public function show($id)
    {
        $moneda = Moneda::findOrFail($id);
        return response()->json($moneda);
    }

    public function update(Request $request, $id)
    {
        $moneda = Moneda::findOrFail($id);
        
        $request->validate([
            'nombre' => 'required|string',
            'abreviatura' => 'required|string|max:5',
            'simbolo' => 'required|string|max:5',
            'es_local' => 'boolean',
        ]);

        $moneda->update($request->all());
        return response()->json($moneda);
    }

    public function destroy($id)
    {
        $moneda = Moneda::findOrFail($id);
        $moneda->delete();
        return response()->json(null, 204);
    }
}

