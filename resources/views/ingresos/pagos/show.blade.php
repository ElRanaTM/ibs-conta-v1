@extends('layout.app')

@section('title', 'Ver Pago')

@section('page-title', 'Ver Pago')

@section('page-header')
<div class="flex items-center justify-between">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Pago: {{ $pago->numero_comprobante }}</h1>
        <p class="text-gray-600 mt-1">Detalle del pago</p>
    </div>
    <div class="flex space-x-3">
        <a href="{{ route('pagos.edit', $pago->id_pago) }}" class="px-4 py-2 bg-gray-800 text-white rounded-lg hover:bg-gray-700 transition-colors">
            <i class="fas fa-edit mr-2"></i>Editar
        </a>
        <a href="{{ route('pagos.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
            <i class="fas fa-arrow-left mr-2"></i>Volver
        </a>
    </div>
</div>
@endsection

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Información del Pago</h3>
        <div class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Número de Comprobante</label>
                <p class="text-gray-900 font-semibold">{{ $pago->numero_comprobante }}</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Alumno</label>
                <p class="text-gray-900">{{ $pago->alumno->nombre_completo ?? 'N/A' }}</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Concepto</label>
                <p class="text-gray-900">{{ $pago->concepto->nombre ?? 'N/A' }}</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Período Académico</label>
                <p class="text-gray-900">{{ $pago->periodo->nombre_periodo ?? 'N/A' }}</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Fecha de Pago</label>
                <p class="text-gray-900">{{ $pago->fecha_pago->format('d/m/Y') }}</p>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Detalles del Pago</h3>
        <div class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Monto</label>
                <p class="text-gray-900 text-2xl font-bold">{{ number_format($pago->monto, 2) }} {{ $pago->moneda->simbolo ?? '' }}</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Método de Pago</label>
                <p class="text-gray-900">{{ $pago->metodoPago->nombre ?? 'N/A' }}</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Referencia</label>
                <p class="text-gray-900">{{ $pago->referencia_pago ?? 'N/A' }}</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Estado</label>
                <span class="px-3 py-1 rounded-full text-sm 
                    {{ $pago->estado_pago == 'pagado' ? 'bg-green-100 text-green-800' : 
                       ($pago->estado_pago == 'pendiente' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                    {{ ucfirst($pago->estado_pago) }}
                </span>
            </div>
        </div>
    </div>
</div>
@endsection

