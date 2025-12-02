@extends('layout.app')

@section('title', 'Editar Moneda')

@section('page-title', 'Editar Moneda')

@section('page-header')
<div>
    <h1 class="text-2xl font-bold text-gray-900">Editar Moneda: {{ $moneda->nombre }}</h1>
    <p class="text-gray-600 mt-1">Modifica la información de la moneda</p>
</div>
@endsection

@section('content')
<form action="{{ route('catalogos.monedas.update', $moneda->id_moneda) }}" method="POST" class="space-y-6">
    @csrf
    @method('PUT')
    
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Información de la Moneda</h3>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="nombre" class="block text-sm font-medium text-gray-700 mb-2">Nombre *</label>
                <input type="text" name="nombre" id="nombre" value="{{ old('nombre', $moneda->nombre) }}" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-500 focus:border-transparent">
            </div>
            
            <div>
                <label for="abreviatura" class="block text-sm font-medium text-gray-700 mb-2">Abreviatura *</label>
                <input type="text" name="abreviatura" id="abreviatura" value="{{ old('abreviatura', $moneda->abreviatura) }}" required maxlength="5"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-500 focus:border-transparent">
            </div>
            
            <div>
                <label for="simbolo" class="block text-sm font-medium text-gray-700 mb-2">Símbolo *</label>
                <input type="text" name="simbolo" id="simbolo" value="{{ old('simbolo', $moneda->simbolo) }}" required maxlength="5"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-500 focus:border-transparent">
            </div>
            
            <div class="flex items-center">
                <label class="flex items-center">
                    <input type="checkbox" name="es_local" value="1" {{ old('es_local', $moneda->es_local) ? 'checked' : '' }}
                        class="rounded border-gray-300 text-gray-600 focus:ring-gray-500">
                    <span class="ml-2 text-sm text-gray-700">Moneda local</span>
                </label>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Tipo de Cambio</h3>
        <form action="{{ route('catalogos.monedas.tipo-cambio.store', $moneda->id_moneda) }}" method="POST" class="space-y-4">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="fecha_tc" class="block text-sm font-medium text-gray-700 mb-2">Fecha</label>
                    <input type="date" name="fecha" id="fecha_tc" value="{{ date('Y-m-d') }}" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-500 focus:border-transparent">
                </div>
                <div>
                    <label for="valor_tc" class="block text-sm font-medium text-gray-700 mb-2">Valor (1 {{ $moneda->abreviatura }} = ? Bs)</label>
                    <input type="number" step="0.0001" name="valor" id="valor_tc" 
                        value="{{ $moneda->es_local ? 1 : '' }}" 
                        {{ $moneda->es_local ? 'readonly' : 'required' }}
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-500 focus:border-transparent {{ $moneda->es_local ? 'bg-gray-50' : '' }}"
                        placeholder="0.0000">
                    @if($moneda->es_local)
                    <p class="text-xs text-gray-500 mt-1">La moneda local siempre tiene tipo de cambio 1</p>
                    @endif
                </div>
            </div>
            <div class="flex justify-end">
                <button type="submit" class="px-4 py-2 bg-gray-800 text-white rounded-lg hover:bg-gray-700 transition-colors">
                    <i class="fas fa-save mr-2"></i>Guardar Tipo de Cambio
                </button>
            </div>
        </form>
        
        <div class="mt-6">
            <h4 class="text-sm font-semibold text-gray-900 mb-3">Historial de Tipos de Cambio</h4>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Fecha</th>
                            <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 uppercase">Valor</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($moneda->tiposCambio()->latest('fecha')->limit(10)->get() as $tc)
                        <tr>
                            <td class="px-4 py-2 text-sm text-gray-900">{{ $tc->fecha->format('d/m/Y') }}</td>
                            <td class="px-4 py-2 text-sm text-gray-900 text-right">{{ number_format($tc->valor, 4) }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="2" class="px-4 py-4 text-center text-sm text-gray-500">No hay tipos de cambio registrados</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <div class="flex justify-end space-x-4">
        <a href="{{ route('catalogos.monedas.index') }}" class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
            Cancelar
        </a>
        <button type="submit" class="px-6 py-2 bg-gray-900 text-white rounded-lg hover:bg-gray-800 transition-colors">
            <i class="fas fa-save mr-2"></i>Actualizar Moneda
        </button>
    </div>
</form>
@endsection

