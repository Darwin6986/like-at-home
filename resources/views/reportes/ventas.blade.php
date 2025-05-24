@extends('adminlte::page')

@section('title', 'Reporte de Ventas y Compras')

@section('content_header')
    <h1 class="text-warning text-center"><i class="fas fa-chart-line"></i> Reporte de Ingresos y Egresos</h1>
@endsection

@section('content')
    <style>
        .reporte-card {
            background-color: #1c1c1c;
            color: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 0 15px rgba(255, 204, 0, 0.1);
        }
        .form-label {
            color: #ffcc00;
        }
        .table-dark th {
            background-color: #1f1f1f;
            color: #ffcc00;
        }
        .table-dark td {
            background-color: #2a2a2a;
            color: white;
        }
        .btn-amarillo {
            background-color: #ffcc00;
            color: #121212;
        }
        .btn-amarillo:hover {
            background-color: #ffdd33;
        }
    </style>

    <div class="reporte-card">
        <form method="GET" action="{{ route('reportes.ventas') }}" class="row mb-4">
            <div class="col-md-4">
                <label class="form-label">Desde</label>
                <input type="date" name="desde" class="form-control" value="{{ request('desde') }}" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">Hasta</label>
                <input type="date" name="hasta" class="form-control" value="{{ request('hasta') }}" required>
            </div>
            <div class="col-md-4 d-flex align-items-end">
                <button class="btn btn-amarillo w-100" type="submit"><i class="fas fa-search"></i> Generar</button>
            </div>
        </form>

        @php
            $totalVentas = $ventas->sum('total');
            $totalCompras = $compras->sum('total');
            $balance = $totalVentas - $totalCompras;
        @endphp

        {{-- Ventas --}}
        @if(count($ventas))
            <h5 class="text-success">🟢 Ingresos por Ventas: {{ count($ventas) }} venta(s)</h5>
            <table class="table table-dark table-hover mb-5">
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Cliente</th>
                        <th>Método de Pago</th>
                        <th>Total</th>
                        <th>Productos</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($ventas as $venta)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($venta->fecha)->format('d/m/Y') }}</td>
                            <td>{{ $venta->cliente->nombre ?? 'Público' }}</td>
                            <td>{{ $venta->tipo_pago }}</td>
                            <td class="text-success">Bs {{ number_format($venta->total, 2) }}</td>
                            <td>
                                <ul>
                                    @foreach($venta->detalles as $detalle)
                                        <li>
                                            {{ $detalle->producto->nombre ?? $detalle->descripcion ?? 'Sin nombre' }} 
                                            x{{ $detalle->cantidad }} 
                                            (Bs {{ number_format($detalle->precio_venta ?? $detalle->precio, 2) }})
                                        </li>
                                    @endforeach
                                </ul>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="3" class="text-end">TOTAL VENTAS</th>
                        <th colspan="2" class="text-success">Bs {{ number_format($totalVentas, 2) }}</th>
                    </tr>
                </tfoot>
            </table>
        @endif

        {{-- Compras --}}
        @if(count($compras))
            <h5 class="text-danger">🔴 Egresos por Compras: {{ count($compras) }} compra(s)</h5>
            <table class="table table-dark table-hover mb-5">
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Proveedor</th>
                        <th>Método de Pago</th>
                        <th>Total</th>
                        <th>Productos</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($compras as $compra)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($compra->fecha)->format('d/m/Y') }}</td>
                            <td>{{ $compra->proveedor->nombre ?? 'Desconocido' }}</td>
                            <td>{{ ucfirst($compra->metodo_pago) }}</td>
                            <td class="text-danger">Bs {{ number_format($compra->total, 2) }}</td>
                            <td>
                                <ul>
                                    @foreach($compra->detalles as $detalle)
                                        <li>
                                            {{ $detalle->producto->nombre ?? 'Sin nombre' }} 
                                            x{{ $detalle->cantidad }}
                                        </li>
                                    @endforeach
                                </ul>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="3" class="text-end">TOTAL COMPRAS</th>
                        <th colspan="2" class="text-danger">Bs {{ number_format($totalCompras, 2) }}</th>
                    </tr>
                </tfoot>
            </table>
        @endif

        {{-- Balance final --}}
        @if(count($ventas) || count($compras))
            <h5 class="text-info">📊 Balance General</h5>
            <table class="table table-dark table-bordered">
                <tbody>
                    <tr>
                        <th>Total Ingresos</th>
                        <td class="text-success">Bs {{ number_format($totalVentas, 2) }}</td>
                    </tr>
                    <tr>
                        <th>Total Egresos</th>
                        <td class="text-danger">Bs {{ number_format($totalCompras, 2) }}</td>
                    </tr>
                    <tr>
                        <th>Balance Neto</th>
                        <td class="text-info fw-bold">Bs {{ number_format($balance, 2) }}</td>
                    </tr>
                </tbody>
            </table>
        @elseif(request()->filled('desde'))
            <div class="alert alert-warning">No se encontraron ingresos ni egresos en ese rango de fechas.</div>
        @endif

        {{-- Exportar --}}
        @if(request()->filled('desde') && request()->filled('hasta'))
            <div class="mb-3">
                <a href="{{ route('reportes.ventas.pdf', ['desde' => request('desde'), 'hasta' => request('hasta')]) }}" class="btn btn-danger me-2" target="_blank">
                    <i class="fas fa-file-pdf"></i> Descargar PDF
                </a>
                <a href="{{ route('reportes.ventas.excel', ['desde' => request('desde'), 'hasta' => request('hasta')]) }}" class="btn btn-success" target="_blank">
                    <i class="fas fa-file-excel"></i> Descargar Excel
                </a>
            </div>
        @endif
    </div>
@endsection
