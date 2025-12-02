<?php

namespace App\Http\Controllers;

use App\Models\Moneda;
use Illuminate\Http\Request;

class MonedaController extends Controller
{
    public function index()
    {
        $monedas = Moneda::latest()->paginate(15);
        return view('catalogos.monedas.index', compact('monedas'));
    }

    public function create()
    {
        return view('catalogos.monedas.create');
    }

    public function edit($id)
    {
        $moneda = Moneda::findOrFail($id);
        return view('catalogos.monedas.edit', compact('moneda'));
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
        return redirect()->route('catalogos.monedas.index')->with('success', 'Moneda creada exitosamente.');
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
        return redirect()->route('catalogos.monedas.index')->with('success', 'Moneda actualizada exitosamente.');
    }

    public function destroy($id)
    {
        $moneda = Moneda::findOrFail($id);
        $moneda->delete();
        return redirect()->route('catalogos.monedas.index')->with('success', 'Moneda eliminada exitosamente.');
    }
}