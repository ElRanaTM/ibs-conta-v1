@extends('layout.app')

@section('title', 'Ver Asiento')

@section('page-title', 'Ver Asiento')

@section('page-header')
<div class="flex items-center justify-between">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Asiento: {{ $asiento->numero_asiento }}</h1>
        <p class="text-gray-600 mt-1">Detalle del asiento contable</p>
    </div>
    <div class="flex space-x-3">
        <a href="{{ route('asientos.edit', $asiento->id) }}" class="px-4 py-2 bg-gray-800 text-white rounded-lg hover:bg-gray-700 transition-colors">
            <i class="fas fa-edit mr-2"></i>Editar
        </a>
        <a href="{{ route('asientos.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
            <i class="fas fa-arrow-left mr-2"></i>Volver
        </a>
    </div>
</div>
@endsection

@section('content')
<div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Número de Asiento</label>
            <p class="text-gray-900 font-semibold">{{ $asiento->numero_asiento }}</p>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Fecha</label>
            <p class="text-gray-900">{{ $asiento->fecha->format('d/m/Y') }}</p>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Estado</label>
            <span class="px-3 py-1 rounded-full text-sm {{ $asiento->estado ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                {{ $asiento->estado ? 'Activo' : 'Inactivo' }}
            </span>
        </div>
    </div>
    <div class="mt-6">
        <label class="block text-sm font-medium text-gray-700 mb-1">Glosa</label>
        <p class="text-gray-900">{{ $asiento->glosa }}</p>
    </div>
    <div class="mt-4">
        <label class="block text-sm font-medium text-gray-700 mb-1">Usuario</label>
        <p class="text-gray-900">{{ $asiento->usuario->name }}</p>
    </div>
</div>

<div class="bg-white rounded-lg shadow-sm border border-gray-200">
    <div class="px-6 py-4 border-b border-gray-200">
        <h3 class="text-lg font-semibold text-gray-900">Detalles del Asiento</h3>
    </div>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cuenta</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Glosa</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Debe</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Haber</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($asiento->detalleAsientos as $detalle)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900">{{ $detalle->cuentaAnalitica->codigo ?? 'N/A' }}</div>
                        <div class="text-sm text-gray-500">{{ $detalle->cuentaAnalitica->nombre ?? 'N/A' }}</div>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-500">{{ $detalle->glosa ?? '-' }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm text-gray-900">
                        {{ number_format($detalle->debe, 2) }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm text-gray-900">
                        {{ number_format($detalle->haber, 2) }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="px-6 py-12 text-center text-gray-500">No hay detalles registrados</td>
                </tr>
                @endforelse
            </tbody>
            <tfoot class="bg-gray-50">
                <tr>
                    <td colspan="2" class="px-6 py-3 text-right text-sm font-semibold text-gray-900">TOTALES:</td>
                    <td class="px-6 py-3 text-right text-sm font-semibold text-gray-900">
                        {{ number_format($asiento->detalleAsientos->sum('debe'), 2) }}
                    </td>
                    <td class="px-6 py-3 text-right text-sm font-semibold text-gray-900">
                        {{ number_format($asiento->detalleAsientos->sum('haber'), 2) }}
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
@endsection

