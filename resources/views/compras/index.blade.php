@extends('adminlte::page')

@section('title', 'Compras')

@section('content_header')
    <h1 class="text-warning text-center"><i class="fas fa-cart-arrow-down"></i> Compras</h1>
@endsection

@section('content')
    <style>
        body {
            background-color: #121212 !important;
        }

        .compra-card {
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
        <a href="{{ route('compras.create') }}" class="btn btn-amarillo">
            <i class="fas fa-plus"></i> Nueva Compra
        </a>
    </div>

    <div class="compra-card">
        <table class="table table-dark table-hover">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Proveedor</th>
                    <th>Fecha</th>
                    <th>Total (Bs)</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($compras as $compra)
                    <tr>
                        <td>{{ $compra->id }}</td>
                        <td>{{ $compra->proveedor->nombre ?? 'N/A' }}</td>
                        <td>{{ \Carbon\Carbon::parse($compra->fecha)->format('d/m/Y') }}</td>
                        <td class="text-success">Bs {{ number_format($compra->total, 2) }}</td>
                        <td class="d-flex">
                            <a href="{{ route('compras.show', $compra) }}" class="btn btn-sm btn-amarillo me-2">
                                <i class="fas fa-eye"></i> Ver
                            </a>
                            <form action="{{ route('compras.destroy', $compra) }}" method="POST" onsubmit="return confirm('¿Eliminar esta compra?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-rojo">
                                    <i class="fas fa-trash"></i> Eliminar
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted">No hay compras registradas aún.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
