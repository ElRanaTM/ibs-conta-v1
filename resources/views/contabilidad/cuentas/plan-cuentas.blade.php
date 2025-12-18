@extends('layout.app')

@section('title', 'Plan de Cuentas')

@section('page-title', 'Plan de Cuentas')

@section('page-header')
<div class="flex items-center justify-between">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Plan de Cuentas</h1>
        <p class="text-gray-600 mt-1">Estructura jerárquica de cuentas contables con saldos</p>
    </div>
    <div class="flex space-x-3">
        <button onclick="document.getElementById('modal-crear-cuenta').classList.remove('hidden')" class="px-4 py-2 bg-gray-900 text-white rounded-lg hover:bg-gray-800 transition-colors">
            <i class="fas fa-plus mr-2"></i>Crear Cuenta
        </button>
        <a href="{{ route('cuentas.plan-cuentas.manage') }}" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
            <i class="fas fa-exclamation-triangle mr-2"></i>Gestión (Editar/Borrar)
        </a>
        <!--
        <a href="{{ route('cuentas.plan-cuentas') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
            <i class="fas fa-file-pdf mr-2"></i>Exportar PDF
        </a>
        <a href="{{ route('cuentas.plan-cuentas') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
            <i class="fas fa-file-excel mr-2"></i>Exportar Excel
        </a>
        -->
    </div>
</div>
@endsection

