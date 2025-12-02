@extends('layout.app')

@section('title', 'Plan de Cuentas')

@section('page-title', 'Plan de Cuentas')

@section('page-header')
<div class="flex items-center justify-between">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Plan de Cuentas</h1>
        <p class="text-gray-600 mt-1">Estructura jerárquica de cuentas contables</p>
    </div>
    <div class="flex space-x-3">
        <button onclick="document.getElementById('modal-crear-cuenta').classList.remove('hidden')" class="px-4 py-2 bg-gray-900 text-white rounded-lg hover:bg-gray-800 transition-colors">
            <i class="fas fa-plus mr-2"></i>Crear Cuenta
        </button>
        <button class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
            <i class="fas fa-file-pdf mr-2"></i>Exportar PDF
        </button>
        <button class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
            <i class="fas fa-file-excel mr-2"></i>Exportar Excel
        </button>
    </div>
</div>
@endsection

@section('content')
<div class="bg-white rounded-lg shadow-sm border border-gray-200">
    <div class="p-6">
        <div class="mb-4">
            <input type="text" id="search-cuenta" placeholder="Buscar cuenta por código o nombre..." 
                class="w-full md:w-96 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-500 focus:border-transparent">
        </div>
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Código</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Saldo Deudor</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Saldo Acreedor</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200" id="cuentas-body">
                    @forelse($clases as $clase)
                        <!-- Clase -->
                        <tr class="bg-gray-100 font-bold">
                            <td class="px-6 py-3 text-sm text-gray-900">{{ $clase->codigo }}</td>
                            <td class="px-6 py-3 text-sm text-gray-900">{{ $clase->nombre }}</td>
                            <td class="px-6 py-3 text-sm text-gray-900 text-right">-</td>
                            <td class="px-6 py-3 text-sm text-gray-900 text-right">-</td>
                        </tr>
                        
                        @foreach($clase->grupos as $grupo)
                            <!-- Grupo -->
                            <tr class="bg-gray-50">
                                <td class="px-6 py-2 text-sm font-medium text-gray-700 pl-12">{{ $grupo->codigo }}</td>
                                <td class="px-6 py-2 text-sm font-medium text-gray-700">{{ $grupo->nombre }}</td>
                                <td class="px-6 py-2 text-sm text-gray-500 text-right">-</td>
                                <td class="px-6 py-2 text-sm text-gray-500 text-right">-</td>
                            </tr>
                            
                            @foreach($grupo->subgrupos as $subgrupo)
                                <!-- Subgrupo -->
                                <tr>
                                    <td class="px-6 py-2 text-sm text-gray-600 pl-20">{{ $subgrupo->codigo }}</td>
                                    <td class="px-6 py-2 text-sm text-gray-600">{{ $subgrupo->nombre }}</td>
                                    <td class="px-6 py-2 text-sm text-gray-500 text-right">-</td>
                                    <td class="px-6 py-2 text-sm text-gray-500 text-right">-</td>
                                </tr>
                                
                                @foreach($subgrupo->cuentasPrincipales as $principal)
                                    <!-- Cuenta Principal -->
                                    <tr>
                                        <td class="px-6 py-2 text-sm text-gray-700 pl-28 font-medium">{{ $principal->codigo }}</td>
                                        <td class="px-6 py-2 text-sm text-gray-700">{{ $principal->nombre }}</td>
                                        <td class="px-6 py-2 text-sm text-gray-500 text-right">0.00</td>
                                        <td class="px-6 py-2 text-sm text-gray-500 text-right">0.00</td>
                                    </tr>
                                    
                                    @foreach($principal->cuentasAnaliticas as $analitica)
                                        <!-- Cuenta Analítica -->
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-6 py-1 text-sm text-gray-600 pl-36">{{ $analitica->codigo }}</td>
                                            <td class="px-6 py-1 text-sm text-gray-600">{{ $analitica->nombre }}</td>
                                            <td class="px-6 py-1 text-sm text-gray-500 text-right">0.00</td>
                                            <td class="px-6 py-1 text-sm text-gray-500 text-right">0.00</td>
                                        </tr>
                                    @endforeach
                                @endforeach
                            @endforeach
                        @endforeach
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-12 text-center text-gray-500">
                            <i class="fas fa-sitemap text-4xl mb-3 text-gray-400"></i>
                            <p>No hay cuentas registradas</p>
                            <p class="text-sm text-gray-400 mt-2">Ejecuta los seeders para cargar el plan de cuentas</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Crear Cuenta -->
