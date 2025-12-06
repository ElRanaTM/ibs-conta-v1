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
            <button type="button" id="add-detail" class="text-sm bg-gray-900 text-white px-4 py-2 rounded-lg hover:bg-gray-800 transition-colors flex items-center">
                <i class="fas fa-plus mr-2"></i>Agregar Línea
            </button>
        </div>
        
        <div id="detalles-container" class="space-y-4">
            @foreach($asiento->detalleAsientos as $index => $detalle)
            <div class="grid grid-cols-12 gap-4 detail-row border border-gray-200 p-4 rounded-lg">
                <div class="col-span-12">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Buscar Cuenta</label>
                    <div class="relative">
                        <input type="text" 
                            id="cuenta-search-{{ $index }}" 
                            class="cuenta-search w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-500 focus:border-transparent"
                            placeholder="Buscar por código o nombre..."
                            value="{{ $detalle->cuentaAnalitica ? $detalle->cuentaAnalitica->codigo . ' - ' . $detalle->cuentaAnalitica->nombre : '' }}"
                            autocomplete="off">
                        <input type="hidden" name="detalle_asientos[{{ $index }}][cuenta_analitica_id]" class="cuenta-id-input" 
                            value="{{ $detalle->cuenta_analitica_id }}" required>
                        <div id="cuenta-results-{{ $index }}" class="hidden absolute z-10 w-full mt-1 bg-white border border-gray-300 rounded-lg shadow-lg max-h-60 overflow-y-auto">
                        </div>
                    </div>
                </div>
                <div class="col-span-12">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Glosa</label>
                    <input type="text" name="detalle_asientos[{{ $index }}][glosa]" 
                        value="{{ old('detalle_asientos.' . $index . '.glosa', $detalle->glosa) }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-500"
                        placeholder="Glosa del detalle">
                </div>
                <div class="col-span-5">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Debe</label>
                    <input type="number" step="0.01" name="detalle_asientos[{{ $index }}][debe]" 
                        value="{{ old('detalle_asientos.' . $index . '.debe', $detalle->debe) }}" 
                        placeholder="0.00"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-500 debe-input">
                </div>
                <div class="col-span-5">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Haber</label>
                    <input type="number" step="0.01" name="detalle_asientos[{{ $index }}][haber]" 
                        value="{{ old('detalle_asientos.' . $index . '.haber', $detalle->haber) }}" 
                        placeholder="0.00"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-500 haber-input">
                </div>
                <div class="col-span-2 flex items-end">
                    <button type="button" class="remove-row w-full text-red-600 hover:text-red-800 py-2">
                        <i class="fas fa-trash"></i>
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
                <span class="text-sm text-gray-500" id="balance-status"></span>
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
let detailCount = {{ $asiento->detalleAsientos->count() - 1 }};
let cuentasData = @json($cuentas->toArray());

const addDetailRow = () => {
    detailCount++;
    const html = `
        <div class="grid grid-cols-12 gap-4 detail-row border border-gray-200 p-4 rounded-lg">
            <div class="col-span-12">
                <label class="block text-sm font-medium text-gray-700 mb-2">Buscar Cuenta</label>
                <div class="relative">
                    <input type="text" 
                        id="cuenta-search-${detailCount}" 
                        class="cuenta-search w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-500 focus:border-transparent"
                        placeholder="Buscar por código o nombre..."
                        autocomplete="off">
                    <input type="hidden" name="detalle_asientos[${detailCount}][cuenta_analitica_id]" class="cuenta-id-input" required>
                    <div id="cuenta-results-${detailCount}" class="hidden absolute z-10 w-full mt-1 bg-white border border-gray-300 rounded-lg shadow-lg max-h-60 overflow-y-auto">
                    </div>
                </div>
            </div>
            <div class="col-span-12">
                <label class="block text-sm font-medium text-gray-700 mb-2">Glosa</label>
                <input type="text" name="detalle_asientos[${detailCount}][glosa]" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-500"
                    placeholder="Glosa del detalle">
            </div>
            <div class="col-span-5">
                <label class="block text-sm font-medium text-gray-700 mb-2">Debe</label>
                <input type="number" step="0.01" name="detalle_asientos[${detailCount}][debe]" placeholder="0.00" value="0.00"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-500 debe-input">
            </div>
            <div class="col-span-5">
                <label class="block text-sm font-medium text-gray-700 mb-2">Haber</label>
                <input type="number" step="0.01" name="detalle_asientos[${detailCount}][haber]" placeholder="0.00" value="0.00"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-500 haber-input">
            </div>
            <div class="col-span-2 flex items-end">
                <button type="button" class="remove-row w-full text-red-600 hover:text-red-800 py-2">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        </div>
    `;
    document.getElementById('detalles-container').insertAdjacentHTML('beforeend', html);
    setupCuentaSearch(detailCount);
    updateTotals();
};

