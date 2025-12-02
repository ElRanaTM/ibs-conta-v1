@extends('layout.app')

@section('title', 'Monedas')

@section('page-title', 'Monedas')

@section('page-header')
<div class="flex items-center justify-between">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Monedas</h1>
        <p class="text-gray-600 mt-1">Gestión de monedas del sistema</p>
    </div>
    <a href="{{ route('catalogos.monedas.create') }}" class="bg-gray-900 text-white px-4 py-2 rounded-lg hover:bg-gray-800 transition-colors">
        <i class="fas fa-plus mr-2"></i>Nueva Moneda
    </a>
</div>
@endsection

@section('content')
<div class="bg-white rounded-lg shadow-sm border border-gray-200">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Abreviatura</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Símbolo</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Moneda Local</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($monedas as $moneda)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $moneda->nombre }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $moneda->abreviatura }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $moneda->simbolo }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-center">
                        @if($moneda->es_local)
                            <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">
                                <i class="fas fa-check mr-1"></i>Sí
                            </span>
                        @else
                            <span class="px-2 py-1 text-xs rounded-full bg-gray-100 text-gray-800">No</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <a href="{{ route('catalogos.monedas.edit', $moneda->id_moneda) }}" class="text-gray-600 hover:text-gray-900 mr-4">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('catalogos.monedas.destroy', $moneda->id_moneda) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('¿Estás seguro de eliminar esta moneda?')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                        <i class="fas fa-coins text-4xl mb-3 text-gray-400"></i>
                        <p>No hay monedas registradas</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($monedas->hasPages())
    <div class="px-6 py-4 border-t border-gray-200">
        {{ $monedas->links() }}
    </div>
    @endif
</div>
@endsection

