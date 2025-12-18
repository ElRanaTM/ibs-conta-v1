@extends('layout.app')

@section('title', 'Asientos Contables')

@section('page-title', 'Asientos Contables')

@section('page-header')
<div class="flex items-center justify-between">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Asientos Contables</h1>
        <p class="text-gray-600 mt-1">Gestiona los asientos contables del sistema</p>
    </div>
    <a href="{{ route('contabilidad.asientos.create') }}" class="bg-gray-900 text-white px-4 py-2 rounded-lg hover:bg-gray-800 transition-colors flex items-center">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
        </svg>
        Nuevo Asiento
    </a>
</div>
@endsection

@section('content')
<div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
    <form method="GET" action="{{ route('contabilidad.asientos.index') }}" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-4">
        <div>
            <label for="numero" class="block text-sm font-medium text-gray-700 mb-2">Número</label>
            <input type="text" id="numero" name="numero" value="{{ request()->get('numero') }}"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-500"
                placeholder="Buscar por número">
        </div>
        <div>
            <label for="fecha_desde" class="block text-sm font-medium text-gray-700 mb-2">Desde</label>
            <input type="date" id="fecha_desde" name="fecha_desde" value="{{ request()->get('fecha_desde') }}"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-500">
        </div>
        <div>
            <label for="fecha_hasta" class="block text-sm font-medium text-gray-700 mb-2">Hasta</label>
            <input type="date" id="fecha_hasta" name="fecha_hasta" value="{{ request()->get('fecha_hasta') }}"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-500">
        </div>
        <div>
            <label for="glosa" class="block text-sm font-medium text-gray-700 mb-2">Glosa</label>
            <input type="text" id="glosa" name="glosa" value="{{ request()->get('glosa') }}"
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-500"
                placeholder="Buscar en glosa">
        </div>
        <div>
            <label for="estado" class="block text-sm font-medium text-gray-700 mb-2">Estado</label>
            <select id="estado" name="estado" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-500">
                <option value="">Todos</option>
                <option value="1" {{ request()->get('estado') == '1' ? 'selected' : '' }}>Activo</option>
                <option value="0" {{ request()->get('estado') == '0' ? 'selected' : '' }}>Inactivo</option>
            </select>
        </div>
        <div class="md:col-span-2 lg:col-span-3 xl:col-span-5 flex space-x-2">
            <button type="submit" class="px-6 py-2 bg-gray-900 text-white rounded-lg hover:bg-gray-800 transition-colors">
                <i class="fas fa-search mr-2"></i>Buscar
            </button>
            <a href="{{ route('contabilidad.asientos.index') }}" class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                <i class="fas fa-times mr-2"></i>Limpiar
            </a>
        </div>
    </form>
</div>

<div class="bg-white rounded-lg shadow-sm border border-gray-200">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Número</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Glosa</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Usuario</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($asientos as $asiento)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $asiento->numero_asiento }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $asiento->fecha->format('d/m/Y') }}</td>
                    <td class="px-6 py-4 text-sm text-gray-500">{{ Str::limit($asiento->glosa, 50) }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <form action="{{ route('contabilidad.asientos.toggle', $asiento->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="px-2 py-1 text-xs rounded-full focus:outline-none {{ $asiento->estado ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                {{ $asiento->estado ? 'Activo' : 'Inactivo' }}
                            </button>
                        </form>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $asiento->usuario->name ?? 'N/A' }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <a href="{{ route('contabilidad.asientos.show', $asiento->id) }}" class="text-gray-600 hover:text-gray-900 mr-4">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="{{ route('contabilidad.asientos.edit', $asiento->id) }}" class="text-gray-600 hover:text-gray-900 mr-4">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('contabilidad.asientos.destroy', $asiento->id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('¿Estás seguro de eliminar este asiento?')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                        <i class="fas fa-file-alt text-4xl mb-3 text-gray-400"></i>
                        <p>No hay asientos registrados</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($asientos->hasPages())
    <div class="px-6 py-4 border-t border-gray-200">
        {{ $asientos->links() }}
    </div>
    @endif
</div>
@endsection

