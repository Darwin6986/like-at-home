@extends('adminlte::page')

@section('title', 'Categorías de Productos')

@section('content_header')
    <h1 class="text-warning text-center"><i class="fas fa-tags"></i> Categorías de Productos</h1>
@endsection

@section('content')
    <style>
        body {
            background-color: #121212 !important;
        }

        .categoria-card {
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
        <a href="{{ route('categorias.create') }}" class="btn btn-amarillo">
            <i class="fas fa-plus"></i> Nueva Categoría
        </a>
    </div>

    <div class="categoria-card">
        <table class="table table-dark table-hover">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categorias as $categoria)
                    <tr>
                        <td>{{ $categoria->id }}</td>
                        <td class="text-warning">{{ $categoria->nombre }}</td>
                        <td>{{ $categoria->descripcion }}</td>
                        <td class="d-flex">
                            <a href="{{ route('categorias.edit', $categoria) }}" class="btn btn-sm btn-amarillo me-2">
                                <i class="fas fa-edit"></i> Editar
                            </a>
                            <form action="{{ route('categorias.destroy', $categoria) }}" method="POST" onsubmit="return confirm('¿Eliminar esta categoría?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-rojo">
                                    <i class="fas fa-trash"></i> Eliminar
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted">No hay categorías registradas.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
