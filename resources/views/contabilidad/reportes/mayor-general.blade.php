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
        <button class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
            Exportar PDF
        </button>
        <button class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
            Exportar Excel
        </button>
    </div>
</div>
@endsection

@section('content')
<div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
    <form class="flex flex-col md:flex-row md:items-end space-y-4 md:space-y-0 md:space-x-4">
        <div class="flex-1">
            <label for="cuenta_id" class="block text-sm font-medium text-gray-700 mb-2">Cuenta</label>
            <select id="cuenta_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-500">
                <option value="">Todas las cuentas</option>
            </select>
        </div>
        <div class="flex-1">
            <label for="fecha_desde" class="block text-sm font-medium text-gray-700 mb-2">Desde</label>
            <input type="date" id="fecha_desde" value="{{ date('Y-m-01') }}"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-500">
        </div>
        <div class="flex-1">
            <label for="fecha_hasta" class="block text-sm font-medium text-gray-700 mb-2">Hasta</label>
            <input type="date" id="fecha_hasta" value="{{ date('Y-m-d') }}"
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
    <div class="p-6">
        <div class="text-center py-12 text-gray-500">
            <svg class="w-12 h-12 mx-auto mb-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            <p>No hay datos para mostrar</p>
            <p class="text-sm text-gray-400 mt-2">Selecciona los filtros y genera el reporte</p>
        </div>
    </div>
</div>
@endsection

