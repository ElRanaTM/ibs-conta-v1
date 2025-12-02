@extends('layout.app')

@section('title', 'Registrar Pago')

@section('page-title', 'Registrar Pago')

@section('page-header')
<div>
    <h1 class="text-2xl font-bold text-gray-900">Registrar Pago</h1>
    <p class="text-gray-600 mt-1">Registra un nuevo pago de alumno</p>
</div>
@endsection

@section('content')
<form action="{{ route('pagos.store') }}" method="POST" class="space-y-6">
    @csrf
    
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Información del Pago</h3>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="id_alumno" class="block text-sm font-medium text-gray-700 mb-2">Alumno *</label>
                <select name="id_alumno" id="id_alumno" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-500 focus:border-transparent">
                    <option value="">Seleccionar Alumno</option>
                </select>
            </div>
            
            <div>
                <label for="id_concepto" class="block text-sm font-medium text-gray-700 mb-2">Concepto de Ingreso *</label>
                <select name="id_concepto" id="id_concepto" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-500 focus:border-transparent">
                    <option value="">Seleccionar Concepto</option>
                </select>
            </div>
            
            <div>
                <label for="fecha_pago" class="block text-sm font-medium text-gray-700 mb-2">Fecha de Pago *</label>
                <input type="date" name="fecha_pago" id="fecha_pago" value="{{ old('fecha_pago', date('Y-m-d')) }}" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-500 focus:border-transparent">
            </div>
            
            <div>
                <label for="id_periodo" class="block text-sm font-medium text-gray-700 mb-2">Período Académico *</label>
                <select name="id_periodo" id="id_periodo" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-500 focus:border-transparent">
                    <option value="">Seleccionar Período</option>
                </select>
            </div>
            
            <div>
                <label for="monto" class="block text-sm font-medium text-gray-700 mb-2">Monto *</label>
                <input type="number" step="0.01" name="monto" id="monto" value="{{ old('monto') }}" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-500 focus:border-transparent"
                    placeholder="0.00">
            </div>
            
            <div>
                <label for="id_moneda" class="block text-sm font-medium text-gray-700 mb-2">Moneda *</label>
                <select name="id_moneda" id="id_moneda" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-500 focus:border-transparent">
                    <option value="">Seleccionar Moneda</option>
                </select>
            </div>
            
            <div>
                <label for="id_metodo_pago" class="block text-sm font-medium text-gray-700 mb-2">Método de Pago *</label>
                <select name="id_metodo_pago" id="id_metodo_pago" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-500 focus:border-transparent">
                    <option value="">Seleccionar Método</option>
                </select>
            </div>
            
            <div>
                <label for="referencia_pago" class="block text-sm font-medium text-gray-700 mb-2">Referencia de Pago</label>
                <input type="text" name="referencia_pago" id="referencia_pago" value="{{ old('referencia_pago') }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-500 focus:border-transparent"
                    placeholder="Número de referencia">
            </div>
        </div>
        
        <div class="mt-6">
            <label for="estado_pago" class="block text-sm font-medium text-gray-700 mb-2">Estado del Pago</label>
            <select name="estado_pago" id="estado_pago"
                class="w-full md:w-64 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-500 focus:border-transparent">
                <option value="pagado" {{ old('estado_pago') == 'pagado' ? 'selected' : '' }}>Pagado</option>
                <option value="pendiente" {{ old('estado_pago') == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                <option value="anulado" {{ old('estado_pago') == 'anulado' ? 'selected' : '' }}>Anulado</option>
            </select>
        </div>
    </div>
    
    <div class="flex justify-end space-x-4">
        <a href="{{ route('pagos.index') }}" class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
            Cancelar
        </a>
        <button type="submit" class="px-6 py-2 bg-gray-900 text-white rounded-lg hover:bg-gray-800 transition-colors">
            Registrar Pago
        </button>
    </div>
</form>
@endsection

