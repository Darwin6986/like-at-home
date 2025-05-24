@extends('adminlte::page')

@section('title', 'Editar Categoría')

@section('content_header')
    <h1 class="text-warning text-center"><i class="fas fa-edit"></i> Editar Categoría</h1>
@endsection

@section('content')
    <style>
        .form-container {
            background-color: #1c1c1c;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(255, 204, 0, 0.2);
            color: white;
        }

        .form-label {
            color: #ffcc00;
            font-weight: bold;
        }

        .btn-amarillo {
            background-color: #ffcc00;
            color: #121212;
        }

        .btn-amarillo:hover {
            background-color: #ffdd33;
        }

        .btn-secundario {
            background-color: #444;
            color: white;
        }

        .btn-secundario:hover {
            background-color: #666;
        }

        input, textarea {
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
        <form method="POST" action="{{ route('categorias.update', $categoria) }}">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Nombre de la categoría</label>
                <input type="text" name="nombre" class="form-control" value="{{ old('nombre', $categoria->nombre) }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Descripción</label>
                <textarea name="descripcion" rows="3" class="form-control">{{ old('descripcion', $categoria->descripcion) }}</textarea>
            </div>

            <div class="d-flex justify-content-between mt-4">
                <a href="{{ route('categorias.index') }}" class="btn btn-secundario">
                    <i class="fas fa-arrow-left"></i> Cancelar
                </a>
                <button type="submit" class="btn btn-amarillo">
                    <i class="fas fa-save"></i> Guardar Cambios
                </button>
            </div>
        </form>
    </div>
@endsection
