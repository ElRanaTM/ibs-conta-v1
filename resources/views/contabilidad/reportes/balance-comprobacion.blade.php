@extends('layout.app')

@section('title', 'Balance de Comprobación')

@section('page-title', 'Balance de Comprobación')

@section('page-header')
<div class="flex items-center justify-between">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Balance de Comprobación</h1>
        <p class="text-gray-600 mt-1">Resumen de saldos de todas las cuentas</p>
    </div>
    <div class="flex space-x-3">
        <a href="{{ route('reportes.balance-comprobacion', ['fecha_desde' => request()->get('fecha_desde', date('Y-m-01')), 'fecha_hasta' => request()->get('fecha_hasta', date('Y-m-d'))]) }}" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">Exportar PDF</a>
        <a href="{{ route('reportes.balance-comprobacion', ['fecha_desde' => request()->get('fecha_desde', date('Y-m-01')), 'fecha_hasta' => request()->get('fecha_hasta', date('Y-m-d'))]) }}" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">Exportar Excel</a>
    </div>
</div>
@endsection

@section('content')
<div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
    <form method="GET" class="flex flex-col md:flex-row md:items-end space-y-4 md:space-y-0 md:space-x-4">
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
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Código</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cuenta</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Saldo Deudor</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Saldo Acreedor</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <tr>
                    <td colspan="4" class="px-6 py-12 text-center text-gray-500">
                        <svg class="w-12 h-12 mx-auto mb-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        <p>No hay datos para mostrar</p>
                        <p class="text-sm text-gray-400 mt-2">Selecciona un rango de fechas y genera el reporte</p>
                    </td>
                </tr>
            </tbody>
            <tfoot class="bg-gray-50">
                <tr>
                    <td colspan="2" class="px-6 py-3 text-right text-sm font-semibold text-gray-900">TOTALES:</td>
                    <td class="px-6 py-3 text-right text-sm font-semibold text-gray-900">0.00</td>
                    <td class="px-6 py-3 text-right text-sm font-semibold text-gray-900">0.00</td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
@endsection

