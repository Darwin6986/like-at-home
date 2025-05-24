@extends('adminlte::page')

@section('title', 'Proveedores')

@section('content_header')
    <h1 class="text-warning text-center"><i class="fas fa-truck"></i> Lista de Proveedores</h1>
@endsection

@section('content')
    <style>
        .btn-amarillo {
            background-color: #ffcc00;
            color: #121212;
            border: none;
        }

        .btn-amarillo:hover {
            background-color: #ffdd33;
        }

        .btn-secundario {
            background-color: #444;
            color: white;
            border: none;
        }

        .btn-secundario:hover {
            background-color: #666;
        }

        .table-dark-custom {
            background-color: #1c1c1c;
            color: white;
            border-radius: 10px;
            overflow: hidden;
        }

        .table-dark-custom th {
            background-color: #2a2a2a;
            color: #ffcc00;
            border-color: #444;
        }

        .table-dark-custom td {
            background-color: #2a2a2a;
            border-color: #333;
        }

        .table-dark-custom .text-muted {
            color: #888 !important;
        }

        .alert-success {
            background-color: #2e7d32;
            color: white;
            border: none;
        }

        .pagination .page-link {
            background-color: #2a2a2a;
            color: #ffcc00;
            border: 1px solid #444;
        }

        .pagination .page-item.active .page-link {
            background-color: #ffcc00;
            color: #121212;
            border-color: #ffcc00;
        }
    </style>

    <div class="mb-3 d-flex justify-content-between align-items-center">
        <a href="{{ route('proveedores.create') }}" class="btn btn-amarillo">
            <i class="fas fa-plus"></i> Nuevo Proveedor
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    <div class="table-responsive rounded shadow-sm">
        <table class="table table-dark-custom table-bordered table-hover">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Contacto</th>
                    <th>Teléfono</th>
                    <th>Email</th>
                    <th>Dirección</th>
                    <th class="text-center">Opciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($proveedores as $proveedor)
                    <tr>
                        <td>{{ $proveedor->nombre }}</td>
                        <td>{{ $proveedor->contacto }}</td>
                        <td>{{ $proveedor->telefono }}</td>
                        <td>{{ $proveedor->email }}</td>
                        <td>{{ $proveedor->direccion }}</td>
                        <td class="text-center">
                            <a href="{{ route('proveedores.edit', $proveedor) }}" class="btn btn-sm btn-warning me-1">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('proveedores.destroy', $proveedor) }}" method="POST" class="d-inline-block" onsubmit="return confirm('¿Eliminar proveedor?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted">No hay proveedores registrados.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-end mt-3">
        {{ $proveedores->links() }}
    </div>
@endsection
