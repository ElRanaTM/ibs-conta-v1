@extends('layout.app')

@section('title', 'Plan de Cuentas - Gestión')

@section('page-title', 'Plan de Cuentas - Gestión')

@section('content')
<div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
    <div class="flex items-center justify-between mb-4">
        <h2 class="text-lg font-semibold">Cuentas (Gestión)</h2>
        <a href="{{ route('cuentas.plan-cuentas') }}" class="px-4 py-2 border rounded">Volver</a>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Código</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tipo</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($clases as $clase)
                    @foreach($clase->grupos as $grupo)
                        @foreach($grupo->subgrupos as $subgrupo)
                            @foreach($subgrupo->cuentasPrincipales as $principal)
                                @foreach($principal->cuentasAnaliticas as $analitica)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $analitica->codigo }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-900">{{ $analitica->nombre }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-500">Analítica</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <a href="{{ route('cuentas.edit', $analitica->id ?? '#') }}" class="text-gray-600 hover:text-gray-900 mr-4">Editar</a>
                                        <form action="{{ route('cuentas.destroy', $analitica->id ?? '#') }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900">Eliminar</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            @endforeach
                        @endforeach
                    @endforeach
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
