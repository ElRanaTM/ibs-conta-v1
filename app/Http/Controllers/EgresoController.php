<?php

namespace App\Http\Controllers;

use App\Models\Egreso;
use App\Services\NumeracionService;
use Illuminate\Http\Request;

class EgresoController extends Controller
{
    public function index()
    {
        $egresos = Egreso::with(['proveedor', 'categoria', 'moneda'])->latest()->paginate(15);
        return view('egresos.index', compact('egresos'));
    }

    public function create()
    {
        return view('egresos.create');
    }

    public function edit($id)
    {
        $egreso = Egreso::with(['proveedor', 'categoria', 'moneda'])->findOrFail($id);
        return view('egresos.edit', compact('egreso'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_proveedor' => 'nullable|exists:proveedor,id_proveedor',
            'id_categoria' => 'nullable|exists:categoria_egreso,id_categoria',
            'fecha' => 'required|date',
            'monto' => 'required|numeric|min:0',
            'descripcion' => 'nullable|string',
            'id_moneda' => 'required|exists:moneda,id_moneda',
            'id_asiento' => 'nullable|exists:asientos,id',
        ]);

        // Generar número de comprobante usando el servicio
        $numeroComprobante = NumeracionService::generarNumero('egreso', 'EGR');

        $egreso = Egreso::create([
            'id_proveedor' => $request->id_proveedor,
            'id_categoria' => $request->id_categoria,
            'fecha' => $request->fecha,
            'monto' => $request->monto,
            'descripcion' => $request->descripcion,
            'id_moneda' => $request->id_moneda,
            'id_asiento' => $request->id_asiento,
            'numero_comprobante' => $numeroComprobante,
            'serie' => 'EGR',
        ]);

        return redirect()->route('egresos.index')->with('success', 'Egreso registrado exitosamente.');
    }

    public function show($id)
    {
        $egreso = Egreso::with(['proveedor', 'categoria', 'moneda', 'asiento'])->findOrFail($id);
        return view('egresos.show', compact('egreso'));
    }

    public function update(Request $request, $id)
    {
        $egreso = Egreso::findOrFail($id);
        
        $request->validate([
            'id_proveedor' => 'nullable|exists:proveedor,id_proveedor',
            'id_categoria' => 'nullable|exists:categoria_egreso,id_categoria',
            'fecha' => 'required|date',
            'monto' => 'required|numeric|min:0',
            'descripcion' => 'nullable|string',
            'id_moneda' => 'required|exists:moneda,id_moneda',
            'id_asiento' => 'nullable|exists:asientos,id',
        ]);

        $egreso->update($request->all());
        return redirect()->route('egresos.index')->with('success', 'Egreso actualizado exitosamente.');
    }

    public function destroy($id)
    {
        $egreso = Egreso::findOrFail($id);
        $egreso->delete();
        return redirect()->route('egresos.index')->with('success', 'Egreso eliminado exitosamente.');
    }
}

