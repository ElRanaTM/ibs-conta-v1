<?php

namespace App\Http\Controllers;

use App\Models\MetodoPago;
use Illuminate\Http\Request;

class MetodoPagoController extends Controller
{
    public function index()
    {
        $metodos = MetodoPago::all();
        return view('catalogos.metodos_pago.index', compact('metodos'));
    }

    public function create()
    {
        return view('catalogos.metodos_pago.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string',
            'descripcion' => 'nullable|string',
        ]);

        MetodoPago::create($request->all());
        return redirect()->route('catalogos.metodos-pago.index')->with('success', 'Método de pago creado exitosamente.');
    }

    public function show($id)
    {
        $metodo = MetodoPago::findOrFail($id);
        return response()->json($metodo);
    }

    public function edit($id)
    {
        $metodo = MetodoPago::findOrFail($id);
        return view('catalogos.metodos_pago.edit', compact('metodo'));
    }

    public function update(Request $request, $id)
    {
        $metodo = MetodoPago::findOrFail($id);
        
        $request->validate([
            'nombre' => 'required|string',
            'descripcion' => 'nullable|string',
        ]);

        $metodo->update($request->all());
        return redirect()->route('catalogos.metodos-pago.index')->with('success', 'Método de pago actualizado exitosamente.');
    }

    public function destroy($id)
    {
        $metodo = MetodoPago::findOrFail($id);
        $metodo->delete();
        return redirect()->route('catalogos.metodos-pago.index')->with('success', 'Método de pago eliminado exitosamente.');
    }
}

