<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Ventas y Compras</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #000;
        }
        h2, h3 {
            text-align: center;
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        th, td {
            border: 1px solid #888;
            padding: 6px;
            text-align: left;
        }
        th {
            background-color: #f2c94c;
        }
        tfoot {
            font-weight: bold;
            background-color: #eee;
        }
    </style>
</head>
<body>
    <h2>📄 Reporte de Ventas y Compras</h2>
    <p><strong>Fecha del Reporte:</strong> {{ now()->format('d/m/Y H:i') }}</p>

    {{-- Sección de Ventas --}}
    <h3>🟢 Ingresos por Ventas</h3>
    <table>
        <thead>
            <tr>
                <th>Fecha</th>
                <th>Cliente</th>
                <th>Total</th>
                <th>Método de Pago</th>
                <th>Detalles</th>
            </tr>
        </thead>
        <tbody>
            @foreach($ventas as $venta)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($venta->fecha)->format('d/m/Y') }}</td>
                    <td>{{ $venta->cliente->nombre ?? 'Público' }}</td>
                    <td>{{ number_format($venta->total, 2) }} Bs</td>
                    <td>{{ ucfirst($venta->tipo_pago) }}</td>
                    <td>
                        @foreach($venta->detalles as $detalle)
                            • {{ $detalle->producto->nombre ?? $detalle->descripcion ?? 'Sin nombre' }} (x{{ $detalle->cantidad }})<br>
                        @endforeach
                    </td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="2">TOTAL INGRESOS</td>
                <td colspan="3">{{ number_format($totalIngresos, 2) }} Bs</td>
            </tr>
        </tfoot>
    </table>

    {{-- Sección de Compras --}}
    <h3 style="margin-top: 40px;">🔴 Egresos por Compras</h3>
    <table>
        <thead>
            <tr>
                <th>Fecha</th>
                <th>Proveedor</th>
                <th>Total</th>
                <th>Método de Pago</th>
                <th>Detalles</th>
            </tr>
        </thead>
        <tbody>
            @foreach($compras as $compra)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($compra->fecha)->format('d/m/Y') }}</td>
                    <td>{{ $compra->proveedor->nombre ?? 'Desconocido' }}</td>
                    <td>{{ number_format($compra->total, 2) }} Bs</td>
                    <td>{{ ucfirst($compra->metodo_pago) }}</td>
                    <td>
                        @foreach($compra->detalles as $detalle)
                            • {{ $detalle->producto->nombre ?? 'Sin nombre' }} (x{{ $detalle->cantidad }})<br>
                        @endforeach
                    </td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="2">TOTAL EGRESOS</td>
                <td colspan="3">{{ number_format($totalEgresos, 2) }} Bs</td>
            </tr>
        </tfoot>
    </table>

    {{-- Balance final --}}
    <h3 style="margin-top: 40px;">📊 Balance General</h3>
    <table>
        <tbody>
            <tr>
                <th>Total Ingresos</th>
                <td>{{ number_format($totalIngresos, 2) }} Bs</td>
            </tr>
            <tr>
                <th>Total Egresos</th>
                <td>{{ number_format($totalEgresos, 2) }} Bs</td>
            </tr>
            <tr>
                <th>Balance Neto</th>
                <td><strong>{{ number_format($balance, 2) }} Bs</strong></td>
            </tr>
        </tbody>
    </table>
</body>
</html>
