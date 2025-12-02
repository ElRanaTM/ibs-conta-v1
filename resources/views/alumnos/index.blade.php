@extends('layout.app')

@section('title', 'Alumnos')

@section('page-title', 'Alumnos')

@section('page-header')
<div class="flex items-center justify-between">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Alumnos</h1>
        <p class="text-gray-600 mt-1">Gestión de alumnos del sistema</p>
    </div>
    <a href="{{ route('alumnos.create') }}" class="bg-gray-900 text-white px-4 py-2 rounded-lg hover:bg-gray-800 transition-colors">
        <i class="fas fa-plus mr-2"></i>Nuevo Alumno
    </a>
</div>
@endsection

@section('content')
<div class="bg-white rounded-lg shadow-sm border border-gray-200">
    <div class="p-6 border-b border-gray-200">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between space-y-4 md:space-y-0">
            <div class="flex-1">
                <input type="text" placeholder="Buscar por código, nombre, CI..." 
                    class="w-full md:w-96 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-500 focus:border-transparent">
            </div>
            <div class="flex space-x-3">
                <select class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-500">
                    <option>Todos los estados</option>
                    <option>Activo</option>
                    <option>Inactivo</option>
                </select>
                <button class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                    <i class="fas fa-filter mr-2"></i>Filtrar
                </button>
            </div>
        </div>
    </div>
    
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Código</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre Completo</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">CI</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Celular</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($alumnos as $alumno)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $alumno->codigo }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $alumno->nombre_completo }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $alumno->ci ?? 'N/A' }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $alumno->celular ?? 'N/A' }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-center">
                        <span class="px-2 py-1 text-xs rounded-full {{ $alumno->estado == 'activo' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                            {{ ucfirst($alumno->estado) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <a href="{{ route('alumnos.show', $alumno->id_alumno) }}" class="text-gray-600 hover:text-gray-900 mr-4">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="{{ route('alumnos.edit', $alumno->id_alumno) }}" class="text-gray-600 hover:text-gray-900 mr-4">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('alumnos.destroy', $alumno->id_alumno) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('¿Estás seguro de eliminar este alumno?')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                        <i class="fas fa-user-graduate text-4xl mb-3 text-gray-400"></i>
                        <p>No hay alumnos registrados</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($alumnos->hasPages())
    <div class="px-6 py-4 border-t border-gray-200">
        {{ $alumnos->links() }}
    </div>
    @endif
</div>
@endsection

