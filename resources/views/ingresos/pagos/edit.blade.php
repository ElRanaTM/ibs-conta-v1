@extends('layout.app')

@section('title', 'Editar Pago')

@section('page-title', 'Editar Pago')

@section('page-header')
<div>
    <h1 class="text-2xl font-bold text-gray-900">Editar Pago: {{ $pago->numero_comprobante }}</h1>
    <p class="text-gray-600 mt-1">Modifica la información del pago</p>
</div>
@endsection

@section('content')
<form action="{{ route('pagos.update', $pago->id_pago) }}" method="POST" class="space-y-6">
    @csrf
    @method('PUT')
    
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Información del Pago</h3>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="id_alumno" class="block text-sm font-medium text-gray-700 mb-2">Alumno *</label>
                <select name="id_alumno" id="id_alumno" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-500 focus:border-transparent @error('id_alumno') border-red-500 @enderror">
                    <option value="">Seleccionar Alumno</option>
                    @foreach($alumnos as $alumno)
                        <option value="{{ $alumno->id_alumno }}" {{ old('id_alumno', $pago->id_alumno) == $alumno->id_alumno ? 'selected' : '' }}>
                            {{ $alumno->codigo ?? 'S/C' }} - {{ $alumno->nombre_completo ?? $alumno->nombres }}
                        </option>
                    @endforeach
                </select>
                @error('id_alumno') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            
            <div>
                <label for="id_concepto" class="block text-sm font-medium text-gray-700 mb-2">Concepto de Ingreso *</label>
                <select name="id_concepto" id="id_concepto" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-500 focus:border-transparent @error('id_concepto') border-red-500 @enderror">
                    <option value="">Seleccionar Concepto</option>
                    @foreach($conceptos as $concepto)
                        <option value="{{ $concepto->id_concepto }}" {{ old('id_concepto', $pago->id_concepto) == $concepto->id_concepto ? 'selected' : '' }}>
                            {{ $concepto->nombre }} ({{ $concepto->tipo }})
                        </option>
                    @endforeach
                </select>
                @error('id_concepto') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            
            <div>
                <label for="fecha_pago" class="block text-sm font-medium text-gray-700 mb-2">Fecha de Pago *</label>
                <input type="date" name="fecha_pago" id="fecha_pago" value="{{ old('fecha_pago', $pago->fecha_pago->format('Y-m-d')) }}" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-500 focus:border-transparent @error('fecha_pago') border-red-500 @enderror">
                @error('fecha_pago') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            
            <div>
                <label for="id_periodo" class="block text-sm font-medium text-gray-700 mb-2">Período Académico *</label>
                <select name="id_periodo" id="id_periodo" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-500 focus:border-transparent @error('id_periodo') border-red-500 @enderror">
                    <option value="">Seleccionar Período</option>
                    @foreach($periodos as $periodo)
                        <option value="{{ $periodo->id_periodo }}" {{ old('id_periodo', $pago->id_periodo) == $periodo->id_periodo ? 'selected' : '' }}>
                            {{ $periodo->nombre_periodo }} ({{ $periodo->fecha_inicio->format('d/m/Y') }} - {{ $periodo->fecha_fin->format('d/m/Y') }})
                        </option>
                    @endforeach
                </select>
                @error('id_periodo') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            
            <div>
                <label for="monto" class="block text-sm font-medium text-gray-700 mb-2">Monto *</label>
                <input type="number" step="0.01" name="monto" id="monto" value="{{ old('monto', $pago->monto) }}" required
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
                        <option value="{{ $moneda->id_moneda }}" {{ old('id_moneda', $pago->id_moneda) == $moneda->id_moneda ? 'selected' : '' }}>
                            {{ $moneda->codigo }} - {{ $moneda->nombre }}
                        </option>
                    @endforeach
                </select>
                @error('id_moneda') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            
            <div>
                <label for="id_metodo_pago" class="block text-sm font-medium text-gray-700 mb-2">Método de Pago *</label>
                <select name="id_metodo_pago" id="id_metodo_pago" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-500 focus:border-transparent @error('id_metodo_pago') border-red-500 @enderror">
                    <option value="">Seleccionar Método</option>
                    @foreach($metodos as $metodo)
                        <option value="{{ $metodo->id_metodo }}" {{ old('id_metodo_pago', $pago->id_metodo_pago) == $metodo->id_metodo ? 'selected' : '' }}>
                            {{ $metodo->nombre }}
                        </option>
                    @endforeach
                </select>
                @error('id_metodo_pago') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            
            <div>
                <label for="referencia_pago" class="block text-sm font-medium text-gray-700 mb-2">Referencia de Pago</label>
                <input type="text" name="referencia_pago" id="referencia_pago" value="{{ old('referencia_pago', $pago->referencia_pago) }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-500 focus:border-transparent"
                    placeholder="Número de referencia">
            </div>
        </div>
        
        <div class="mt-6">
            <label for="estado_pago" class="block text-sm font-medium text-gray-700 mb-2">Estado del Pago</label>
            <select name="estado_pago" id="estado_pago"
                class="w-full md:w-64 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-500 focus:border-transparent">
                <option value="pagado" {{ old('estado_pago', $pago->estado_pago) == 'pagado' ? 'selected' : '' }}>Pagado</option>
                <option value="pendiente" {{ old('estado_pago', $pago->estado_pago) == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                <option value="anulado" {{ old('estado_pago', $pago->estado_pago) == 'anulado' ? 'selected' : '' }}>Anulado</option>
            </select>
        </div>
    </div>
    
    <div class="flex justify-end space-x-4">
        <a href="{{ route('pagos.index') }}" class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
            Cancelar
        </a>
        <button type="submit" class="px-6 py-2 bg-gray-900 text-white rounded-lg hover:bg-gray-800 transition-colors">
            <i class="fas fa-save mr-2"></i>Actualizar Pago
        </button>
    </div>
</form>
@endsection

