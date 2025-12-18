@extends('layout.app')

@section('title', 'Editar Método de Pago')

@section('page-title', 'Editar Método de Pago')

@section('page-header')
<div class="flex items-center justify-between">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Editar Método de Pago</h1>
        <p class="text-gray-600 mt-1">Modifica los datos del método de pago</p>
    </div>
    <a href="{{ route('catalogos.metodos-pago.index') }}" class="text-gray-600 hover:text-gray-900">
        <i class="fas fa-arrow-left mr-2"></i>Volver
    </a>
</div>
@endsection

@section('content')
<div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
    <form action="{{ route('catalogos.metodos-pago.update', $metodo->id) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')
        
        <!-- Nombre -->
        <div>
            <label for="nombre" class="block text-sm font-medium text-gray-700">Nombre</label>
            <input 
                type="text" 
                name="nombre" 
                id="nombre"
                value="{{ old('nombre', $metodo->nombre) }}"
                required
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-gray-500 focus:ring-gray-500 @error('nombre') border-red-500 @else border @endif px-3 py-2"
                placeholder="Ej: Transferencia Bancaria"
            >
            @error('nombre')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Descripción -->
        <div>
            <label for="descripcion" class="block text-sm font-medium text-gray-700">Descripción</label>
            <textarea 
                name="descripcion" 
                id="descripcion"
                rows="4"
                class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-gray-500 focus:ring-gray-500 @error('descripcion') border-red-500 @endif px-3 py-2"
                placeholder="Detalles del método de pago..."
            >{{ old('descripcion', $metodo->descripcion) }}</textarea>
            @error('descripcion')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Botones -->
        <div class="flex items-center justify-between pt-6 border-t border-gray-200">
            <a href="{{ route('catalogos.metodos-pago.index') }}" class="text-gray-600 hover:text-gray-900">Cancelar</a>
            <button type="submit" class="bg-gray-900 text-white px-6 py-2 rounded-lg hover:bg-gray-800 transition-colors">
                <i class="fas fa-save mr-2"></i>Actualizar
            </button>
        </div>
    </form>
</div>
@endsection
