@extends('layout.app')

@section('title', 'Editar Egreso')

@section('page-title', 'Editar Egreso')

@section('page-header')
<div>
    <h1 class="text-2xl font-bold text-gray-900">Editar Egreso: {{ $egreso->numero_comprobante }}</h1>
    <p class="text-gray-600 mt-1">Modifica la información del egreso</p>
</div>
@endsection

@section('content')
<form action="{{ route('egresos.update', $egreso->id_egreso) }}" method="POST" class="space-y-6">
    @csrf
    @method('PUT')
    
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Información del Egreso</h3>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="id_proveedor" class="block text-sm font-medium text-gray-700 mb-2">Proveedor</label>
                <select name="id_proveedor" id="id_proveedor"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-500 focus:border-transparent">
                    <option value="">Seleccionar Proveedor</option>
                    @if($egreso->id_proveedor)
                        <option value="{{ $egreso->id_proveedor }}" selected>{{ $egreso->proveedor->nombre ?? 'N/A' }}</option>
                    @endif
                </select>
            </div>
            
            <div>
                <label for="id_categoria" class="block text-sm font-medium text-gray-700 mb-2">Categoría</label>
                <select name="id_categoria" id="id_categoria"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-500 focus:border-transparent">
                    <option value="">Seleccionar Categoría</option>
                    @if($egreso->id_categoria)
                        <option value="{{ $egreso->id_categoria }}" selected>{{ $egreso->categoria->nombre ?? 'N/A' }}</option>
                    @endif
                </select>
            </div>
            
            <div>
                <label for="fecha" class="block text-sm font-medium text-gray-700 mb-2">Fecha *</label>
                <input type="date" name="fecha" id="fecha" value="{{ old('fecha', $egreso->fecha->format('Y-m-d')) }}" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-500 focus:border-transparent">
            </div>
            
            <div>
                <label for="monto" class="block text-sm font-medium text-gray-700 mb-2">Monto *</label>
                <input type="number" step="0.01" name="monto" id="monto" value="{{ old('monto', $egreso->monto) }}" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-500 focus:border-transparent"
                    placeholder="0.00">
            </div>
            
            <div>
                <label for="id_moneda" class="block text-sm font-medium text-gray-700 mb-2">Moneda *</label>
                <select name="id_moneda" id="id_moneda" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-500 focus:border-transparent">
                    <option value="">Seleccionar Moneda</option>
                    <option value="{{ $egreso->id_moneda }}" selected>{{ $egreso->moneda->nombre ?? 'N/A' }}</option>
                </select>
            </div>
        </div>
        
        <div class="mt-6">
            <label for="descripcion" class="block text-sm font-medium text-gray-700 mb-2">Descripción</label>
            <textarea name="descripcion" id="descripcion" rows="3"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-500 focus:border-transparent"
                placeholder="Descripción del egreso">{{ old('descripcion', $egreso->descripcion) }}</textarea>
        </div>
    </div>
    
    <div class="flex justify-end space-x-4">
        <a href="{{ route('egresos.index') }}" class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
            Cancelar
        </a>
        <button type="submit" class="px-6 py-2 bg-gray-900 text-white rounded-lg hover:bg-gray-800 transition-colors">
            <i class="fas fa-save mr-2"></i>Actualizar Egreso
        </button>
    </div>
</form>
@endsection

