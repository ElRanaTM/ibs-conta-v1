@extends('layout.app')

@section('title', 'Crear Categoría de Egreso')

@section('page-title', 'Crear Categoría')

@section('page-header')
<div>
    <h1 class="text-2xl font-bold text-gray-900">Crear Categoría de Egreso</h1>
    <p class="text-gray-600 mt-1">Registra una nueva categoría</p>
</div>
@endsection

@section('content')
<form action="{{ route('catalogos.categorias-egreso.store') }}" method="POST" class="space-y-6">
    @csrf
    
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="grid grid-cols-1 gap-6">
            <div>
                <label for="nombre" class="block text-sm font-medium text-gray-700 mb-2">Nombre *</label>
                <input type="text" name="nombre" id="nombre" value="{{ old('nombre') }}" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-500 focus:border-transparent">
            </div>
            
            <div>
                <label for="descripcion" class="block text-sm font-medium text-gray-700 mb-2">Descripción</label>
                <textarea name="descripcion" id="descripcion" rows="3"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-500 focus:border-transparent">{{ old('descripcion') }}</textarea>
            </div>
        </div>
    </div>
    
    <div class="flex justify-end space-x-4">
        <a href="{{ route('catalogos.categorias-egreso.index') }}" class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
            Cancelar
        </a>
        <button type="submit" class="px-6 py-2 bg-gray-900 text-white rounded-lg hover:bg-gray-800 transition-colors">
            <i class="fas fa-save mr-2"></i>Guardar
        </button>
    </div>
</form>
@endsection
