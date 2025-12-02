@extends('layout.app')

@section('title', 'Métodos de Pago')

@section('page-title', 'Métodos de Pago')

@section('page-header')
<div class="flex items-center justify-between">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Métodos de Pago</h1>
        <p class="text-gray-600 mt-1">Gestión de métodos de pago disponibles</p>
    </div>
    <a href="{{ route('catalogos.metodos-pago.create') }}" class="bg-gray-900 text-white px-4 py-2 rounded-lg hover:bg-gray-800 transition-colors">
        <i class="fas fa-plus mr-2"></i>Nuevo Método
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
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Descripción</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($metodos as $metodo)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $metodo->nombre }}</td>
                    <td class="px-6 py-4 text-sm text-gray-500">{{ $metodo->descripcion }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <a href="{{ route('catalogos.metodos-pago.edit', $metodo->id_metodo) }}" class="text-gray-600 hover:text-gray-900 mr-4">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('catalogos.metodos-pago.destroy', $metodo->id_metodo) }}" method="POST" class="inline">
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
                    <td colspan="3" class="px-6 py-12 text-center text-gray-500">
                        <i class="fas fa-credit-card text-4xl mb-3 text-gray-400"></i>
                        <p>No hay métodos registrados</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
