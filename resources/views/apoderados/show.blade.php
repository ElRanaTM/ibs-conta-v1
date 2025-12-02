@extends('layout.app')

@section('title', 'Ver Apoderado')

@section('page-title', 'Ver Apoderado')

@section('page-header')
<div class="flex items-center justify-between">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">{{ $apoderado->nombre_completo }}</h1>
        <p class="text-gray-600 mt-1">Información del apoderado</p>
    </div>
    <div class="flex space-x-3">
        <a href="{{ route('apoderados.edit', $apoderado->id_apoderado) }}" class="px-4 py-2 bg-gray-800 text-white rounded-lg hover:bg-gray-700 transition-colors">
            <i class="fas fa-edit mr-2"></i>Editar
        </a>
        <a href="{{ route('apoderados.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
            <i class="fas fa-arrow-left mr-2"></i>Volver
        </a>
    </div>
</div>
@endsection

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2">
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Información Personal</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">CI</label>
                    <p class="text-gray-900 font-semibold">{{ $apoderado->ci }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Relación Legal</label>
                    <p class="text-gray-900">{{ $apoderado->relacion_legal }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Celular</label>
                    <p class="text-gray-900">{{ $apoderado->celular ?? 'N/A' }}</p>
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Dirección</label>
                    <p class="text-gray-900">{{ $apoderado->direccion ?? 'N/A' }}</p>
                </div>
                @if($apoderado->observacion)
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Observación</label>
                    <p class="text-gray-900">{{ $apoderado->observacion }}</p>
                </div>
                @endif
            </div>
        </div>
    </div>
    
    <div>
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Alumnos Asociados</h3>
            <div class="space-y-3">
                @forelse($apoderado->alumnos as $alumno)
                <div class="p-3 border border-gray-200 rounded-lg">
                    <p class="text-sm font-medium text-gray-900">{{ $alumno->nombre_completo }}</p>
                    <p class="text-xs text-gray-500 mt-1">Código: {{ $alumno->codigo }}</p>
                    <a href="{{ route('alumnos.show', $alumno->id_alumno) }}" class="text-xs text-gray-600 hover:text-gray-900 mt-2 inline-block">
                        Ver detalles <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>
                @empty
                <p class="text-sm text-gray-500">No tiene alumnos asociados</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection

