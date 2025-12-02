<?php

namespace App\Http\Controllers;

use App\Models\Pago;
use App\Models\Alumno;
use App\Models\ConceptoIngreso;
use App\Models\PeriodoAcademico;
use App\Models\Moneda;
use App\Models\MetodoPago;
use App\Models\NumeracionDocumentos;
use App\Services\NumeracionService;
use App\Services\AsientoService;
use Illuminate\Http\Request;

class PagoController extends Controller
{
    public function index()
    {
        $pagos = Pago::with(['alumno', 'concepto', 'periodo', 'moneda', 'metodoPago'])->latest()->paginate(15);
        return view('ingresos.pagos.index', compact('pagos'));
    }

    public function create()
    {
        $alumnos = Alumno::all();
        $conceptos = ConceptoIngreso::all();
        $periodos = PeriodoAcademico::all();
        $monedas = Moneda::all();
        $metodos = MetodoPago::all();
        return view('ingresos.pagos.create', compact('alumnos', 'conceptos', 'periodos', 'monedas', 'metodos'));
    }

    public function edit($id)
    {
        $pago = Pago::with(['alumno', 'concepto', 'periodo', 'moneda', 'metodoPago'])->findOrFail($id);
        $alumnos = Alumno::all();
        $conceptos = ConceptoIngreso::all();
        $periodos = PeriodoAcademico::all();
        $monedas = Moneda::all();
        $metodos = MetodoPago::all();
        return view('ingresos.pagos.edit', compact('pago', 'alumnos', 'conceptos', 'periodos', 'monedas', 'metodos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_alumno' => 'required|exists:alumno,id_alumno',
            'id_concepto' => 'required|exists:concepto_ingreso,id_concepto',
            'fecha_pago' => 'required|date',
            'id_periodo' => 'required|exists:periodo_academico,id_periodo',
            'monto' => 'required|numeric|min:0',
            'id_moneda' => 'required|exists:moneda,id_moneda',
            'id_metodo_pago' => 'required|exists:metodo_pago,id',
            'referencia_pago' => 'nullable|string',
            'estado_pago' => 'in:pagado,pendiente,anulado',
            'id_asiento' => 'nullable|exists:asientos,id',
        ]);

        // Generar número de comprobante usando el servicio
        $numeroComprobante = NumeracionService::generarNumero('pago', 'PAG');
        
        // Obtener la numeración para el id_numeracion_documento
        $numeracion = NumeracionDocumentos::where('tipo_documento', 'pago')
            ->where('serie', 'PAG')
            ->where('activo', true)
            ->firstOrFail();

        $pago = Pago::create([
            'id_alumno' => $request->id_alumno,
            'id_concepto' => $request->id_concepto,
            'fecha_pago' => $request->fecha_pago,
            'id_periodo' => $request->id_periodo,
            'monto' => $request->monto,
            'id_moneda' => $request->id_moneda,
            'id_metodo_pago' => $request->id_metodo_pago,
            'referencia_pago' => $request->referencia_pago,
            'estado_pago' => $request->estado_pago ?? 'pagado',
            'id_asiento' => $request->id_asiento,
            'numero_comprobante' => $numeroComprobante,
            'serie' => 'PAG',
            'id_numeracion_documento' => $numeracion->id,
        ]);

        // Crear asiento automático
        AsientoService::crearAsientoPago($pago);

        return redirect()->route('pagos.index')->with('success', 'Pago registrado exitosamente con asiento contable generado.');
    }

    public function show($id)
    {
        $pago = Pago::with(['alumno', 'concepto', 'periodo', 'moneda', 'metodoPago', 'asiento'])->findOrFail($id);
        return view('ingresos.pagos.show', compact('pago'));
    }

    public function update(Request $request, $id)
    {
        $pago = Pago::findOrFail($id);
        $datosAnteriores = $pago->toArray();
        
        $request->validate([
            'id_alumno' => 'required|exists:alumno,id_alumno',
            'id_concepto' => 'required|exists:concepto_ingreso,id_concepto',
            'fecha_pago' => 'required|date',
            'id_periodo' => 'required|exists:periodo_academico,id_periodo',
            'monto' => 'required|numeric|min:0',
            'id_moneda' => 'required|exists:moneda,id_moneda',
            'id_metodo_pago' => 'required|exists:metodo_pago,id',
            'referencia_pago' => 'nullable|string',
            'estado_pago' => 'in:pagado,pendiente,anulado',
            'id_asiento' => 'nullable|exists:asientos,id',
        ]);

        $pago->update($request->all());
        
        // Actualizar asiento automático
        AsientoService::actualizarAsientoPago($pago, $datosAnteriores);

        return redirect()->route('pagos.index')->with('success', 'Pago actualizado exitosamente.');
    }

    public function destroy($id)
    {
        $pago = Pago::findOrFail($id);
        
        // Eliminar asiento asociado
        if ($pago->id_asiento) {
            AsientoService::eliminarAsiento($pago->id_asiento);
        }
        
        $pago->delete();
        return redirect()->route('pagos.index')->with('success', 'Pago eliminado exitosamente.');
    }
}