const setupCuentaSearch = (rowId) => {
    const searchInput = document.getElementById(`cuenta-search-${rowId}`);
    const resultsDiv = document.getElementById(`cuenta-results-${rowId}`);
    const hiddenInput = searchInput.parentElement.querySelector('.cuenta-id-input');
    
    searchInput.addEventListener('input', (e) => {
        const query = e.target.value.toLowerCase();
        if (query.length < 2) {
            resultsDiv.classList.add('hidden');
            return;
        }
        
        const filtered = cuentasData.filter(cuenta => 
            cuenta.codigo.toLowerCase().includes(query) || 
            cuenta.nombre.toLowerCase().includes(query)
        );
        
        if (filtered.length > 0) {
            resultsDiv.innerHTML = filtered.map(cuenta => `
                <div class="px-4 py-2 hover:bg-gray-100 cursor-pointer cuenta-option" 
                     data-id="${cuenta.id}" 
                     data-codigo="${cuenta.codigo}" 
                     data-nombre="${cuenta.nombre}">
                    <div class="font-medium text-gray-900">${cuenta.codigo}</div>
                    <div class="text-sm text-gray-500">${cuenta.nombre}</div>
                </div>
            `).join('');
            resultsDiv.classList.remove('hidden');
        } else {
            resultsDiv.innerHTML = '<div class="px-4 py-2 text-gray-500">No se encontraron cuentas</div>';
            resultsDiv.classList.remove('hidden');
        }
    });
    
    resultsDiv.addEventListener('click', (e) => {
        const option = e.target.closest('.cuenta-option');
        if (option) {
            const id = option.dataset.id;
            const codigo = option.dataset.codigo;
            const nombre = option.dataset.nombre;
            searchInput.value = `${codigo} - ${nombre}`;
            hiddenInput.value = id;
            resultsDiv.classList.add('hidden');
        }
    });
    
    document.addEventListener('click', (e) => {
        if (!searchInput.contains(e.target) && !resultsDiv.contains(e.target)) {
            resultsDiv.classList.add('hidden');
        }
    });
};

// Inicializar búsqueda para filas existentes
document.querySelectorAll('.cuenta-search').forEach((input, index) => {
    setupCuentaSearch(index);
});

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

// Validación del formulario
document.querySelector('form').addEventListener('submit', function(e) {
    let isValid = true;
    const errorMessages = [];
    
    document.querySelectorAll('.detail-row').forEach((row, index) => {
        const debeInput = row.querySelector('.debe-input');
        const haberInput = row.querySelector('.haber-input');
        const cuentaInput = row.querySelector('.cuenta-id-input');
        
        const debe = parseFloat(debeInput.value) || 0;
        const haber = parseFloat(haberInput.value) || 0;
        const cuentaId = cuentaInput.value;
        
        if (!cuentaId) {
            isValid = false;
            errorMessages.push(`Fila ${index + 1}: Debe seleccionar una cuenta`);
            cuentaInput.closest('.relative').classList.add('border-red-500');
        } else {
            cuentaInput.closest('.relative').classList.remove('border-red-500');
        }
        
        if (debe <= 0 && haber <= 0) {
            isValid = false;
            errorMessages.push(`Fila ${index + 1}: Debe o Haber debe ser mayor a 0`);
            debeInput.classList.add('border-red-500');
            haberInput.classList.add('border-red-500');
        } else {
            debeInput.classList.remove('border-red-500');
            haberInput.classList.remove('border-red-500');
        }
        
        if (debeInput.value === '' || debeInput.value === null) {
            debeInput.value = '0';
        }
        if (haberInput.value === '' || haberInput.value === null) {
            haberInput.value = '0';
        }
    });
    
    if (!isValid) {
        e.preventDefault();
        alert('Por favor corrija los siguientes errores:\n\n' + errorMessages.join('\n'));
    }
});

updateTotals();
</script>
@endpush
@endsection