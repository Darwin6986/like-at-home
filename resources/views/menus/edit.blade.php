@extends('adminlte::page')

@section('title', 'Editar Menú del Día')

@section('content_header')
    <h1 class="text-2xl font-bold text-yellow-400">✏️ Editar Menú del Día</h1>
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

    .form-check-input {
        transform: scale(1.2);
        margin-right: 0.5rem;
        accent-color: #facc15;
    }

    .text-muted {
        color: #9ca3af;
    }
</style>

<div class="max-w-4xl mx-auto">
    <div class="form-container">
        <form action="{{ route('menus.update', $menu->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- Fecha --}}
            <div class="form-group">
                <label for="fecha" class="form-label">📅 Fecha del menú</label>
                <input type="date" name="fecha" id="fecha" class="form-control" value="{{ old('fecha', $menu->fecha) }}" required>
            </div>

            {{-- Nombre del plato --}}
            <div class="form-group mt-4">
                <label for="nombre_plato" class="form-label">🍽️ Nombre del plato</label>
                <input type="text" name="nombre_plato" id="nombre_plato" class="form-control" value="{{ old('nombre_plato', $menu->nombre_plato) }}" required>
            </div>

            {{-- Descripción --}}
            <div class="form-group mt-4">
                <label for="descripcion" class="form-label">📝 Descripción</label>
                <textarea name="descripcion" id="descripcion" rows="3" class="form-control">{{ old('descripcion', $menu->descripcion) }}</textarea>
            </div>

            {{-- Precio --}}
            <div class="form-group mt-4">
                <label for="precio" class="form-label">💰 Precio (Bs)</label>
                <input type="number" step="0.01" name="precio" id="precio" class="form-control" value="{{ old('precio', $menu->precio) }}" required>
            </div>

            {{-- Cantidad --}}
            <div class="form-group mt-4">
                <label for="cantidad" class="form-label">🔢 Cantidad disponible</label>
                <input type="number" name="cantidad" id="cantidad" class="form-control" value="{{ old('cantidad', $menu->cantidad) }}" min="1" required>
            </div>

            {{-- Imagen actual --}}
            @if ($menu->imagen)
                <div class="mt-4">
                    <label class="form-label">🖼️ Imagen actual</label><br>
                    <img src="{{ asset('storage/' . $menu->imagen) }}" alt="Imagen del menú" style="max-height: 200px;" class="rounded shadow">
                </div>
            @endif

            {{-- Nueva imagen --}}
            <div class="form-group mt-4">
                <label for="imagen" class="form-label">📤 Cambiar imagen</label>
                <input type="file" name="imagen" id="imagen" class="form-control-file">
                <small class="text-muted">Dejar vacío para mantener la actual</small>
            </div>

            {{-- Activo --}}
            <div class="form-check mt-4">
                <input type="checkbox" class="form-check-input" id="activo" name="activo" {{ $menu->activo ? 'checked' : '' }}>
                <label class="form-label" for="activo">¿Disponible hoy? ✔️</label>
            </div>

            {{-- Botones --}}
            <div class="form-group mt-5 flex justify-between">
                <a href="{{ route('menus.index') }}" class="btn btn-cancel">
                    <i class="fas fa-times"></i> Cancelar
                </a>
                <button type="submit" class="btn btn-save">
                    <i class="fas fa-save"></i> Actualizar Menú
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
    