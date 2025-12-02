@extends('layout.app')

@section('title', 'Editar Período Académico')

@section('page-title', 'Editar Período Académico')

@section('page-header')
<div class="flex items-center justify-between">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Editar Período Académico</h1>
        <p class="text-gray-600 mt-1">Modifica los datos del período académico</p>
    </div>
    <a href="{{ route('catalogos.periodos-academicos.index') }}" class="text-gray-600 hover:text-gray-900">
        <i class="fas fa-arrow-left mr-2"></i>Volver
    </a>
</div>
@endsection

@section('content')
<div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
    <form action="{{ route('catalogos.periodos-academicos.update', $periodo->id_periodo) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')
        
        <!-- Nombre del Período -->
        <div>
            <label for="nombre_periodo" class="block text-sm font-medium text-gray-700">Nombre del Período</label>
            <input 
                type="text" 
                name="nombre_periodo" 
                id="nombre_periodo"
                value="{{ old('nombre_periodo', $periodo->nombre_periodo) }}"
                required
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-gray-500 focus:ring-gray-500 @error('nombre_periodo') border-red-500 @else border @endif px-3 py-2"
                placeholder="Ej: 2024-I"
            >
            @error('nombre_periodo')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Fechas -->
        <div class="grid grid-cols-2 gap-6">
            <div>
                <label for="fecha_inicio" class="block text-sm font-medium text-gray-700">Fecha Inicio</label>
                <input 
                    type="date" 
                    name="fecha_inicio" 
                    id="fecha_inicio"
                    value="{{ old('fecha_inicio', $periodo->fecha_inicio->format('Y-m-d')) }}"
                    required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-gray-500 focus:ring-gray-500 @error('fecha_inicio') border-red-500 @else border @endif px-3 py-2"
                >
                @error('fecha_inicio')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="fecha_fin" class="block text-sm font-medium text-gray-700">Fecha Fin</label>
                <input 
                    type="date" 
                    name="fecha_fin" 
                    id="fecha_fin"
                    value="{{ old('fecha_fin', $periodo->fecha_fin->format('Y-m-d')) }}"
                    required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-gray-500 focus:ring-gray-500 @error('fecha_fin') border-red-500 @else border @endif px-3 py-2"
                >
                @error('fecha_fin')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Estado Activo -->
        <div class="flex items-center">
            <input 
                type="checkbox" 
                name="activo" 
                id="activo"
                value="1"
                {{ old('activo', $periodo->activo) ? 'checked' : '' }}
                class="h-4 w-4 rounded border-gray-300 text-gray-900 focus:ring-gray-500"
            >
            <label for="activo" class="ml-2 block text-sm text-gray-700">
                Marcar como activo
            </label>
        </div>

        <!-- Botones -->
        <div class="flex items-center justify-between pt-6 border-t border-gray-200">
            <a href="{{ route('catalogos.periodos-academicos.index') }}" class="text-gray-600 hover:text-gray-900">Cancelar</a>
            <button type="submit" class="bg-gray-900 text-white px-6 py-2 rounded-lg hover:bg-gray-800 transition-colors">
                <i class="fas fa-save mr-2"></i>Actualizar
            </button>
        </div>
    </form>
</div>
@endsection
