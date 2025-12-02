@extends('layout.app')

@section('title', 'Categorías de Egreso')

@section('page-title', 'Categorías de Egreso')

@section('page-header')
<div class="flex items-center justify-between">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Categorías de Egreso</h1>
        <p class="text-gray-600 mt-1">Gestión de categorías de egresos</p>
    </div>
    <a href="{{ route('catalogos.categorias-egreso.create') }}" class="bg-gray-900 text-white px-4 py-2 rounded-lg hover:bg-gray-800 transition-colors">
        <i class="fas fa-plus mr-2"></i>Nueva Categoría
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
                @forelse($categorias as $categoria)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $categoria->nombre }}</td>
                    <td class="px-6 py-4 text-sm text-gray-500">{{ Str::limit($categoria->descripcion ?? '-', 50) }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <a href="{{ route('catalogos.categorias-egreso.edit', $categoria->id_categoria) }}" class="text-gray-600 hover:text-gray-900 mr-4">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('catalogos.categorias-egreso.destroy', $categoria->id_categoria) }}" method="POST" class="inline">
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
                        <i class="fas fa-folder text-4xl mb-3 text-gray-400"></i>
                        <p>No hay categorías registradas</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
