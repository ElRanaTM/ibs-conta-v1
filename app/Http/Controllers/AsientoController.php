<?php

namespace App\Http\Controllers;

use App\Models\Asiento;
use App\Services\NumeracionService;
use Illuminate\Http\Request;

class AsientoController extends Controller
{
    public function index()
    {
        $asientos = Asiento::with(['usuario', 'detalleAsientos'])->latest()->paginate(15);
        return view('contabilidad.asientos.index', compact('asientos'));
    }

    public function create()
    {
        return view('contabilidad.asientos.create');
    }

    public function diario(Request $request)
    {
        $fechaDesde = $request->get('fecha_desde', date('Y-m-01'));
        $fechaHasta = $request->get('fecha_hasta', date('Y-m-d'));
        
        $asientos = Asiento::whereBetween('fecha', [$fechaDesde, $fechaHasta])
            ->with(['detalleAsientos.cuentaAnalitica'])
            ->orderBy('fecha')
            ->orderBy('numero_asiento')
            ->get();
            
        return view('contabilidad.asientos.diario', compact('asientos', 'fechaDesde', 'fechaHasta'));
    }

    public function edit($id)
    {
        $asiento = Asiento::with(['usuario', 'detalleAsientos.cuentaAnalitica'])->findOrFail($id);
        return view('contabilidad.asientos.edit', compact('asiento'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'fecha' => 'required|date',
            'glosa' => 'required|string',
            'estado' => 'boolean',
            'usuario_id' => 'required|exists:users,id',
            'detalle_asientos' => 'required|array|min:1',
            'detalle_asientos.*.cuenta_analitica_id' => 'required|exists:cuentas_analiticas,id',
            'detalle_asientos.*.debe' => 'required|numeric|min:0',
            'detalle_asientos.*.haber' => 'required|numeric|min:0',
            'detalle_asientos.*.glosa' => 'nullable|string',
        ]);

        // Validación adicional: al menos debe o haber debe ser mayor a 0
        foreach ($request->detalle_asientos as $index => $detalle) {
            $debe = floatval($detalle['debe'] ?? 0);
            $haber = floatval($detalle['haber'] ?? 0);
            
            if ($debe <= 0 && $haber <= 0) {
                return redirect()->back()->withErrors([
                    "detalle_asientos.$index.debe" => 'Debe o Haber debe ser mayor a 0',
                    "detalle_asientos.$index.haber" => 'Debe o Haber debe ser mayor a 0',
                ])->withInput();
            }
        }

        $numeroAsiento = NumeracionService::generarNumero('asiento', 'ASI');
        
        $asiento = Asiento::create([
            'fecha' => $request->fecha,
            'glosa' => $request->glosa,
            'estado' => $request->estado ?? true,
            'usuario_id' => $request->usuario_id,
            'numero_asiento' => $numeroAsiento,
            'serie' => 'ASI',
        ]);

        foreach ($request->detalle_asientos as $detalle) {
            // Convertir valores vacíos a 0
            $detalle['debe'] = floatval($detalle['debe'] ?? 0);
            $detalle['haber'] = floatval($detalle['haber'] ?? 0);
            
            $asiento->detalleAsientos()->create($detalle);
        }

        return redirect()->route('asientos.index')->with('success', 'Asiento creado exitosamente.');
    }

    public function update(Request $request, $id)
    {
        $asiento = Asiento::findOrFail($id);
        
        $request->validate([
            'fecha' => 'required|date',
            'glosa' => 'required|string',
            'estado' => 'boolean',
            'detalle_asientos' => 'array|min:1',
        ]);

        // Validación adicional para detalles si existen
        if ($request->has('detalle_asientos')) {
            foreach ($request->detalle_asientos as $index => $detalle) {
                $request->validate([
                    "detalle_asientos.$index.cuenta_analitica_id" => 'required|exists:cuentas_analiticas,id',
                    "detalle_asientos.$index.debe" => 'required|numeric|min:0',
                    "detalle_asientos.$index.haber" => 'required|numeric|min:0',
                    "detalle_asientos.$index.glosa" => 'nullable|string',
                ]);
                
                // Validar que al menos debe o haber sea mayor a 0
                $debe = floatval($detalle['debe'] ?? 0);
                $haber = floatval($detalle['haber'] ?? 0);
                
                if ($debe <= 0 && $haber <= 0) {
                    return redirect()->back()->withErrors([
                        "detalle_asientos.$index.debe" => 'Debe o Haber debe ser mayor a 0',
                        "detalle_asientos.$index.haber" => 'Debe o Haber debe ser mayor a 0',
                    ])->withInput();
                }
            }
        }

        $asiento->update($request->only(['fecha', 'glosa', 'estado']));

        if ($request->has('detalle_asientos')) {
            $asiento->detalleAsientos()->delete();
            foreach ($request->detalle_asientos as $detalle) {
                // Convertir valores vacíos a 0
                $detalle['debe'] = floatval($detalle['debe'] ?? 0);
                $detalle['haber'] = floatval($detalle['haber'] ?? 0);
                
                $asiento->detalleAsientos()->create($detalle);
            }
        }

        return redirect()->route('asientos.index')->with('success', 'Asiento actualizado exitosamente.');
    }

    public function show($id)
    {
        $asiento = Asiento::with(['usuario', 'detalleAsientos.cuentaAnalitica', 'detalleAsientos.metodoPago'])->findOrFail($id);
        return view('contabilidad.asientos.show', compact('asiento'));
    }



    public function destroy($id)
    {
        $asiento = Asiento::findOrFail($id);
        $asiento->delete();
        return redirect()->route('asientos.index')->with('success', 'Asiento eliminado exitosamente.');
    }
}

