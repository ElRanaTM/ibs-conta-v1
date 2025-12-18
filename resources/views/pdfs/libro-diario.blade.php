<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $titulo }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
            margin: 0;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
        }
        .header h1 {
            margin: 0;
            font-size: 18px;
            font-weight: bold;
        }
        .header p {
            margin: 5px 0;
            font-size: 12px;
        }
        .asiento {
            margin-bottom: 20px;
            page-break-inside: avoid;
        }
        .asiento-header {
            background-color: #f0f0f0;
            padding: 5px;
            font-weight: bold;
            border: 1px solid #000;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
        }
        .table th, .table td {
            border: 1px solid #000;
            padding: 3px;
            text-align: left;
        }
        .table th {
            background-color: #f0f0f0;
            font-weight: bold;
        }
        .table .number {
            text-align: right;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
            border-top: 1px solid #000;
            padding-top: 10px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Sistema Contable IBS</h1>
        <h1>{{ $titulo }}</h1>
        <p>Del {{ \Carbon\Carbon::parse($fechaDesde)->format('d/m/Y') }} al {{ \Carbon\Carbon::parse($fechaHasta)->format('d/m/Y') }}</p>
    </div>

    @foreach($asientos as $asiento)
    <div class="asiento">
        <div class="asiento-header">
            Asiento: {{ $asiento->numero_asiento }} | Fecha: {{ $asiento->fecha->format('d/m/Y') }} | Glosa: {{ $asiento->glosa }}
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th>Cuenta</th>
                    <th>Glosa</th>
                    <th class="number">Debe</th>
                    <th class="number">Haber</th>
                </tr>
            </thead>
            <tbody>
                @foreach($asiento->detalleAsientos as $detalle)
                <tr>
                    <td>{{ $detalle->cuentaAnalitica->codigo }} - {{ $detalle->cuentaAnalitica->nombre }}</td>
                    <td>{{ $detalle->glosa ?? '' }}</td>
                    <td class="number">{{ number_format($detalle->debe, 2) }}</td>
                    <td class="number">{{ number_format($detalle->haber, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endforeach

    <div class="footer">
        <p>Reporte generado el {{ now()->format('d/m/Y H:i:s') }}</p>
        <p>Sistema Contable IBS - Todos los derechos reservados</p>
    </div>
</body>
</html>