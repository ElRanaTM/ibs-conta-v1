@extends('layout.app')

@section('title', 'Períodos Académicos')

@section('page-title', 'Períodos Académicos')

@section('page-header')
<div class="flex items-center justify-between">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Períodos Académicos</h1>
        <p class="text-gray-600 mt-1">Gestión de períodos académicos del institución</p>
    </div>
    <a href="{{ route('catalogos.periodos-academicos.create') }}" class="bg-gray-900 text-white px-4 py-2 rounded-lg hover:bg-gray-800 transition-colors">
        <i class="fas fa-plus mr-2"></i>Nuevo Período
    </a>
</div>
@endsection

@section('content')
<div class="bg-white rounded-lg shadow-sm border border-gray-200">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre del Período</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha Inicio</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha Fin</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($periodos as $periodo)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $periodo->nombre_periodo }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $periodo->fecha_inicio->format('d/m/Y') }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $periodo->fecha_fin->format('d/m/Y') }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-center">
                        @if($periodo->activo)
                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                            Activo
                        </span>
                        @else
                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                            Inactivo
                        </span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <a href="{{ route('catalogos.periodos-academicos.edit', $periodo->id_periodo) }}" class="text-gray-600 hover:text-gray-900 mr-4">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('catalogos.periodos-academicos.destroy', $periodo->id_periodo) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('¿Estás seguro?')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                        <i class="fas fa-calendar-alt text-4xl mb-3 text-gray-400"></i>
                        <p>No hay períodos registrados</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