<div id="modal-crear-cuenta" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-2/3 lg:w-1/2 shadow-lg rounded-md bg-white">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-bold text-gray-900">Crear Nueva Cuenta</h3>
            <button onclick="document.getElementById('modal-crear-cuenta').classList.add('hidden')" class="text-gray-400 hover:text-gray-600">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <form action="{{ route('cuentas.store') }}" method="POST">
            @csrf
            <div class="space-y-4">
                <div>
                    <label for="tipo_cuenta" class="block text-sm font-medium text-gray-700 mb-2">Tipo de Cuenta *</label>
                    <select name="tipo_cuenta" id="tipo_cuenta" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-500">
                        <option value="">Seleccionar tipo</option>
                        <option value="clase">Clase</option>
                        <option value="grupo">Grupo</option>
                        <option value="subgrupo">Subgrupo</option>
                        <option value="principal">Cuenta Principal</option>
                        <option value="analitica">Cuenta Analítica</option>
                    </select>
                </div>
                
                <div id="parent-select-container" class="hidden">
                    <label for="parent_id" class="block text-sm font-medium text-gray-700 mb-2">Cuenta Padre *</label>
                    <select name="parent_id" id="parent_id"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-500">
                    </select>
                </div>
                
                <div>
                    <label for="codigo" class="block text-sm font-medium text-gray-700 mb-2">Código *</label>
                    <input type="text" name="codigo" id="codigo" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-500"
                        placeholder="Ej: 111001">
                </div>
                
                <div>
                    <label for="nombre" class="block text-sm font-medium text-gray-700 mb-2">Nombre *</label>
                    <input type="text" name="nombre" id="nombre" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-500"
                        placeholder="Nombre de la cuenta">
                </div>
                
                <div id="es-auxiliar-container" class="hidden">
                    <label class="flex items-center">
                        <input type="checkbox" name="es_auxiliar" value="1" checked
                            class="rounded border-gray-300 text-gray-600 focus:ring-gray-500">
                        <span class="ml-2 text-sm text-gray-700">Es cuenta auxiliar</span>
                    </label>
                </div>
            </div>
            
            <div class="flex justify-end space-x-4 mt-6">
                <button type="button" onclick="document.getElementById('modal-crear-cuenta').classList.add('hidden')" 
                    class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                    Cancelar
                </button>
                <button type="submit" class="px-4 py-2 bg-gray-900 text-white rounded-lg hover:bg-gray-800">
                    <i class="fas fa-save mr-2"></i>Guardar
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
document.getElementById('search-cuenta').addEventListener('input', function(e) {
    const searchTerm = e.target.value.toLowerCase();
    const rows = document.querySelectorAll('#cuentas-body tr');
    
    rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        if (text.includes(searchTerm)) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
});

// Manejar cambio de tipo de cuenta
document.getElementById('tipo_cuenta').addEventListener('change', function(e) {
    const tipo = e.target.value;
    const parentContainer = document.getElementById('parent-select-container');
    const auxiliarContainer = document.getElementById('es-auxiliar-container');
    const parentSelect = document.getElementById('parent_id');
    
    parentContainer.classList.add('hidden');
    auxiliarContainer.classList.add('hidden');
    parentSelect.innerHTML = '';
    parentSelect.required = false;
    
    if (tipo === 'grupo') {
        parentContainer.classList.remove('hidden');
        parentSelect.required = true;
        parentSelect.innerHTML = '<option value="">Seleccionar Clase</option>';
        @foreach(\App\Models\ClaseCuenta::all() as $clase)
        parentSelect.innerHTML += '<option value="{{ $clase->id }}">{{ $clase->codigo }} - {{ $clase->nombre }}</option>';
        @endforeach
    } else if (tipo === 'subgrupo') {
        parentContainer.classList.remove('hidden');
        parentSelect.required = true;
        parentSelect.innerHTML = '<option value="">Seleccionar Grupo</option>';
        @foreach(\App\Models\Grupo::all() as $grupo)
        parentSelect.innerHTML += '<option value="{{ $grupo->id }}">{{ $grupo->codigo }} - {{ $grupo->nombre }}</option>';
        @endforeach
    } else if (tipo === 'principal') {
        parentContainer.classList.remove('hidden');
        parentSelect.required = true;
        parentSelect.innerHTML = '<option value="">Seleccionar Subgrupo</option>';
        @foreach(\App\Models\Subgrupo::all() as $subgrupo)
        parentSelect.innerHTML += '<option value="{{ $subgrupo->id }}">{{ $subgrupo->codigo }} - {{ $subgrupo->nombre }}</option>';
        @endforeach
    } else if (tipo === 'analitica') {
        parentContainer.classList.remove('hidden');
        auxiliarContainer.classList.remove('hidden');
        parentSelect.required = true;
        parentSelect.innerHTML = '<option value="">Seleccionar Cuenta Principal</option>';
        @foreach(\App\Models\CuentaPrincipal::all() as $principal)
        parentSelect.innerHTML += '<option value="{{ $principal->id }}">{{ $principal->codigo }} - {{ $principal->nombre }}</option>';
        @endforeach
    }
});
</script>
@endpush
@endsection

