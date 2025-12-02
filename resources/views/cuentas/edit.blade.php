@extends('layout.app')

@section('title', 'Editar Cuenta')

@section('page-title', 'Editar Cuenta')

@section('page-header')
<div class="flex items-center justify-between">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Editar Cuenta</h1>
        <p class="text-gray-600 mt-1">Modifica los datos de la cuenta del plan de cuentas</p>
    </div>
    <a href="{{ route('cuentas.plan-cuentas') }}" class="text-gray-600 hover:text-gray-900">
        <i class="fas fa-arrow-left mr-2"></i>Volver
    </a>
</div>
@endsection

@section('content')
<div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
    <form action="{{ route('cuentas.update', $cuenta->id) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')
        
        <!-- Tipo de Cuenta (readonly) -->
        <div>
            <label for="tipo_cuenta" class="block text-sm font-medium text-gray-700">Tipo de Cuenta</label>
            <input 
                type="text" 
                value="{{ ucfirst(str_replace(['_'], ' ', $tipo)) }}"
                readonly
                class="mt-1 block w-full rounded-md border border-gray-300 bg-gray-100 px-3 py-2 text-gray-600"
            >
            <input type="hidden" name="tipo_cuenta" value="{{ $tipo }}">
        </div>

        <!-- Código -->
        <div>
            <label for="codigo" class="block text-sm font-medium text-gray-700">Código</label>
            <input 
                type="text" 
                name="codigo" 
                id="codigo"
                value="{{ old('codigo', $cuenta->codigo) }}"
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
                value="{{ old('nombre', $cuenta->nombre) }}"
                required
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-gray-500 focus:ring-gray-500 @error('nombre') border-red-500 @else border @endif px-3 py-2"
                placeholder="Nombre de la cuenta"
            >
            @error('nombre')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Cuenta Padre (si aplica) -->
        @if($tipo !== 'clase')
        <div>
            <label for="parent_id" class="block text-sm font-medium text-gray-700">Cuenta Padre</label>
            <select 
                name="parent_id" 
                id="parent_id"
                required
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-gray-500 focus:ring-gray-500 @error('parent_id') border-red-500 @else border @endif px-3 py-2"
            >
                <option value="">-- Selecciona una cuenta padre --</option>
                
                @if($tipo === 'grupo')
                    @foreach($clases as $clase)
                        <option value="{{ $clase->id_clase }}" {{ old('parent_id', $cuenta->clase_id ?? null) == $clase->id_clase ? 'selected' : '' }}>
                            [{{ $clase->codigo }}] {{ $clase->nombre }}
                        </option>
                    @endforeach
                @elseif($tipo === 'subgrupo')
                    @foreach($grupos as $grupo)
                        <option value="{{ $grupo->id_grupo }}" {{ old('parent_id', $cuenta->grupo_id ?? null) == $grupo->id_grupo ? 'selected' : '' }}>
                            [{{ $grupo->codigo }}] {{ $grupo->nombre }}
                        </option>
                    @endforeach
                @elseif($tipo === 'principal')
                    @foreach($subgrupos as $subgrupo)
                        <option value="{{ $subgrupo->id_subgrupo }}" {{ old('parent_id', $cuenta->subgrupo_id ?? null) == $subgrupo->id_subgrupo ? 'selected' : '' }}>
                            [{{ $subgrupo->codigo }}] {{ $subgrupo->nombre }}
                        </option>
                    @endforeach
                @elseif($tipo === 'analitica')
                    @foreach($cuentasPrincipales as $principal)
                        <option value="{{ $principal->id_cuenta_principal }}" {{ old('parent_id', $cuenta->cuenta_principal_id ?? null) == $principal->id_cuenta_principal ? 'selected' : '' }}>
                            [{{ $principal->codigo }}] {{ $principal->nombre }}
                        </option>
                    @endforeach
                @endif
            </select>
            @error('parent_id')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
        @endif

        <!-- Es Auxiliar (solo para cuentas analíticas) -->
        @if($tipo === 'analitica')
        <div class="flex items-center">
            <input 
                type="checkbox" 
                name="es_auxiliar" 
                id="es_auxiliar"
                value="1"
                {{ old('es_auxiliar', $cuenta->es_auxiliar ?? false) ? 'checked' : '' }}
                class="h-4 w-4 rounded border-gray-300 text-gray-900 focus:ring-gray-500"
            >
            <label for="es_auxiliar" class="ml-2 block text-sm text-gray-700">
                Es cuenta auxiliar
            </label>
        </div>
        @endif

        <!-- Botones -->
        <div class="flex items-center justify-between pt-6 border-t border-gray-200">
            <div>
                <a href="{{ route('cuentas.plan-cuentas') }}" class="text-gray-600 hover:text-gray-900">Cancelar</a>
            </div>
            <div class="flex gap-3">
                <form action="{{ route('cuentas.destroy', $cuenta->id) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-600 text-white px-6 py-2 rounded-lg hover:bg-red-700 transition-colors" onclick="return confirm('¿Estás seguro de que deseas eliminar esta cuenta?')">
                        <i class="fas fa-trash mr-2"></i>Eliminar
                    </button>
                </form>
                <button type="submit" class="bg-gray-900 text-white px-6 py-2 rounded-lg hover:bg-gray-800 transition-colors">
                    <i class="fas fa-save mr-2"></i>Actualizar
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
