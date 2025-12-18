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
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .table th, .table td {
            border: 1px solid #000;
            padding: 5px;
            text-align: left;
        }
        .table th {
            background-color: #f0f0f0;
            font-weight: bold;
        }
        .table .number {
            text-align: right;
        }
        .totals {
            font-weight: bold;
            background-color: #e0e0e0;
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

    <table class="table">
        <thead>
            <tr>
                <th>Código</th>
                <th>Cuenta</th>
                <th class="number">Debe</th>
                <th class="number">Haber</th>
                <th class="number">Saldo Deudor</th>
                <th class="number">Saldo Acreedor</th>
            </tr>
        </thead>
        <tbody>
            @foreach($cuentas as $cuenta)
            <tr>
                <td>{{ $cuenta['codigo'] }}</td>
                <td>{{ $cuenta['nombre'] }}</td>
                <td class="number">{{ number_format($cuenta['debe'], 2) }}</td>
                <td class="number">{{ number_format($cuenta['haber'], 2) }}</td>
                <td class="number">{{ number_format($cuenta['saldo_deudor'], 2) }}</td>
                <td class="number">{{ number_format($cuenta['saldo_acreedor'], 2) }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr class="totals">
                <td colspan="2">TOTALES:</td>
                <td class="number">{{ number_format($totalDebe, 2) }}</td>
                <td class="number">{{ number_format($totalHaber, 2) }}</td>
                <td class="number">{{ number_format($totalSaldoDeudor, 2) }}</td>
                <td class="number">{{ number_format($totalSaldoAcreedor, 2) }}</td>
            </tr>
        </tfoot>
    </table>

    <div class="footer">
        <p>Reporte generado el {{ now()->format('d/m/Y H:i:s') }}</p>
        <p>Sistema Contable IBS - Todos los derechos reservados</p>
    </div>
</body>
</html>