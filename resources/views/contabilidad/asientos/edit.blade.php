@extends('layout.app')

@section('title', 'Editar Asiento')

@section('page-title', 'Editar Asiento')

@section('page-header')
<div>
    <h1 class="text-2xl font-bold text-gray-900">Editar Asiento: {{ $asiento->numero_asiento }}</h1>
    <p class="text-gray-600 mt-1">Modifica el asiento contable</p>
</div>
@endsection

@section('content')
<form action="{{ route('contabilidad.asientos.update', $asiento->id) }}" method="POST" class="space-y-6">
    @csrf
    @method('PUT')
    
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Información General</h3>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="fecha" class="block text-sm font-medium text-gray-700 mb-2">Fecha</label>
                <input type="date" name="fecha" id="fecha" value="{{ old('fecha', $asiento->fecha->format('Y-m-d')) }}" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-500 focus:border-transparent">
            </div>
            
            <div>
                <label for="glosa" class="block text-sm font-medium text-gray-700 mb-2">Glosa</label>
                <input type="text" name="glosa" id="glosa" value="{{ old('glosa', $asiento->glosa) }}" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-500 focus:border-transparent">
            </div>
        </div>
        
        <div class="mt-6">
            <label class="flex items-center">
                <input type="checkbox" name="estado" value="1" {{ $asiento->estado ? 'checked' : '' }}
                    class="rounded border-gray-300 text-gray-600 focus:ring-gray-500">
                <span class="ml-2 text-sm text-gray-700">Asiento activo</span>
            </label>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-900">Detalles del Asiento</h3>
            <button type="button" id="add-detail" class="text-sm text-gray-600 hover:text-gray-900 flex items-center">
                <i class="fas fa-plus mr-1"></i>Agregar Línea
            </button>
        </div>
        
        <div id="detalles-container" class="space-y-4">
            @foreach($asiento->detalleAsientos as $index => $detalle)
            <div class="grid grid-cols-12 gap-4 detail-row">
                <div class="col-span-5">
                    <select name="detalle_asientos[{{ $index }}][cuenta_analitica_id]" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-500">
                        <option value="">Seleccionar Cuenta</option>
                        <option value="{{ $detalle->cuenta_analitica_id }}" selected>{{ $detalle->cuentaAnalitica->codigo ?? 'N/A' }} - {{ $detalle->cuentaAnalitica->nombre ?? 'N/A' }}</option>
                    </select>
                </div>
                <div class="col-span-3">
                    <input type="number" step="0.01" name="detalle_asientos[{{ $index }}][debe]" value="{{ $detalle->debe }}" placeholder="0.00"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-500 debe-input">
                </div>
                <div class="col-span-3">
                    <input type="number" step="0.01" name="detalle_asientos[{{ $index }}][haber]" value="{{ $detalle->haber }}" placeholder="0.00"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-500 haber-input">
                </div>
                <div class="col-span-1">
                    <button type="button" class="remove-row text-red-600 hover:text-red-800">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            @endforeach
        </div>
        
        <div class="mt-6 pt-6 border-t border-gray-200">
            <div class="flex justify-between items-center">
                <div>
                    <span class="text-sm font-medium text-gray-700">Total Debe:</span>
                    <span class="text-lg font-bold text-gray-900 ml-2" id="total-debe">0.00</span>
                </div>
                <div>
                    <span class="text-sm font-medium text-gray-700">Total Haber:</span>
                    <span class="text-lg font-bold text-gray-900 ml-2" id="total-haber">0.00</span>
                </div>
            </div>
            <div class="mt-2 text-right">
                <span class="text-sm" id="balance-status"></span>
            </div>
        </div>
    </div>
    
    <div class="flex justify-end space-x-4">
        <a href="{{ route('contabilidad.asientos.index') }}" class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
            Cancelar
        </a>
        <button type="submit" class="px-6 py-2 bg-gray-900 text-white rounded-lg hover:bg-gray-800 transition-colors">
            <i class="fas fa-save mr-2"></i>Actualizar Asiento
        </button>
    </div>
</form>

@push('scripts')
<script>
let detailCount = {{ $asiento->detalleAsientos->count() }};
const addDetailRow = () => {
    detailCount++;
    const html = `
        <div class="grid grid-cols-12 gap-4 detail-row">
            <div class="col-span-5">
                <select name="detalle_asientos[${detailCount}][cuenta_analitica_id]" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-500">
                    <option value="">Seleccionar Cuenta</option>
                </select>
            </div>
            <div class="col-span-3">
                <input type="number" step="0.01" name="detalle_asientos[${detailCount}][debe]" placeholder="0.00" value="0.00"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-500 debe-input">
            </div>
            <div class="col-span-3">
                <input type="number" step="0.01" name="detalle_asientos[${detailCount}][haber]" placeholder="0.00" value="0.00"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-500 haber-input">
            </div>
            <div class="col-span-1">
                <button type="button" class="remove-row text-red-600 hover:text-red-800">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
    `;
    document.getElementById('detalles-container').insertAdjacentHTML('beforeend', html);
    updateTotals();
};

document.getElementById('add-detail').addEventListener('click', addDetailRow);

document.addEventListener('click', (e) => {
    if (e.target.closest('.remove-row')) {
        e.target.closest('.detail-row').remove();
        updateTotals();
    }
});

const updateTotals = () => {
    let totalDebe = 0;
    let totalHaber = 0;
    
    document.querySelectorAll('.debe-input').forEach(input => {
        totalDebe += parseFloat(input.value) || 0;
    });
    
    document.querySelectorAll('.haber-input').forEach(input => {
        totalHaber += parseFloat(input.value) || 0;
    });
    
    document.getElementById('total-debe').textContent = totalDebe.toFixed(2);
    document.getElementById('total-haber').textContent = totalHaber.toFixed(2);
    
    const diff = Math.abs(totalDebe - totalHaber);
    const statusEl = document.getElementById('balance-status');
    if (diff < 0.01) {
        statusEl.textContent = '✓ Balanceado';
        statusEl.className = 'text-sm text-green-600';
    } else {
        statusEl.textContent = `Diferencia: ${diff.toFixed(2)}`;
        statusEl.className = 'text-sm text-red-600';
    }
};

document.addEventListener('input', (e) => {
    if (e.target.classList.contains('debe-input') || e.target.classList.contains('haber-input')) {
        updateTotals();
    }
});

updateTotals();
</script>
@endpush
@endsection

