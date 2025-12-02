@extends('layout.app')

@section('title', 'Crear Asiento Contable')

@section('page-title', 'Crear Asiento Contable')

@section('page-header')
<div>
    <h1 class="text-2xl font-bold text-gray-900">Crear Asiento Contable</h1>
    <p class="text-gray-600 mt-1">Registra un nuevo asiento contable</p>
</div>
@endsection

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
    <div class="lg:col-span-3">
        <form action="{{ route('contabilidad.asientos.store') }}" method="POST" class="space-y-6">
            @csrf
            
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Información General</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="fecha" class="block text-sm font-medium text-gray-700 mb-2">Fecha</label>
                        <input type="date" name="fecha" id="fecha" value="{{ old('fecha', date('Y-m-d')) }}" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-500 focus:border-transparent">
                    </div>
                    
                    <div>
                        <label for="usuario_id" class="block text-sm font-medium text-gray-700 mb-2">Usuario</label>
                        <input type="hidden" name="usuario_id" value="{{ auth()->id() }}">
                        <input type="text" value="{{ auth()->user()->name }}" disabled
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-50 text-gray-500">
                    </div>
                </div>
                
                <div class="mt-6">
                    <label for="glosa" class="block text-sm font-medium text-gray-700 mb-2">Glosa</label>
                    <textarea name="glosa" id="glosa" rows="3" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-500 focus:border-transparent"
                        placeholder="Descripción del asiento contable">{{ old('glosa') }}</textarea>
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
                    <!-- Detalles se agregarán dinámicamente -->
                </div>
                
                <div class="mt-6 pt-6 border-t border-gray-200">
                    <div class="flex justify-between items-center">
                        <div>
                            <span class="text-sm font-medium text-gray-700">Total Debe:</span>
                            <span class="text-lg font-bold text-gray-900 ml-2" id="total-debe" value="0.00">0.00</span>
                        </div>
                        <div>
                            <span class="text-sm font-medium text-gray-700">Total Haber:</span>
                            <span class="text-lg font-bold text-gray-900 ml-2" id="total-haber" value="0.00">0.00</span>
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
                    Guardar Asiento
                </button>
            </div>
        </form>
    </div>
    
    <div class="lg:col-span-1">
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 sticky top-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Tipos de Cambio</h3>
            <div id="tipos-cambio" class="space-y-3">
                <p class="text-sm text-gray-500">Selecciona una fecha para ver los tipos de cambio</p>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
let detailCount = 0;
let cuentasData = @json(\App\Models\CuentaAnalitica::select('id', 'codigo', 'nombre')->get()->toArray());

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


