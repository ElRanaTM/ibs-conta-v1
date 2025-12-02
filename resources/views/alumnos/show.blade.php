@extends('layout.app')

@section('title', 'Ver Alumno')

@section('page-title', 'Ver Alumno')

@section('page-header')
<div class="flex items-center justify-between">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">{{ $alumno->nombre_completo }}</h1>
        <p class="text-gray-600 mt-1">Información del alumno</p>
    </div>
    <div class="flex space-x-3">
        <a href="{{ route('alumnos.edit', $alumno->id_alumno) }}" class="px-4 py-2 bg-gray-800 text-white rounded-lg hover:bg-gray-700 transition-colors">
            <i class="fas fa-edit mr-2"></i>Editar
        </a>
        <a href="{{ route('alumnos.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
            <i class="fas fa-arrow-left mr-2"></i>Volver
        </a>
    </div>
</div>
@endsection

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2 space-y-6">
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Información Personal</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Código</label>
                    <p class="text-gray-900 font-semibold">{{ $alumno->codigo }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">CI</label>
                    <p class="text-gray-900">{{ $alumno->ci ?? 'N/A' }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Celular</label>
                    <p class="text-gray-900">{{ $alumno->celular ?? 'N/A' }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Estado</label>
                    <span class="px-2 py-1 text-xs rounded-full {{ $alumno->estado == 'activo' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                        {{ ucfirst($alumno->estado) }}
                    </span>
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Dirección</label>
                    <p class="text-gray-900">{{ $alumno->direccion ?? 'N/A' }}</p>
                </div>
                @if($alumno->observacion)
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Observación</label>
                    <p class="text-gray-900">{{ $alumno->observacion }}</p>
                </div>
                @endif
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Historial de Pagos</h3>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Fecha</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Concepto</th>
                            <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 uppercase">Monto</th>
                            <th class="px-4 py-2 text-center text-xs font-medium text-gray-500 uppercase">Estado</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($alumno->pagos as $pago)
                        <tr>
                            <td class="px-4 py-2 text-sm text-gray-500">{{ \Carbon\Carbon::parse($pago->fecha_pago)->format('d/m/Y') }}</td>
                            <td class="px-4 py-2 text-sm text-gray-900">{{ $pago->concepto->nombre ?? 'N/A' }}</td>
                            <td class="px-4 py-2 text-sm text-gray-900 text-right">{{ number_format($pago->monto, 2) }} {{ $pago->moneda->simbolo ?? '' }}</td>
                            <td class="px-4 py-2 text-center">
                                <span class="px-2 py-1 text-xs rounded-full 
                                    {{ $pago->estado_pago == 'pagado' ? 'bg-green-100 text-green-800' : 
                                       ($pago->estado_pago == 'pendiente' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                    {{ ucfirst($pago->estado_pago) }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-4 py-8 text-center text-gray-500 text-sm">No hay pagos registrados</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <div class="space-y-6">
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Apoderados</h3>
            <div class="space-y-3">
                @forelse($alumno->apoderados as $apoderado)
                <div class="p-3 border border-gray-200 rounded-lg">
                    <p class="text-sm font-medium text-gray-900">{{ $apoderado->nombre_completo }}</p>
                    <p class="text-xs text-gray-500 mt-1">CI: {{ $apoderado->ci }}</p>
                    <p class="text-xs text-gray-500">{{ $apoderado->relacion_legal }}</p>
                </div>
                @empty
                <p class="text-sm text-gray-500">No tiene apoderados asignados</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection

