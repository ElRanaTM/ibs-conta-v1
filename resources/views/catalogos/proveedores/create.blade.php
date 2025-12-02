@extends('layout.app')

@section('title', 'Crear Proveedor')

@section('page-title', 'Crear Proveedor')

@section('page-header')
<div>
    <h1 class="text-2xl font-bold text-gray-900">Crear Proveedor</h1>
    <p class="text-gray-600 mt-1">Registra un nuevo proveedor</p>
</div>
@endsection

@section('content')
<form action="{{ route('catalogos.proveedores.store') }}" method="POST" class="space-y-6">
    @csrf
    
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="md:col-span-2">
                <label for="nombre" class="block text-sm font-medium text-gray-700 mb-2">Nombre *</label>
                <input type="text" name="nombre" id="nombre" value="{{ old('nombre') }}" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-500 focus:border-transparent"
                    placeholder="Nombre del proveedor">
            </div>
            
            <div>
                <label for="nit" class="block text-sm font-medium text-gray-700 mb-2">NIT</label>
                <input type="text" name="nit" id="nit" value="{{ old('nit') }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-500 focus:border-transparent"
                    placeholder="NIT del proveedor">
            </div>
            
            <div>
                <label for="telefono" class="block text-sm font-medium text-gray-700 mb-2">Teléfono</label>
                <input type="text" name="telefono" id="telefono" value="{{ old('telefono') }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-500 focus:border-transparent"
                    placeholder="Teléfono">
            </div>
            
            <div class="md:col-span-2">
                <label for="direccion" class="block text-sm font-medium text-gray-700 mb-2">Dirección</label>
                <input type="text" name="direccion" id="direccion" value="{{ old('direccion') }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-500 focus:border-transparent"
                    placeholder="Dirección">
            </div>
        </div>
    </div>
    
    <div class="flex justify-end space-x-4">
        <a href="{{ route('catalogos.proveedores.index') }}" class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
            Cancelar
        </a>
        <button type="submit" class="px-6 py-2 bg-gray-900 text-white rounded-lg hover:bg-gray-800 transition-colors">
            <i class="fas fa-save mr-2"></i>Guardar
        </button>
    </div>
</form>
@endsection
