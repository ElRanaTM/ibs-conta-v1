@extends('layout.app')

@section('title', 'Nuevo Concepto de Ingreso')

@section('page-title', 'Nuevo Concepto de Ingreso')

@section('page-header')
<div class="flex items-center justify-between">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Registrar Concepto de Ingreso</h1>
        <p class="text-gray-600 mt-1">Crea un nuevo concepto de ingreso en el sistema</p>
    </div>
    <a href="{{ route('catalogos.conceptos-ingreso.index') }}" class="text-gray-600 hover:text-gray-900">
        <i class="fas fa-arrow-left mr-2"></i>Volver
    </a>
</div>
@endsection

@section('content')
<div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
    <form action="{{ route('catalogos.conceptos-ingreso.store') }}" method="POST" class="space-y-6">
        @csrf
        
        <div class="grid grid-cols-2 gap-6">
            <!-- Nombre -->
            <div>
                <label for="nombre" class="block text-sm font-medium text-gray-700">Nombre</label>
                <input 
                    type="text" 
                    name="nombre" 
                    id="nombre"
                    value="{{ old('nombre') }}"
                    required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-gray-500 focus:ring-gray-500 @error('nombre') border-red-500 @else border @endif px-3 py-2"
                    placeholder="Ej: Matrícula"
                >
                @error('nombre')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Tipo -->
            <div>
                <label for="tipo" class="block text-sm font-medium text-gray-700">Tipo</label>
                <input 
                    type="text" 
                    name="tipo" 
                    id="tipo"
                    value="{{ old('tipo') }}"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-gray-500 focus:ring-gray-500 @error('tipo') border-red-500 @else border @endif px-3 py-2"
                    placeholder="Ej: Mensual"
                >
                @error('tipo')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Monto Base -->
        <div>
            <label for="monto_base" class="block text-sm font-medium text-gray-700">Monto Base</label>
            <input 
                type="number" 
                name="monto_base" 
                id="monto_base"
                value="{{ old('monto_base') }}"
                step="0.01"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-gray-500 focus:ring-gray-500 @error('monto_base') border-red-500 @else border @endif px-3 py-2"
                placeholder="0.00"
            >
            @error('monto_base')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Botones -->
        <div class="flex items-center justify-between pt-6 border-t border-gray-200">
            <a href="{{ route('catalogos.conceptos-ingreso.index') }}" class="text-gray-600 hover:text-gray-900">Cancelar</a>
            <button type="submit" class="bg-gray-900 text-white px-6 py-2 rounded-lg hover:bg-gray-800 transition-colors">
                <i class="fas fa-save mr-2"></i>Guardar
            </button>
        </div>
    </form>
</div>
@endsection