@section('content')
<div class="bg-white rounded-lg shadow-sm border border-gray-200">
    <div class="p-6">
        <!-- Resumen de Totales -->
        <div class="mb-6 bg-gray-50 p-4 rounded-lg">
            <div class="flex justify-between items-center">
                <div class="flex items-center">
                    <i class="fas fa-chart-pie text-gray-500 mr-3"></i>
                    <div>
                        <h4 class="font-medium text-gray-700">Totales Generales</h4>
                        <p class="text-sm text-gray-500">Suma de todos los movimientos</p>
                    </div>
                </div>
                <div class="flex space-x-6">
                    <div class="text-right">
                        <div class="text-sm text-gray-500">Total Debe</div>
                        <div class="text-lg font-bold text-gray-900" id="total-global-debe">0.00</div>
                    </div>
                    <div class="text-right">
                        <div class="text-sm text-gray-500">Total Haber</div>
                        <div class="text-lg font-bold text-gray-900" id="total-global-haber">0.00</div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="mb-4 flex justify-between items-center">
            <input type="text" id="search-cuenta" placeholder="Buscar cuenta por código o nombre..." 
                class="w-full md:w-96 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-500 focus:border-transparent">
            <button id="toggle-saldo" class="ml-4 px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                <i class="fas fa-filter mr-2"></i>Mostrar Saldo Neto
            </button>
        </div>
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Código</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Debe</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Haber</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Saldo</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200" id="cuentas-body">
                    @php
                        $totalGlobalDebe = 0;
                        $totalGlobalHaber = 0;
                    @endphp
                    @forelse($clases as $clase)
                        @php
                            // Calcular totales para esta clase
                            $claseDebe = 0;
                            $claseHaber = 0;
                            
                            foreach($clase->grupos as $grupo) {
                                foreach($grupo->subgrupos as $subgrupo) {
                                    foreach($subgrupo->cuentasPrincipales as $principal) {
                                        foreach($principal->cuentasAnaliticas as $cuenta) {
                                            if(isset($saldos[$cuenta->id])) {
                                                $claseDebe += $saldos[$cuenta->id]['debe'];
                                                $claseHaber += $saldos[$cuenta->id]['haber'];
                                            }
                                        }
                                    }
                                }
                            }
                            
                            $totalGlobalDebe += $claseDebe;
                            $totalGlobalHaber += $claseHaber;
                        @endphp
                        
                        <!-- Clase -->
                        <tr class="bg-gray-100 font-bold">
                            <td class="px-6 py-3 text-sm text-gray-900">{{ $clase->codigo }}</td>
                            <td class="px-6 py-3 text-sm text-gray-900">{{ $clase->nombre }}</td>
                            <td class="px-6 py-3 text-sm text-gray-900 text-right">{{ number_format($claseDebe, 2) }}</td>
                            <td class="px-6 py-3 text-sm text-gray-900 text-right">{{ number_format($claseHaber, 2) }}</td>
                            <td class="px-6 py-3 text-sm text-gray-900 text-right">
                                @php
                                    $saldoClase = $claseDebe - $claseHaber;
                                    $color = $saldoClase > 0 ? 'text-green-600' : ($saldoClase < 0 ? 'text-red-600' : 'text-gray-600');
                                @endphp
                                <span class="{{ $color }}">{{ number_format(abs($saldoClase), 2) }}</span>
                                <span class="text-xs {{ $color }}">
                                    ({{ $saldoClase > 0 ? 'Deudor' : ($saldoClase < 0 ? 'Acreedor' : 'Cero') }})
                                </span>
                            </td>
                        </tr>
                        
                        @foreach($clase->grupos as $grupo)
                            @php
                                // Calcular totales para este grupo
                                $grupoDebe = 0;
                                $grupoHaber = 0;
                                
                                foreach($grupo->subgrupos as $subgrupo) {
                                    foreach($subgrupo->cuentasPrincipales as $principal) {
                                        foreach($principal->cuentasAnaliticas as $cuenta) {
                                            if(isset($saldos[$cuenta->id])) {
                                                $grupoDebe += $saldos[$cuenta->id]['debe'];
                                                $grupoHaber += $saldos[$cuenta->id]['haber'];
                                            }
                                        }
                                    }
                                }
                            @endphp
                            
                            <!-- Grupo -->
                            <tr class="bg-gray-50">
                                <td class="px-6 py-2 text-sm font-medium text-gray-700 pl-12">{{ $grupo->codigo }}</td>
                                <td class="px-6 py-2 text-sm font-medium text-gray-700">{{ $grupo->nombre }}</td>
                                <td class="px-6 py-2 text-sm text-gray-500 text-right">{{ number_format($grupoDebe, 2) }}</td>
                                <td class="px-6 py-2 text-sm text-gray-500 text-right">{{ number_format($grupoHaber, 2) }}</td>
                                <td class="px-6 py-2 text-sm text-gray-500 text-right">
                                    @php
                                        $saldoGrupo = $grupoDebe - $grupoHaber;
                                        $color = $saldoGrupo > 0 ? 'text-green-600' : ($saldoGrupo < 0 ? 'text-red-600' : 'text-gray-600');
                                    @endphp
                                    <span class="{{ $color }}">{{ number_format(abs($saldoGrupo), 2) }}</span>
                                </td>
                            </tr>
                            
                            @foreach($grupo->subgrupos as $subgrupo)
                                @php
                                    // Calcular totales para este subgrupo
                                    $subgrupoDebe = 0;
                                    $subgrupoHaber = 0;
                                    
                                    foreach($subgrupo->cuentasPrincipales as $principal) {
                                        foreach($principal->cuentasAnaliticas as $cuenta) {
                                            if(isset($saldos[$cuenta->id])) {
                                                $subgrupoDebe += $saldos[$cuenta->id]['debe'];
                                                $subgrupoHaber += $saldos[$cuenta->id]['haber'];
                                            }
                                        }
                                    }
                                @endphp
                                
                                <!-- Subgrupo -->
                                <tr>
                                    <td class="px-6 py-2 text-sm text-gray-600 pl-20">{{ $subgrupo->codigo }}</td>
                                    <td class="px-6 py-2 text-sm text-gray-600">{{ $subgrupo->nombre }}</td>
                                    <td class="px-6 py-2 text-sm text-gray-500 text-right">{{ number_format($subgrupoDebe, 2) }}</td>
                                    <td class="px-6 py-2 text-sm text-gray-500 text-right">{{ number_format($subgrupoHaber, 2) }}</td>
                                    <td class="px-6 py-2 text-sm text-gray-500 text-right">
                                        @php
                                            $saldoSubgrupo = $subgrupoDebe - $subgrupoHaber;
                                            $color = $saldoSubgrupo > 0 ? 'text-green-600' : ($saldoSubgrupo < 0 ? 'text-red-600' : 'text-gray-600');
                                        @endphp
                                        <span class="{{ $color }}">{{ number_format(abs($saldoSubgrupo), 2) }}</span>
                                    </td>
                                </tr>
                                
                                @foreach($subgrupo->cuentasPrincipales as $principal)
                                    @php
                                        // Calcular totales para esta cuenta principal
                                        $principalDebe = 0;
                                        $principalHaber = 0;
                                        
                                        foreach($principal->cuentasAnaliticas as $cuenta) {
                                            if(isset($saldos[$cuenta->id])) {
                                                $principalDebe += $saldos[$cuenta->id]['debe'];
                                                $principalHaber += $saldos[$cuenta->id]['haber'];
                                            }
                                        }
                                    @endphp
                                    
                                    <!-- Cuenta Principal -->
                                    <tr>
                                        <td class="px-6 py-2 text-sm text-gray-700 pl-28 font-medium">{{ $principal->codigo }}</td>
                                        <td class="px-6 py-2 text-sm text-gray-700">{{ $principal->nombre }}</td>
                                        <td class="px-6 py-2 text-sm text-gray-500 text-right">{{ number_format($principalDebe, 2) }}</td>
                                        <td class="px-6 py-2 text-sm text-gray-500 text-right">{{ number_format($principalHaber, 2) }}</td>
                                        <td class="px-6 py-2 text-sm text-gray-500 text-right">
                                            @php
                                                $saldoPrincipal = $principalDebe - $principalHaber;
                                                $color = $saldoPrincipal > 0 ? 'text-green-600' : ($saldoPrincipal < 0 ? 'text-red-600' : 'text-gray-600');
                                            @endphp
                                            <span class="{{ $color }}">{{ number_format(abs($saldoPrincipal), 2) }}</span>
                                        </td>
                                    </tr>
                                    
                                    @foreach($principal->cuentasAnaliticas as $analitica)
                                        @php
                                            $debe = isset($saldos[$analitica->id]) ? $saldos[$analitica->id]['debe'] : 0;
                                            $haber = isset($saldos[$analitica->id]) ? $saldos[$analitica->id]['haber'] : 0;
                                            $saldo = $debe - $haber;
                                            $color = $saldo > 0 ? 'text-green-600' : ($saldo < 0 ? 'text-red-600' : 'text-gray-600');
                                        @endphp
                                        
                                        <!-- Cuenta Analítica -->
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-6 py-1 text-sm text-gray-600 pl-36">{{ $analitica->codigo }}</td>
                                            <td class="px-6 py-1 text-sm text-gray-600">{{ $analitica->nombre }}</td>
                                            <td class="px-6 py-1 text-sm text-gray-500 text-right">{{ number_format($debe, 2) }}</td>
                                            <td class="px-6 py-1 text-sm text-gray-500 text-right">{{ number_format($haber, 2) }}</td>
                                            <td class="px-6 py-1 text-sm text-right">
                                                <span class="{{ $color }} font-medium">
                                                    {{ number_format(abs($saldo), 2) }}
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endforeach
                            @endforeach
                        @endforeach
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                            <i class="fas fa-sitemap text-4xl mb-3 text-gray-400"></i>
                            <p>No hay cuentas registradas</p>
                            <p class="text-sm text-gray-400 mt-2">Ejecuta los seeders para cargar el plan de cuentas</p>
                        </td>
                    </tr>
                    @endforelse
                    
                    <!-- Total General -->
                    <tr class="bg-gray-900 text-white font-bold">
                        <td class="px-6 py-3 text-sm" colspan="2">TOTAL GENERAL</td>
                        <td class="px-6 py-3 text-sm text-right">{{ number_format($totalGlobalDebe, 2) }}</td>
                        <td class="px-6 py-3 text-sm text-right">{{ number_format($totalGlobalHaber, 2) }}</td>
                        <td class="px-6 py-3 text-sm text-right">
                            @php
                                $saldoGlobal = $totalGlobalDebe - $totalGlobalHaber;
                                $color = $saldoGlobal > 0 ? 'text-green-300' : ($saldoGlobal < 0 ? 'text-red-300' : 'text-gray-300');
                            @endphp
                            <span class="{{ $color }}">
                                {{ number_format(abs($saldoGlobal), 2) }}
                            </span>
                        </td>
                    </tr>
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
document.addEventListener('DOMContentLoaded', function() {
    // Actualizar totales globales
    document.getElementById('total-global-debe').textContent = '{{ number_format($totalGlobalDebe, 2) }}';
    document.getElementById('total-global-haber').textContent = '{{ number_format($totalGlobalHaber, 2) }}';
    
    // Función de búsqueda
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
    
    // Alternar entre mostrar solo saldo neto
    document.getElementById('toggle-saldo').addEventListener('click', function() {
        const debeColumns = document.querySelectorAll('td:nth-child(3), th:nth-child(3)');
        const haberColumns = document.querySelectorAll('td:nth-child(4), th:nth-child(4)');
        const saldoColumns = document.querySelectorAll('td:nth-child(5), th:nth-child(5)');
        
        debeColumns.forEach(col => col.classList.toggle('hidden'));
        haberColumns.forEach(col => col.classList.toggle('hidden'));
        saldoColumns.forEach(col => col.classList.toggle('hidden'));
        
        this.textContent = this.textContent.includes('Mostrar') ? 
            'Mostrar Detalles' : 'Mostrar Saldo Neto';
    });
});

// Manejar cambio de tipo de cuenta (mantenido igual)
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