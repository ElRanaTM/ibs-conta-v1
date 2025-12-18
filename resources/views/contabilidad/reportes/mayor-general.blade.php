@extends('layout.app')

@section('title', 'Mayor General')

@section('page-title', 'Mayor General')

@section('page-header')
<div class="flex items-center justify-between">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Mayor General</h1>
        <p class="text-gray-600 mt-1">Movimientos detallados por cuenta</p>
    </div>
        <div class="flex space-x-3">
        <a href="{{ route('reportes.mayor-general.pdf', ['cuenta_id' => request()->get('cuenta_id'), 'fecha_desde' => request()->get('fecha_desde', date('Y-m-01')), 'fecha_hasta' => request()->get('fecha_hasta', date('Y-m-d'))]) }}" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">Exportar PDF</a>
        <!-- <a href="{{ route('reportes.mayor-general', ['fecha_desde' => request()->get('fecha_desde', date('Y-m-01')), 'fecha_hasta' => request()->get('fecha_hasta', date('Y-m-d'))]) }}" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">Exportar Excel</a> -->
    </div>
</div>
@endsection

@section('content')
<div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
    <form class="flex flex-col md:flex-row md:items-end space-y-4 md:space-y-0 md:space-x-4">
        <div class="flex-1">
            <label for="cuenta_id" class="block text-sm font-medium text-gray-700 mb-2">Cuenta</label>
            <select id="cuenta_id" name="cuenta_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-500">
                <option value="">Seleccione una cuenta</option>
                @foreach($cuentas as $cuenta)
                <option value="{{ $cuenta->id }}" {{ request()->get('cuenta_id') == $cuenta->id ? 'selected' : '' }}>
                    {{ $cuenta->codigo }} - {{ $cuenta->nombre }}
                </option>
                @endforeach
            </select>
        </div>
        <div class="flex-1">
            <label for="fecha_desde" class="block text-sm font-medium text-gray-700 mb-2">Desde</label>
            <input type="date" id="fecha_desde" name="fecha_desde" value="{{ request()->get('fecha_desde', date('Y-m-01')) }}"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-500">
        </div>
        <div class="flex-1">
            <label for="fecha_hasta" class="block text-sm font-medium text-gray-700 mb-2">Hasta</label>
            <input type="date" id="fecha_hasta" name="fecha_hasta" value="{{ request()->get('fecha_hasta', date('Y-m-d')) }}"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-500">
        </div>
        <div>
            <button type="submit" class="px-6 py-2 bg-gray-900 text-white rounded-lg hover:bg-gray-800 transition-colors">
                Generar Reporte
            </button>
        </div>
    </form>
</div>

<div class="bg-white rounded-lg shadow-sm border border-gray-200">
    @if($movimientos->isNotEmpty())
    <div class="px-6 py-4 border-b border-gray-200">
        <h3 class="text-lg font-semibold text-gray-900">Cuenta: {{ $cuentaSeleccionada->codigo }} - {{ $cuentaSeleccionada->nombre }}</h3>
        <p class="text-sm text-gray-600">Del {{ \Carbon\Carbon::parse($fechaDesde)->format('d/m/Y') }} al {{ \Carbon\Carbon::parse($fechaHasta)->format('d/m/Y') }}</p>
    </div>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Asiento</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Glosa</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Debe</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Haber</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Saldo</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($movimientos as $mov)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ \Carbon\Carbon::parse($mov['fecha'])->format('d/m/Y') }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $mov['numero_asiento'] }}</td>
                    <td class="px-6 py-4 text-sm text-gray-500">{{ $mov['glosa'] }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-right">{{ number_format($mov['debe'], 2) }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-right">{{ number_format($mov['haber'], 2) }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-right">{{ number_format($mov['saldo'], 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
    <div class="p-6">
        <div class="text-center py-12 text-gray-500">
            <svg class="w-12 h-12 mx-auto mb-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            <p>No hay datos para mostrar</p>
            <p class="text-sm text-gray-400 mt-2">Selecciona los filtros y genera el reporte</p>
        </div>
    </div>
    @endif
</div>
@endsection

