@extends('layout.app')

@section('title', 'Crear Egreso')

@section('page-title', 'Crear Egreso')

@section('page-header')
<div>
    <h1 class="text-2xl font-bold text-gray-900">Crear Egreso</h1>
    <p class="text-gray-600 mt-1">Registra un nuevo egreso</p>
</div>
@endsection

@section('content')
<form action="{{ route('egresos.store') }}" method="POST" class="space-y-6">
    @csrf
    
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Información del Egreso</h3>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="id_proveedor" class="block text-sm font-medium text-gray-700 mb-2">Proveedor</label>
                <select name="id_proveedor" id="id_proveedor"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-500 focus:border-transparent @error('id_proveedor') border-red-500 @enderror">
                    <option value="">Seleccionar Proveedor</option>
                    @foreach($proveedores as $proveedor)
                        <option value="{{ $proveedor->id_proveedor }}" {{ old('id_proveedor') == $proveedor->id_proveedor ? 'selected' : '' }}>
                            {{ $proveedor->nombre }} {{ $proveedor->nit ? '(' . $proveedor->nit . ')' : '' }}
                        </option>
                    @endforeach
                </select>
                @error('id_proveedor') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            
            <div>
                <label for="id_categoria" class="block text-sm font-medium text-gray-700 mb-2">Categoría</label>
                <select name="id_categoria" id="id_categoria"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-500 focus:border-transparent @error('id_categoria') border-red-500 @enderror">
                    <option value="">Seleccionar Categoría</option>
                    @foreach($categorias as $categoria)
                        <option value="{{ $categoria->id_categoria }}" {{ old('id_categoria') == $categoria->id_categoria ? 'selected' : '' }}>
                            {{ $categoria->nombre }}
                        </option>
                    @endforeach
                </select>
                @error('id_categoria') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            
            <div>
                <label for="fecha" class="block text-sm font-medium text-gray-700 mb-2">Fecha *</label>
                <input type="date" name="fecha" id="fecha" value="{{ old('fecha', date('Y-m-d')) }}" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-500 focus:border-transparent @error('fecha') border-red-500 @enderror">
                @error('fecha') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            
            <div>
                <label for="monto" class="block text-sm font-medium text-gray-700 mb-2">Monto *</label>
                <input type="number" step="0.01" name="monto" id="monto" value="{{ old('monto') }}" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-500 focus:border-transparent @error('monto') border-red-500 @enderror"
                    placeholder="0.00">
                @error('monto') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            
            <div>
                <label for="id_moneda" class="block text-sm font-medium text-gray-700 mb-2">Moneda *</label>
                <select name="id_moneda" id="id_moneda" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-500 focus:border-transparent @error('id_moneda') border-red-500 @enderror">
                    <option value="">Seleccionar Moneda</option>
                    @foreach($monedas as $moneda)
                        <option value="{{ $moneda->id_moneda }}" {{ old('id_moneda') == $moneda->id_moneda ? 'selected' : '' }}>
                            {{ $moneda->codigo }} - {{ $moneda->nombre }}
                        </option>
                    @endforeach
                </select>
                @error('id_moneda') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
        </div>
        
        <div class="mt-6">
            <label for="descripcion" class="block text-sm font-medium text-gray-700 mb-2">Descripción</label>
            <textarea name="descripcion" id="descripcion" rows="3"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-500 focus:border-transparent"
                placeholder="Descripción del egreso">{{ old('descripcion') }}</textarea>
        </div>
    </div>
    
    <div class="flex justify-end space-x-4">
        <a href="{{ route('egresos.index') }}" class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
            Cancelar
        </a>
        <button type="submit" class="px-6 py-2 bg-gray-900 text-white rounded-lg hover:bg-gray-800 transition-colors">
            Registrar Egreso
        </button>
    </div>
</form>
@endsection

