@extends('adminlte::page')

@section('title', 'Nuevo Proveedor')

@section('content_header')
    <h1 class="text-warning text-center"><i class="fas fa-user-plus"></i> Registrar Nuevo Proveedor</h1>
@endsection

@section('content')
    <style>
        .form-container {
            background-color: #1c1c1c;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(255, 204, 0, 0.15);
            color: white;
        }

        .form-label {
            color: #ffcc00;
            font-weight: bold;
        }

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

        input {
            background-color: #2a2a2a !important;
            color: white !important;
            border: 1px solid #444;
        }

        .form-control:focus {
            border-color: #ffcc00;
            box-shadow: 0 0 5px #ffcc00;
        }
    </style>

    <div class="form-container">
        <form method="POST" action="{{ route('proveedores.store') }}">
            @csrf

            <div class="mb-3">
                <label class="form-label">Nombre</label>
                <input type="text" name="nombre" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Contacto</label>
                <input type="text" name="contacto" class="form-control">
            </div>

            <div class="mb-3">
                <label class="form-label">Teléfono</label>
                <input type="text" name="telefono" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control">
            </div>

            <div class="mb-3">
                <label class="form-label">Dirección</label>
                <input type="text" name="direccion" class="form-control">
            </div>

            <div class="d-flex justify-content-between mt-4">
                <a href="{{ route('proveedores.index') }}" class="btn btn-secundario">
                    <i class="fas fa-arrow-left"></i> Cancelar
                </a>
                <button class="btn btn-amarillo">
                    <i class="fas fa-save"></i> Guardar
                </button>
            </div>
        </form>
    </div>
@endsection
