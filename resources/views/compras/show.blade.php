@extends('adminlte::page')

@section('title', 'Detalle de Compra')

@section('content_header')
    <h1>Detalle de Compra</h1>
@endsection

@section('content')
    <div class="mb-3">
        <strong>Proveedor:</strong> {{ $compra->proveedor->nombre }}<br>
        <strong>Fecha:</strong> {{ $compra->fecha }}<br>
        <strong>Método de Pago:</strong> {{ ucfirst($compra->metodo_pago) }}<br>
        <strong>Total:</strong> Bs {{ number_format($compra->total, 2) }}
    </div>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Precio Compra</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($compra->detalles as $detalle)
                <tr>
                    <td>{{ $detalle->producto->nombre }}</td>
                    <td>{{ $detalle->cantidad }}</td>
                    <td>Bs {{ number_format($detalle->precio_compra, 2) }}</td>
                    <td>Bs {{ number_format($detalle->subtotal, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <a href="{{ route('compras.index') }}" class="btn btn-secondary mt-3">Volver</a>
@endsection
