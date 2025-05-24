@extends('adminlte::page')

@section('title', 'Detalle de Venta')

@section('content_header')
    <h1 class="text-warning text-center">
        <i class="fas fa-info-circle"></i> Detalle de Venta
    </h1>
@endsection

@section('content')
    <style>
        .detalle-box {
            background-color: #1c1c1c;
            padding: 25px;
            border-radius: 10px;
            color: #fff;
            box-shadow: 0 0 10px rgba(255, 204, 0, 0.2);
        }

        .detalle-box strong {
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

        .btn-volver {
            background-color: #ffcc00;
            color: #121212;
            font-weight: bold;
            border-radius: 8px;
        }

        .btn-volver:hover {
            background-color: #ffdd33;
        }
    </style>

    <div class="detalle-box mb-4">
        <p><strong>Cliente:</strong> {{ $venta->cliente->nombre ?? 'No registrado' }}</p>
        <p><strong>Usuario:</strong> {{ $venta->usuario->name ?? 'N/A' }}</p>
        <p><strong>Fecha:</strong> {{ \Carbon\Carbon::parse($venta->fecha)->format('d/m/Y') }}</p>
        <p><strong>Método de Pago:</strong> {{ ucfirst($venta->metodo_pago) }}</p>
        <p><strong>Total:</strong> Bs {{ number_format($venta->total, 2, ',', '.') }}</p>
    </div>

    <div class="table-responsive">
        <table class="table table-dark table-bordered table-hover">
            <thead>
                <tr>
                    <th>Producto / Menú</th>
                    <th>Cantidad</th>
                    <th>Precio (Bs)</th>
                    <th>Subtotal (Bs)</th>
                </tr>
            </thead>
            <tbody>
                @foreach($venta->detalles as $detalle)
                    <tr>
                        <td>
                            {{ $detalle->producto->nombre ?? $detalle->descripcion ?? 'Sin nombre' }}
                        </td>
                        <td>{{ $detalle->cantidad }}</td>
                        <td>Bs {{ number_format($detalle->precio_venta, 2, ',', '.') }}</td>
                        <td>Bs {{ number_format($detalle->subtotal, 2, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <a href="{{ route('ventas.index') }}" class="btn btn-volver mt-3">
        <i class="fas fa-arrow-left"></i> Volver al listado
    </a>
@endsection
