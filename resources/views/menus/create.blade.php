@extends('adminlte::page')

@section('title', 'Nuevo Menú del Día')

@section('content_header')
    <h1 class="text-2xl font-bold text-yellow-400">📋 Registrar Menú del Día</h1>
@endsection

@section('content')
<style>
    .form-container {
        background-color: #1f2937;
        border-radius: 1rem;
        padding: 2rem;
        box-shadow: 0 0 15px rgba(255, 0, 0, 0.3);
    }

    .form-label {
        color: #facc15;
        font-weight: bold;
    }

    .form-control, .form-control-file {
        background-color: #111827;
        color: #fff;
        border: 1px solid #facc15;
        border-radius: 0.5rem;
    }

    .form-control:focus {
        box-shadow: 0 0 5px #facc15;
        border-color: #facc15;
    }

    .btn-save {
        background-color: #facc15;
        color: #1f2937;
        font-weight: bold;
        border-radius: 0.5rem;
        transition: background 0.3s ease;
    }

    .btn-save:hover {
        background-color: #fbbf24;
    }

    .btn-cancel {
        background-color: #dc2626;
        color: white;
        border-radius: 0.5rem;
    }

    .btn-cancel:hover {
        background-color: #b91c1c;
    }

    .text-muted {
        color: #9ca3af;
    }

    .form-check-input {
        transform: scale(1.2);
        margin-right: 0.5rem;
        accent-color: #facc15;
    }
</style>

<div class="max-w-4xl mx-auto">
    <div class="form-container">
        <form action="{{ route('menus.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- Fecha --}}
            <div class="form-group">
                <label for="fecha" class="form-label">📅 Fecha del menú</label>
                <input type="date" name="fecha" id="fecha" class="form-control" value="{{ old('fecha', date('Y-m-d')) }}" required>
            </div>

            {{-- Nombre del plato --}}
            <div class="form-group mt-4">
                <label for="nombre_plato" class="form-label">🍽️ Nombre del plato</label>
                <input type="text" name="nombre_plato" id="nombre_plato" class="form-control" placeholder="Ej. Pollo a la brasa" value="{{ old('nombre_plato') }}" required>
            </div>

            {{-- Descripción --}}
            <div class="form-group mt-4">
                <label for="descripcion" class="form-label">📝 Descripción</label>
                <textarea name="descripcion" id="descripcion" rows="3" class="form-control" placeholder="Incluye guarnición, bebida, etc.">{{ old('descripcion') }}</textarea>
            </div>

            {{-- Precio --}}
            <div class="form-group mt-4">
                <label for="precio" class="form-label">💰 Precio (Bs)</label>
                <input type="number" step="0.01" name="precio" id="precio" class="form-control" placeholder="Ej. 20.00" value="{{ old('precio') }}" required>
            </div>

            {{-- Cantidad disponible --}}
            <div class="form-group mt-4">
                <label for="cantidad" class="form-label">🔢 Cantidad disponible</label>
                <input type="number" name="cantidad" id="cantidad" class="form-control" min="1" placeholder="Ej. 25" value="{{ old('cantidad') }}" required>
            </div>

            {{-- Imagen del plato --}}
            <div class="form-group mt-4">
                <label for="imagen" class="form-label">🖼️ Imagen del plato</label>
                <input type="file" name="imagen" id="imagen" class="form-control-file">
                <small class="text-muted">Formatos permitidos: JPG, PNG, WEBP</small>
            </div>

            {{-- Activo --}}
            <div class="form-check mt-4">
                <input type="checkbox" class="form-check-input" id="activo" name="activo" {{ old('activo', true) ? 'checked' : '' }}>
                <label class="form-label" for="activo">¿Disponible hoy? ✔️</label>
            </div>

            {{-- Botones --}}
            <div class="form-group mt-5 flex justify-between">
                <a href="{{ route('menus.index') }}" class="btn btn-cancel">
                    <i class="fas fa-times"></i> Cancelar
                </a>
                <button type="submit" class="btn btn-save">
                    <i class="fas fa-save"></i> Guardar Menú
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
