@extends('layout.app')

@section('title', 'Crear Alumno')

@section('page-title', 'Crear Alumno')

@section('page-header')
<div>
    <h1 class="text-2xl font-bold text-gray-900">Crear Alumno</h1>
    <p class="text-gray-600 mt-1">Registra un nuevo alumno</p>
</div>
@endsection

@section('content')
<form action="{{ route('alumnos.store') }}" method="POST" class="space-y-6">
    @csrf
    
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Información del Alumno</h3>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="codigo" class="block text-sm font-medium text-gray-700 mb-2">Código *</label>
                <input type="text" name="codigo" id="codigo" value="{{ old('codigo') }}" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-500 focus:border-transparent"
                    placeholder="Ej: ALU-001">
            </div>
            
            <div>
                <label for="nombre_completo" class="block text-sm font-medium text-gray-700 mb-2">Nombre Completo *</label>
                <input type="text" name="nombre_completo" id="nombre_completo" value="{{ old('nombre_completo') }}" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-500 focus:border-transparent"
                    placeholder="Nombre completo del alumno">
            </div>
            
            <div>
                <label for="ci" class="block text-sm font-medium text-gray-700 mb-2">CI</label>
                <input type="text" name="ci" id="ci" value="{{ old('ci') }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-500 focus:border-transparent"
                    placeholder="Carnet de identidad">
            </div>
            
            <div>
                <label for="celular" class="block text-sm font-medium text-gray-700 mb-2">Celular</label>
                <input type="text" name="celular" id="celular" value="{{ old('celular') }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-500 focus:border-transparent"
                    placeholder="Número de celular">
            </div>
            
            <div class="md:col-span-2">
                <label for="direccion" class="block text-sm font-medium text-gray-700 mb-2">Dirección</label>
                <input type="text" name="direccion" id="direccion" value="{{ old('direccion') }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-500 focus:border-transparent"
                    placeholder="Dirección del alumno">
            </div>
            
            <div>
                <label for="estado" class="block text-sm font-medium text-gray-700 mb-2">Estado</label>
                <select name="estado" id="estado"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-500 focus:border-transparent">
                    <option value="activo" {{ old('estado') == 'activo' ? 'selected' : '' }}>Activo</option>
                    <option value="inactivo" {{ old('estado') == 'inactivo' ? 'selected' : '' }}>Inactivo</option>
                </select>
            </div>
            
            <div class="md:col-span-2">
                <label for="observacion" class="block text-sm font-medium text-gray-700 mb-2">Observación</label>
                <textarea name="observacion" id="observacion" rows="3"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-500 focus:border-transparent"
                    placeholder="Observaciones adicionales">{{ old('observacion') }}</textarea>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Apoderados</h3>
        <div class="space-y-2 max-h-64 overflow-y-auto">
            @forelse($apoderados as $apoderado)
            <label class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-gray-50 cursor-pointer">
                <input type="checkbox" name="apoderados[]" value="{{ $apoderado->id_apoderado }}"
                    class="rounded border-gray-300 text-gray-600 focus:ring-gray-500">
                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-900">{{ $apoderado->nombre_completo }}</p>
                    <p class="text-xs text-gray-500">CI: {{ $apoderado->ci }} - {{ $apoderado->relacion_legal }}</p>
                </div>
            </label>
            @empty
            <p class="text-sm text-gray-500">No hay apoderados registrados. <a href="{{ route('apoderados.create') }}" class="text-gray-900 underline">Crear apoderado</a></p>
            @endforelse
        </div>
    </div>
    
    <div class="flex justify-end space-x-4">
        <a href="{{ route('alumnos.index') }}" class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
            Cancelar
        </a>
        <button type="submit" class="px-6 py-2 bg-gray-900 text-white rounded-lg hover:bg-gray-800 transition-colors">
            <i class="fas fa-save mr-2"></i>Guardar Alumno
        </button>
    </div>
</form>
@endsection

