@extends('layout.app')

@section('title', 'Sumas y Saldos - Imprimir')

@section('content')
<div class="p-6">
    <h2 class="text-lg font-bold mb-4">Sumas y Saldos - {{ $fechaDesde }} a {{ $fechaHasta }}</h2>

    <table class="min-w-full divide-y divide-gray-200 border">
        <thead>
            <tr>
                <th class="p-2">Código</th>
                <th class="p-2">Cuenta</th>
                <th class="p-2 text-right">Debe</th>
                <th class="p-2 text-right">Haber</th>
                <th class="p-2 text-right">Deudor</th>
                <th class="p-2 text-right">Acreedor</th>
                <th class="p-2 text-right">Egreso</th>
                <th class="p-2 text-right">Ingreso</th>
                <th class="p-2 text-right">Activo</th>
                <th class="p-2 text-right">Pasivo</th>
            </tr>
        </thead>
        <tbody>
            @foreach($sumasSaldos as $item)
            <tr>
                <td class="p-2">{{ $item['codigo'] }}</td>
                <td class="p-2">{{ $item['cuenta'] }}</td>
                <td class="p-2 text-right">{{ number_format($item['debe'],2) }}</td>
                <td class="p-2 text-right">{{ number_format($item['haber'],2) }}</td>
                <td class="p-2 text-right">{{ number_format($item['deudor'],2) }}</td>
                <td class="p-2 text-right">{{ number_format($item['acreedor'],2) }}</td>
                <td class="p-2 text-right">{{ number_format($item['egreso'],2) }}</td>
                <td class="p-2 text-right">{{ number_format($item['ingreso'],2) }}</td>
                <td class="p-2 text-right">{{ number_format($item['activo'],2) }}</td>
                <td class="p-2 text-right">{{ number_format($item['pasivo'],2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
