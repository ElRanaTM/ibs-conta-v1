@extends('layout.app')

@section('title', 'Libro Diario - Imprimir')

@section('content')
<div class="p-6">
    <h2 class="text-lg font-bold mb-4">Libro Diario - {{ $fechaDesde }} a {{ $fechaHasta }}</h2>

    <table class="min-w-full divide-y divide-gray-200 border">
        <thead>
            <tr>
                <th class="p-2">Fecha</th>
                <th class="p-2">Número</th>
                <th class="p-2">Glosa</th>
                <th class="p-2">Cuenta</th>
                <th class="p-2">Glosa Detalle</th>
                <th class="p-2">Debe</th>
                <th class="p-2">Haber</th>
            </tr>
        </thead>
        <tbody>
            @foreach($asientos as $asiento)
                @foreach($asiento->detalleAsientos as $detalle)
                <tr>
                    <td class="p-2">{{ $asiento->fecha->format('d/m/Y') }}</td>
                    <td class="p-2">{{ $asiento->numero_asiento }}</td>
                    <td class="p-2">{{ $asiento->glosa }}</td>
                    <td class="p-2">{{ $detalle->cuentaAnalitica->codigo ?? '' }} - {{ $detalle->cuentaAnalitica->nombre ?? '' }}</td>
                    <td class="p-2">{{ $detalle->glosa ?? '' }}</td>
                    <td class="p-2 text-right">{{ number_format($detalle->debe,2) }}</td>
                    <td class="p-2 text-right">{{ number_format($detalle->haber,2) }}</td>
                </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>
</div>
@endsection
