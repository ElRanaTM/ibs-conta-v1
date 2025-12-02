@extends('layout.app')

@section('title', 'Conceptos de Ingreso')

@section('page-title', 'Conceptos de Ingreso')

@section('page-header')
<div class="flex items-center justify-between">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Conceptos de Ingreso</h1>
        <p class="text-gray-600 mt-1">Gestión de conceptos de ingreso</p>
    </div>
    <a href="{{ route('catalogos.conceptos-ingreso.create') }}" class="bg-gray-900 text-white px-4 py-2 rounded-lg hover:bg-gray-800 transition-colors">
        <i class="fas fa-plus mr-2"></i>Nuevo Concepto
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
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tipo</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Monto Base</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($conceptos as $concepto)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $concepto->nombre }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $concepto->tipo }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-right">{{ number_format($concepto->monto_base, 2) }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <a href="{{ route('catalogos.conceptos-ingreso.edit', $concepto->id_concepto) }}" class="text-gray-600 hover:text-gray-900 mr-4">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('catalogos.conceptos-ingreso.destroy', $concepto->id_concepto) }}" method="POST" class="inline">
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
                    <td colspan="4" class="px-6 py-12 text-center text-gray-500">
                        <i class="fas fa-file-invoice-dollar text-4xl mb-3 text-gray-400"></i>
                        <p>No hay conceptos registrados</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
