<?php

namespace App\Http\Controllers;

use App\Models\Asiento;
use App\Services\NumeracionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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

    // Toggle estado vía POST
    public function toggle($id)
    {
        $asiento = Asiento::findOrFail($id);
        $asiento->estado = !$asiento->estado;
        $asiento->save();

        return redirect()->back();
    }

    // Export CSV for libro diario
    public function exportCsv(Request $request)
    {
        $fechaDesde = $request->get('fecha_desde', date('Y-m-01'));
        $fechaHasta = $request->get('fecha_hasta', date('Y-m-d'));

        $asientos = Asiento::whereBetween('fecha', [$fechaDesde, $fechaHasta])
            ->with(['detalleAsientos.cuentaAnalitica'])
            ->orderBy('fecha')
            ->orderBy('numero_asiento')
            ->get();

        $filename = "libro_diario_{$fechaDesde}_{$fechaHasta}.csv";
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function () use ($asientos) {
            $out = fopen('php://output', 'w');
            fputcsv($out, ['Fecha', 'Numero', 'Glosa Asiento', 'Cuenta Codigo', 'Cuenta Nombre', 'Glosa Detalle', 'Debe', 'Haber']);

            foreach ($asientos as $asiento) {
                foreach ($asiento->detalleAsientos as $detalle) {
                    fputcsv($out, [
                        $asiento->fecha->format('Y-m-d'),
                        $asiento->numero_asiento,
                        $asiento->glosa,
                        $detalle->cuentaAnalitica->codigo ?? '',
                        $detalle->cuentaAnalitica->nombre ?? '',
                        $detalle->glosa ?? '',
                        number_format($detalle->debe, 2, '.', ''),
                        number_format($detalle->haber, 2, '.', ''),
                    ]);
                }
            }

            fclose($out);
        };

        return response()->stream($callback, 200, $headers);
    }

    // Printable view (HTML) for PDF printing by browser
    public function exportPrint(Request $request)
    {
        $fechaDesde = $request->get('fecha_desde', date('Y-m-01'));
        $fechaHasta = $request->get('fecha_hasta', date('Y-m-d'));

        $asientos = Asiento::whereBetween('fecha', [$fechaDesde, $fechaHasta])
            ->with(['detalleAsientos.cuentaAnalitica'])
            ->orderBy('fecha')
            ->orderBy('numero_asiento')
            ->get();

        return view('contabilidad.asientos.diario-print', compact('asientos', 'fechaDesde', 'fechaHasta'));
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

        //$numeroAsiento = NumeracionService::generarNumero('asiento', 'ASI');
        $ultimoAsiento = Asiento::latest('id')->first();
        $ultimoNumero = $ultimoAsiento ? (int) preg_replace('/[^0-9]/', '', $ultimoAsiento->numero_asiento) : 0;
        $nuevoNumero = $ultimoNumero + 1;
        $numeroAsiento = 'ASI-' . str_pad($nuevoNumero, 6, '0', STR_PAD_LEFT);
        
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

        return redirect()->route('contabilidad.asientos.index')->with('success', 'Asiento creado exitosamente.');
    }

/*
public function store(Request $request)
    {
        Log::info('=== ASIENTO STORE INICIADO ===');
        Log::info('Request data:', $request->all());
        Log::info('Headers:', $request->headers->all());
        
        try {
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
            
            Log::info('Validación pasada');
            
            // Validación adicional: al menos debe o haber debe ser mayor a 0
            foreach ($request->detalle_asientos as $index => $detalle) {
                Log::info("Detalle $index:", $detalle);
                $debe = floatval($detalle['debe'] ?? 0);
                $haber = floatval($detalle['haber'] ?? 0);
                
                if ($debe <= 0 && $haber <= 0) {
                    Log::warning("Detalle $index: Debe y Haber son 0 o menores");
                    return redirect()->back()->withErrors([
                        "detalle_asientos.$index.debe" => 'Debe o Haber debe ser mayor a 0',
                        "detalle_asientos.$index.haber" => 'Debe o Haber debe ser mayor a 0',
                    ])->withInput();
                }
            }

            Log::info('Generando número de asiento...');
            //$numeroAsiento = NumeracionService::generarNumero('asiento', 'ASI');
            $ultimoAsiento = Asiento::latest('id')->first();
    $ultimoNumero = $ultimoAsiento ? (int) preg_replace('/[^0-9]/', '', $ultimoAsiento->numero_asiento) : 0;
    $nuevoNumero = $ultimoNumero + 1;
    $numeroAsiento = 'ASI-' . str_pad($nuevoNumero, 6, '0', STR_PAD_LEFT);
            Log::info("Número asiento: $numeroAsiento");
            
            $asiento = Asiento::create([
                'fecha' => $request->fecha,
                'glosa' => $request->glosa,
                'estado' => $request->estado ?? true,
                'usuario_id' => $request->usuario_id,
                'numero_asiento' => $numeroAsiento,
                'serie' => 'ASI',
            ]);
            
            Log::info('Asiento creado:', $asiento->toArray());

            foreach ($request->detalle_asientos as $index => $detalle) {
                // Convertir valores vacíos a 0
                $detalle['debe'] = floatval($detalle['debe'] ?? 0);
                $detalle['haber'] = floatval($detalle['haber'] ?? 0);
                
                Log::info("Creando detalle $index:", $detalle);
                $detalleCreado = $asiento->detalleAsientos()->create($detalle);
                Log::info("Detalle $index creado:", $detalleCreado->toArray());
            }

            Log::info('=== ASIENTO CREADO EXITOSAMENTE ===');
            return redirect()->route('contabilidad.asientos.index')->with('success', 'Asiento creado exitosamente.');
            
        } catch (\Exception $e) {
            Log::error('Error en store:', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return redirect()->back()
                ->withErrors(['error' => 'Error al crear asiento: ' . $e->getMessage()])
                ->withInput();
        }
    }
    */
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

        return redirect()->route('contabilidad.asientos.index')->with('success', 'Asiento actualizado exitosamente.');
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
        return redirect()->route('contabilidad.asientos.index')->with('success', 'Asiento eliminado exitosamente.');
    }
}