// Agregar validación antes del envío del formulario
document.querySelector('form').addEventListener('submit', function(e) {
    let isValid = true;
    const errorMessages = [];
    
    // Validar que cada fila tenga al menos Debe o Haber mayor a 0
    document.querySelectorAll('.detail-row').forEach((row, index) => {
        const debeInput = row.querySelector('.debe-input');
        const haberInput = row.querySelector('.haber-input');
        const cuentaInput = row.querySelector('.cuenta-id-input');
        
        const debe = parseFloat(debeInput.value) || 0;
        const haber = parseFloat(haberInput.value) || 0;
        const cuentaId = cuentaInput.value;
        
        // Validar que se haya seleccionado una cuenta
        if (!cuentaId) {
            isValid = false;
            errorMessages.push(`Fila ${index + 1}: Debe seleccionar una cuenta`);
            cuentaInput.closest('.relative').classList.add('border-red-500');
        } else {
            cuentaInput.closest('.relative').classList.remove('border-red-500');
        }
        
        // Validar que Debe o Haber sea mayor a 0
        if (debe <= 0 && haber <= 0) {
            isValid = false;
            errorMessages.push(`Fila ${index + 1}: Debe o Haber debe ser mayor a 0`);
            debeInput.classList.add('border-red-500');
            haberInput.classList.add('border-red-500');
        } else {
            debeInput.classList.remove('border-red-500');
            haberInput.classList.remove('border-red-500');
        }
        
        // Asegurar que los valores vacíos se conviertan a 0
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

// Cargar tipos de cambio
const fechaInput = document.getElementById('fecha');
const cargarTiposCambio = async () => {
    const fecha = fechaInput.value;
    if (!fecha) return;
    
    try {
        const response = await fetch(`/api/tipos-cambio?fecha=${fecha}`);
        const data = await response.json();
        const container = document.getElementById('tipos-cambio');
        
        if (data.length > 0) {
            container.innerHTML = data.map(tc => `
                <div class="border-b border-gray-200 pb-2">
                    <div class="text-sm font-medium text-gray-900">${tc.moneda.simbolo} ${tc.moneda.nombre}</div>
                    <div class="text-xs text-gray-500">1 ${tc.moneda.abreviatura} = ${tc.valor} Bs</div>
                </div>
            `).join('');
        } else {
            container.innerHTML = '<p class="text-sm text-gray-500">No hay tipos de cambio para esta fecha</p>';
        }
    } catch (error) {
        console.error('Error al cargar tipos de cambio:', error);
    }
};

fechaInput.addEventListener('change', cargarTiposCambio);
cargarTiposCambio();

// Agregar primera fila al cargar
addDetailRow();


//testing
// En create.blade.php, dentro del script, modifica el submit del formulario:
document.querySelector('form').addEventListener('submit', function(e) {
    console.log('=== FORM SUBMIT INICIADO ===');
    console.log('Form data antes de validar:');
    
    // Mostrar todos los datos del formulario
    const formData = new FormData(this);
    for (let [key, value] of formData.entries()) {
        console.log(`${key}: ${value}`);
    }
    
    // Validar que cada fila tenga al menos Debe o Haber mayor a 0
    let isValid = true;
    const errorMessages = [];
    
    document.querySelectorAll('.detail-row').forEach((row, index) => {
        const debeInput = row.querySelector('.debe-input');
        const haberInput = row.querySelector('.haber-input');
        const cuentaInput = row.querySelector('.cuenta-id-input');
        
        const debe = parseFloat(debeInput.value) || 0;
        const haber = parseFloat(haberInput.value) || 0;
        const cuentaId = cuentaInput.value;
        
        console.log(`Fila ${index + 1}:`, {
            cuentaId: cuentaId,
            debe: debe,
            haber: haber
        });
        
        // Validar que se haya seleccionado una cuenta
        if (!cuentaId) {
            isValid = false;
            errorMessages.push(`Fila ${index + 1}: Debe seleccionar una cuenta`);
            cuentaInput.closest('.relative').classList.add('border-red-500');
        } else {
            cuentaInput.closest('.relative').classList.remove('border-red-500');
        }
        
        // Validar que Debe o Haber sea mayor a 0
        if (debe <= 0 && haber <= 0) {
            isValid = false;
            errorMessages.push(`Fila ${index + 1}: Debe o Haber debe ser mayor a 0`);
            debeInput.classList.add('border-red-500');
            haberInput.classList.add('border-red-500');
        } else {
            debeInput.classList.remove('border-red-500');
            haberInput.classList.remove('border-red-500');
        }
        
        // Asegurar que los valores vacíos se conviertan a 0
        if (debeInput.value === '' || debeInput.value === null) {
            debeInput.value = '0';
        }
        if (haberInput.value === '' || haberInput.value === null) {
            haberInput.value = '0';
        }
    });
    
    if (!isValid) {
        e.preventDefault();
        console.log('Errores de validación:', errorMessages);
        alert('Por favor corrija los siguientes errores:\n\n' + errorMessages.join('\n'));
    } else {
        console.log('=== FORM VALIDADO, ENVIANDO... ===');
    }
});
</script>
@endpush
@endsection
