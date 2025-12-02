@extends('layout.app')

@section('title', 'Apoderados')

@section('page-title', 'Apoderados')

@section('page-header')
<div class="flex items-center justify-between">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Apoderados</h1>
        <p class="text-gray-600 mt-1">Gestión de apoderados del sistema</p>
    </div>
    <a href="{{ route('apoderados.create') }}" class="bg-gray-900 text-white px-4 py-2 rounded-lg hover:bg-gray-800 transition-colors">
        <i class="fas fa-plus mr-2"></i>Nuevo Apoderado
    </a>
</div>
@endsection

@section('content')
<div class="bg-white rounded-lg shadow-sm border border-gray-200">
    <div class="p-6 border-b border-gray-200">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between space-y-4 md:space-y-0">
            <div class="flex-1">
                <input type="text" placeholder="Buscar por nombre, CI..." 
                    class="w-full md:w-96 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-500 focus:border-transparent">
            </div>
            <button class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                <i class="fas fa-filter mr-2"></i>Filtrar
            </button>
        </div>
    </div>
    
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre Completo</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">CI</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Relación Legal</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Celular</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Alumnos</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($apoderados as $apoderado)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $apoderado->nombre_completo }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $apoderado->ci }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $apoderado->relacion_legal }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $apoderado->celular ?? 'N/A' }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        <span class="px-2 py-1 text-xs rounded-full bg-gray-100 text-gray-800">
                            {{ $apoderado->alumnos->count() }} alumno(s)
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <a href="{{ route('apoderados.show', $apoderado->id_apoderado) }}" class="text-gray-600 hover:text-gray-900 mr-4">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="{{ route('apoderados.edit', $apoderado->id_apoderado) }}" class="text-gray-600 hover:text-gray-900 mr-4">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('apoderados.destroy', $apoderado->id_apoderado) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('¿Estás seguro de eliminar este apoderado?')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                        <i class="fas fa-user-tie text-4xl mb-3 text-gray-400"></i>
                        <p>No hay apoderados registrados</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($apoderados->hasPages())
    <div class="px-6 py-4 border-t border-gray-200">
        {{ $apoderados->links() }}
    </div>
    @endif
</div>
@endsection

