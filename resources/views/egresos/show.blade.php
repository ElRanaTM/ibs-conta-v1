@extends('layout.app')

@section('title', 'Ver Egreso')

@section('page-title', 'Ver Egreso')

@section('page-header')
<div class="flex items-center justify-between">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Egreso: {{ $egreso->numero_comprobante }}</h1>
        <p class="text-gray-600 mt-1">Detalle del egreso</p>
    </div>
    <div class="flex space-x-3">
        <a href="{{ route('egresos.edit', $egreso->id_egreso) }}" class="px-4 py-2 bg-gray-800 text-white rounded-lg hover:bg-gray-700 transition-colors">
            <i class="fas fa-edit mr-2"></i>Editar
        </a>
        <a href="{{ route('egresos.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
            <i class="fas fa-arrow-left mr-2"></i>Volver
        </a>
    </div>
</div>
@endsection

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Información del Egreso</h3>
        <div class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Número de Comprobante</label>
                <p class="text-gray-900 font-semibold">{{ $egreso->numero_comprobante }}</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Proveedor</label>
                <p class="text-gray-900">{{ $egreso->proveedor->nombre ?? 'N/A' }}</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Categoría</label>
                <p class="text-gray-900">{{ $egreso->categoria->nombre ?? 'N/A' }}</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Fecha</label>
                <p class="text-gray-900">{{ $egreso->fecha->format('d/m/Y') }}</p>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Detalles del Egreso</h3>
        <div class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Monto</label>
                <p class="text-gray-900 text-2xl font-bold">{{ number_format($egreso->monto, 2) }} {{ $egreso->moneda->simbolo ?? '' }}</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Moneda</label>
                <p class="text-gray-900">{{ $egreso->moneda->nombre ?? 'N/A' }}</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Descripción</label>
                <p class="text-gray-900">{{ $egreso->descripcion ?? 'N/A' }}</p>
            </div>
        </div>
    </div>
</div>
@endsection

