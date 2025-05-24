@extends('adminlte::page')

@section('title', 'Ventas')

@section('content_header')
    <h1 class="text-warning text-center"><i class="fas fa-receipt"></i> Listado de Ventas</h1>
@endsection

@section('content')
    <style>
        body {
            background-color: #121212 !important;
        }

        .venta-card {
            background-color: #1c1c1c;
            color: #fff;
            border: 2px solid #ffcc00;
            border-radius: 12px;
            box-shadow: 0 0 10px rgba(255, 204, 0, 0.2);
            padding: 20px;
        }

        .btn-amarillo {
            background-color: #ffcc00;
            color: #121212;
        }

        .btn-amarillo:hover {
            background-color: #ffdd33;
        }

        .btn-rojo {
            background-color: #ff4444;
            color: white;
        }

        .btn-rojo:hover {
            background-color: #cc0000;
        }

        .table-dark th {
            background-color: #1f1f1f;
            color: #ffcc00;
        }

        .table-dark td {
            background-color: #2a2a2a;
            color: white;
        }
    </style>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="mb-3 d-flex justify-content-end">
        <a href="{{ route('ventas.create') }}" class="btn btn-amarillo">
            <i class="fas fa-plus"></i> Nueva Venta
        </a>
    </div>

    <div class="venta-card">
        <table class="table table-dark table-hover">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Cliente</th>
                    <th>Fecha</th>
                    <th>Tipo de Pago</th>
                    <th>Total (Bs)</th>
                    <th>Usuario</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($ventas as $venta)
                    <tr>
                        <td>{{ $venta->id }}</td>
                        <td>{{ $venta->cliente->nombre ?? 'Sin cliente' }}</td>
                        <td>{{ \Carbon\Carbon::parse($venta->fecha)->format('d/m/Y') }}</td>
                        <td>{{ $venta->metodo_pago }}</td>
                        <td class="text-success">Bs {{ number_format($venta->total, 2) }}</td>
                        <td>{{ $venta->usuario->name ?? 'N/A' }}</td>
                        <td class="d-flex">
                            <a href="{{ route('ventas.show', $venta) }}" class="btn btn-sm btn-amarillo me-2">
                                <i class="fas fa-eye"></i> Ver
                            </a>
                            <form action="{{ route('ventas.destroy', $venta) }}" method="POST" onsubmit="return confirm('¿Deseas eliminar esta venta?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-rojo">
                                    <i class="fas fa-trash"></i> Eliminar
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted">No hay ventas registradas aún.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-3">
            {{ $ventas->links() }}
        </div>
    </div>
@endsection
