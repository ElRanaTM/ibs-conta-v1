@extends('layout.app')

@section('title', 'Libro Diario')

@section('page-title', 'Libro Diario')

@section('page-header')
<div class="flex items-center justify-between">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Libro Diario</h1>
        <p class="text-gray-600 mt-1">Registro cronológico de todos los asientos contables</p>
    </div>
    <div class="flex space-x-3">
        <a href="{{ route('reportes.libro-diario.pdf', ['fecha_desde' => $fechaDesde ?? date('Y-m-01'), 'fecha_hasta' => $fechaHasta ?? date('Y-m-d')]) }}" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
            <i class="fas fa-file-pdf mr-2"></i>Exportar PDF
        </a>
        <a href="{{ route('contabilidad.asientos.diario.export.csv', ['fecha_desde' => $fechaDesde ?? date('Y-m-01'), 'fecha_hasta' => $fechaHasta ?? date('Y-m-d')]) }}" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
            <i class="fas fa-file-excel mr-2"></i>Exportar Excel
        </a>
    </div>
</div>
@endsection

@section('content')
<div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
    <form method="GET" action="{{ route('contabilidad.asientos.diario') }}" class="flex flex-col md:flex-row md:items-end space-y-4 md:space-y-0 md:space-x-4">
        <div class="flex-1">
            <label for="fecha_desde" class="block text-sm font-medium text-gray-700 mb-2">Desde</label>
            <input type="date" id="fecha_desde" name="fecha_desde" value="{{ $fechaDesde ?? date('Y-m-01') }}"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-500">
        </div>
        <div class="flex-1">
            <label for="fecha_hasta" class="block text-sm font-medium text-gray-700 mb-2">Hasta</label>
            <input type="date" id="fecha_hasta" name="fecha_hasta" value="{{ $fechaHasta ?? date('Y-m-d') }}"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-500">
        </div>
        <div>
            <button type="submit" class="px-6 py-2 bg-gray-900 text-white rounded-lg hover:bg-gray-800 transition-colors">
                <i class="fas fa-search mr-2"></i>Buscar
            </button>
        </div>
    </form>
</div>

<div class="bg-white rounded-lg shadow-sm border border-gray-200">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Número</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Glosa</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cuenta</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Glosa</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Debe</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Haber</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($asientos as $asiento)
                    @foreach($asiento->detalleAsientos as $detalle)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $asiento->fecha->format('d/m/Y') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $asiento->numero_asiento }}</td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ Str::limit($asiento->glosa, 50) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ $detalle->cuentaAnalitica->codigo ?? 'N/A' }}</div>
                            <div class="text-sm text-gray-500">{{ $detalle->cuentaAnalitica->nombre ?? 'N/A' }}</div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $detalle->glosa ?? '-' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm text-gray-900">{{ number_format($detalle->debe, 2) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm text-gray-900">{{ number_format($detalle->haber, 2) }}</td>
                    </tr>
                    @endforeach
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                        <i class="fas fa-book text-4xl mb-3 text-gray-400"></i>
                        <p>No hay asientos registrados en el período seleccionado</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

