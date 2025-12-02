@extends('layout.app')

@section('title', 'Crear Nueva Cuenta')

@section('page-title', 'Crear Nueva Cuenta')

@section('page-header')
<div class="flex items-center justify-between">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Crear Nueva Cuenta</h1>
        <p class="text-gray-600 mt-1">Agrega una nueva cuenta al plan de cuentas</p>
    </div>
    <a href="{{ route('cuentas.plan-cuentas') }}" class="text-gray-600 hover:text-gray-900">
        <i class="fas fa-arrow-left mr-2"></i>Volver
    </a>
</div>
@endsection

@section('content')
<div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
    <form action="{{ route('cuentas.store') }}" method="POST" class="space-y-6">
        @csrf
        
        <!-- Tipo de Cuenta -->
        <div>
            <label for="tipo_cuenta" class="block text-sm font-medium text-gray-700">Tipo de Cuenta</label>
            <select 
                name="tipo_cuenta" 
                id="tipo_cuenta"
                onchange="actualizarCuentaPadre()"
                required
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-gray-500 focus:ring-gray-500 @error('tipo_cuenta') border-red-500 @else border @endif px-3 py-2"
            >
                <option value="">-- Selecciona un tipo --</option>
                <option value="clase" {{ old('tipo_cuenta') === 'clase' ? 'selected' : '' }}>Clase de Cuenta</option>
                <option value="grupo" {{ old('tipo_cuenta') === 'grupo' ? 'selected' : '' }}>Grupo</option>
                <option value="subgrupo" {{ old('tipo_cuenta') === 'subgrupo' ? 'selected' : '' }}>Subgrupo</option>
                <option value="principal" {{ old('tipo_cuenta') === 'principal' ? 'selected' : '' }}>Cuenta Principal</option>
                <option value="analitica" {{ old('tipo_cuenta') === 'analitica' ? 'selected' : '' }}>Cuenta Analítica</option>
            </select>
            @error('tipo_cuenta')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Código -->
        <div>
            <label for="codigo" class="block text-sm font-medium text-gray-700">Código</label>
            <input 
                type="text" 
                name="codigo" 
                id="codigo"
                value="{{ old('codigo') }}"
                required
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-gray-500 focus:ring-gray-500 @error('codigo') border-red-500 @else border @endif px-3 py-2"
                placeholder="Ej: 1000"
            >
            @error('codigo')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

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
                placeholder="Nombre de la cuenta"
            >
            @error('nombre')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Cuenta Padre -->
        <div id="parent_container" style="display: none;">
            <label for="parent_id" class="block text-sm font-medium text-gray-700">Cuenta Padre</label>
            <select 
                name="parent_id" 
                id="parent_id"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-gray-500 focus:ring-gray-500 @error('parent_id') border-red-500 @else border @endif px-3 py-2"
            >
                <option value="">-- Selecciona una cuenta padre --</option>
                
                <!-- Clases -->
                <optgroup label="Clases de Cuenta">
                    @foreach($clases as $clase)
                        <option value="{{ $clase->id_clase }}" data-tipo="grupo" {{ old('parent_id') == $clase->id_clase ? 'selected' : '' }}>
                            [{{ $clase->codigo }}] {{ $clase->nombre }}
                        </option>
                    @endforeach
                </optgroup>
                
                <!-- Grupos -->
                <optgroup label="Grupos">
                    @foreach($grupos as $grupo)
                        <option value="{{ $grupo->id_grupo }}" data-tipo="subgrupo" {{ old('parent_id') == $grupo->id_grupo ? 'selected' : '' }}>
                            [{{ $grupo->codigo }}] {{ $grupo->nombre }}
                        </option>
                    @endforeach
                </optgroup>
                
                <!-- Subgrupos -->
                <optgroup label="Subgrupos">
                    @foreach($subgrupos as $subgrupo)
                        <option value="{{ $subgrupo->id_subgrupo }}" data-tipo="principal" {{ old('parent_id') == $subgrupo->id_subgrupo ? 'selected' : '' }}>
                            [{{ $subgrupo->codigo }}] {{ $subgrupo->nombre }}
                        </option>
                    @endforeach
                </optgroup>
                
                <!-- Cuentas Principales -->
                <optgroup label="Cuentas Principales">
                    @foreach($cuentasPrincipales as $principal)
                        <option value="{{ $principal->id_cuenta_principal }}" data-tipo="analitica" {{ old('parent_id') == $principal->id_cuenta_principal ? 'selected' : '' }}>
                            [{{ $principal->codigo }}] {{ $principal->nombre }}
                        </option>
                    @endforeach
                </optgroup>
            </select>
            @error('parent_id')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Es Auxiliar -->
        <div id="es_auxiliar_container" style="display: none;">
            <div class="flex items-center">
                <input 
                    type="checkbox" 
                    name="es_auxiliar" 
                    id="es_auxiliar"
                    value="1"
                    {{ old('es_auxiliar') ? 'checked' : '' }}
                    class="h-4 w-4 rounded border-gray-300 text-gray-900 focus:ring-gray-500"
                >
                <label for="es_auxiliar" class="ml-2 block text-sm text-gray-700">
                    Es cuenta auxiliar
                </label>
            </div>
        </div>

        <!-- Botones -->
        <div class="flex items-center justify-between pt-6 border-t border-gray-200">
            <a href="{{ route('cuentas.plan-cuentas') }}" class="text-gray-600 hover:text-gray-900">Cancelar</a>
            <button type="submit" class="bg-gray-900 text-white px-6 py-2 rounded-lg hover:bg-gray-800 transition-colors">
                <i class="fas fa-save mr-2"></i>Guardar
            </button>
        </div>
    </form>
</div>

<script>
function actualizarCuentaPadre() {
    const tipo = document.getElementById('tipo_cuenta').value;
    const parentContainer = document.getElementById('parent_container');
    const esAuxiliarContainer = document.getElementById('es_auxiliar_container');
    const parentSelect = document.getElementById('parent_id');
    
    // Mostrar u ocultar contenedores según el tipo
    if (tipo === 'clase') {
        parentContainer.style.display = 'none';
        esAuxiliarContainer.style.display = 'none';
        parentSelect.removeAttribute('required');
    } else if (tipo === 'analitica') {
        parentContainer.style.display = 'block';
        esAuxiliarContainer.style.display = 'block';
        parentSelect.setAttribute('required', 'required');
    } else {
        parentContainer.style.display = 'block';
        esAuxiliarContainer.style.display = 'none';
        parentSelect.setAttribute('required', 'required');
    }
    
    // Filtrar opciones según el tipo seleccionado
    const opciones = parentSelect.querySelectorAll('option');
    opciones.forEach(opt => {
        if (opt.dataset.tipo === tipo || opt.value === '') {
            opt.style.display = 'block';
        } else {
            opt.style.display = 'none';
        }
    });
}

// Ejecutar al cargar la página
document.addEventListener('DOMContentLoaded', actualizarCuentaPadre);
</script>
@endsection
