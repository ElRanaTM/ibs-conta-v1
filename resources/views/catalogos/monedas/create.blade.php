@extends('layout.app')

@section('title', 'Crear Moneda')

@section('page-title', 'Crear Moneda')

@section('page-header')
<div>
    <h1 class="text-2xl font-bold text-gray-900">Crear Moneda</h1>
    <p class="text-gray-600 mt-1">Registra una nueva moneda</p>
</div>
@endsection

@section('content')
<form action="{{ route('catalogos.monedas.store') }}" method="POST" class="space-y-6">
    @csrf
    
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Información de la Moneda</h3>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="nombre" class="block text-sm font-medium text-gray-700 mb-2">Nombre *</label>
                <input type="text" name="nombre" id="nombre" value="{{ old('nombre') }}" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-500 focus:border-transparent"
                    placeholder="Ej: Boliviano">
            </div>
            
            <div>
                <label for="abreviatura" class="block text-sm font-medium text-gray-700 mb-2">Abreviatura *</label>
                <input type="text" name="abreviatura" id="abreviatura" value="{{ old('abreviatura') }}" required maxlength="5"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-500 focus:border-transparent"
                    placeholder="Ej: BOB">
            </div>
            
            <div>
                <label for="simbolo" class="block text-sm font-medium text-gray-700 mb-2">Símbolo *</label>
                <input type="text" name="simbolo" id="simbolo" value="{{ old('simbolo') }}" required maxlength="5"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-500 focus:border-transparent"
                    placeholder="Ej: Bs.">
            </div>
            
            <div class="flex items-center">
                <label class="flex items-center">
                    <input type="checkbox" name="es_local" value="1" {{ old('es_local') ? 'checked' : '' }}
                        class="rounded border-gray-300 text-gray-600 focus:ring-gray-500">
                    <span class="ml-2 text-sm text-gray-700">Moneda local</span>
                </label>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Tipo de Cambio Inicial</h3>
        <p class="text-sm text-gray-600 mb-4">Puedes registrar el tipo de cambio después de crear la moneda</p>
    </div>
    
    <div class="flex justify-end space-x-4">
        <a href="{{ route('catalogos.monedas.index') }}" class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
            Cancelar
        </a>
        <button type="submit" class="px-6 py-2 bg-gray-900 text-white rounded-lg hover:bg-gray-800 transition-colors">
            <i class="fas fa-save mr-2"></i>Guardar Moneda
        </button>
    </div>
</form>
@endsection

