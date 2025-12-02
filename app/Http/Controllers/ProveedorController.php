<?php

namespace App\Http\Controllers;

use App\Models\Proveedor;
use Illuminate\Http\Request;

class ProveedorController extends Controller
{
    public function index()
    {
        $proveedores = Proveedor::all();
        return view('catalogos.proveedores.index', compact('proveedores'));
    }

    public function create()
    {
        return view('catalogos.proveedores.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string',
            'nit' => 'nullable|string',
            'telefono' => 'nullable|string',
            'direccion' => 'nullable|string',
        ]);

        Proveedor::create($request->all());
        return redirect()->route('catalogos.proveedores.index')->with('success', 'Proveedor creado exitosamente.');
    }

    public function show($id)
    {
        $proveedor = Proveedor::findOrFail($id);
        return response()->json($proveedor);
    }

    public function edit($id)
    {
        $proveedor = Proveedor::findOrFail($id);
        return view('catalogos.proveedores.edit', compact('proveedor'));
    }

    public function update(Request $request, $id)
    {
        $proveedor = Proveedor::findOrFail($id);
        
        $request->validate([
            'nombre' => 'required|string',
            'nit' => 'nullable|string',
            'telefono' => 'nullable|string',
            'direccion' => 'nullable|string',
        ]);

        $proveedor->update($request->all());
        return redirect()->route('catalogos.proveedores.index')->with('success', 'Proveedor actualizado exitosamente.');
    }

    public function destroy($id)
    {
        $proveedor = Proveedor::findOrFail($id);
        $proveedor->delete();
        return redirect()->route('catalogos.proveedores.index')->with('success', 'Proveedor eliminado exitosamente.');
    }
}
