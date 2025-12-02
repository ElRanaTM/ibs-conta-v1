@extends('layout.app')

@section('title', 'Sumas y Saldos')

@section('page-title', 'Sumas y Saldos')

@section('page-header')
<div class="flex items-center justify-between">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Sumas y Saldos</h1>
        <p class="text-gray-600 mt-1">Resumen de movimientos contables por cuenta</p>
    </div>
    <div class="flex space-x-3">
        <a href="{{ route('sumas-saldos.export.print', ['fecha_desde' => $fechaDesde ?? date('Y-m-01'), 'fecha_hasta' => $fechaHasta ?? date('Y-m-d')]) }}" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
            <i class="fas fa-file-pdf mr-2"></i>Exportar PDF
        </a>
        <a href="{{ route('sumas-saldos.export.csv', ['fecha_desde' => $fechaDesde ?? date('Y-m-01'), 'fecha_hasta' => $fechaHasta ?? date('Y-m-d')]) }}" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
            <i class="fas fa-file-excel mr-2"></i>Exportar Excel
        </a>
    </div>
</div>
@endsection

@section('content')
<div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
    <form method="GET" class="flex flex-col md:flex-row md:items-end space-y-4 md:space-y-0 md:space-x-4">
        <div class="flex-1">
            <label for="fecha_desde" class="block text-sm font-medium text-gray-700 mb-2">Desde</label>
            <input type="date" name="fecha_desde" id="fecha_desde" value="{{ $fechaDesde }}"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-500">
        </div>
        <div class="flex-1">
            <label for="fecha_hasta" class="block text-sm font-medium text-gray-700 mb-2">Hasta</label>
            <input type="date" name="fecha_hasta" id="fecha_hasta" value="{{ $fechaHasta }}"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-500">
        </div>
        <div>
            <button type="submit" class="px-6 py-2 bg-gray-900 text-white rounded-lg hover:bg-gray-800 transition-colors">
                <i class="fas fa-search mr-2"></i>Generar Reporte
            </button>
        </div>
    </form>
</div>

<div class="bg-white rounded-lg shadow-sm border border-gray-200">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Código Cuenta</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cuenta</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Debe</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Haber</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Deudor</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Acreedor</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Egreso</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Ingreso</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Activo</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Pasivo</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($sumasSaldos as $item)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $item['codigo'] }}</td>
                    <td class="px-6 py-4 text-sm text-gray-900">{{ $item['cuenta'] }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-right">{{ number_format($item['debe'], 2) }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-right">{{ number_format($item['haber'], 2) }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-right">{{ number_format($item['deudor'], 2) }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-right">{{ number_format($item['acreedor'], 2) }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-right">{{ number_format($item['egreso'], 2) }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-right">{{ number_format($item['ingreso'], 2) }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-right">{{ number_format($item['activo'], 2) }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-right">{{ number_format($item['pasivo'], 2) }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="10" class="px-6 py-12 text-center text-gray-500">
                        <i class="fas fa-table text-4xl mb-3 text-gray-400"></i>
                        <p>No hay datos para mostrar</p>
                        <p class="text-sm text-gray-400 mt-2">Selecciona un rango de fechas y genera el reporte</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
            @if($sumasSaldos->count() > 0)
            <tfoot class="bg-gray-50">
                <tr>
                    <td colspan="2" class="px-6 py-3 text-right text-sm font-semibold text-gray-900">TOTALES:</td>
                    <td class="px-6 py-3 text-right text-sm font-semibold text-gray-900">{{ number_format($sumasSaldos->sum('debe'), 2) }}</td>
                    <td class="px-6 py-3 text-right text-sm font-semibold text-gray-900">{{ number_format($sumasSaldos->sum('haber'), 2) }}</td>
                    <td class="px-6 py-3 text-right text-sm font-semibold text-gray-900">{{ number_format($sumasSaldos->sum('deudor'), 2) }}</td>
                    <td class="px-6 py-3 text-right text-sm font-semibold text-gray-900">{{ number_format($sumasSaldos->sum('acreedor'), 2) }}</td>
                    <td class="px-6 py-3 text-right text-sm font-semibold text-gray-900">{{ number_format($sumasSaldos->sum('egreso'), 2) }}</td>
                    <td class="px-6 py-3 text-right text-sm font-semibold text-gray-900">{{ number_format($sumasSaldos->sum('ingreso'), 2) }}</td>
                    <td class="px-6 py-3 text-right text-sm font-semibold text-gray-900">{{ number_format($sumasSaldos->sum('activo'), 2) }}</td>
                    <td class="px-6 py-3 text-right text-sm font-semibold text-gray-900">{{ number_format($sumasSaldos->sum('pasivo'), 2) }}</td>
                </tr>
            </tfoot>
            @endif
        </table>
    </div>
</div>
@endsection

