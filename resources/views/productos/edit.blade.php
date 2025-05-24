@extends('adminlte::page')

@section('title', 'Editar Producto')

@section('content_header')
    <h1 class="text-warning text-center"><i class="fas fa-edit"></i> Editar Producto</h1>
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

        input, select, textarea {
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
        <form method="POST" action="{{ route('productos.update', $producto) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Nombre del producto</label>
                <input type="text" name="nombre" class="form-control" value="{{ old('nombre', $producto->nombre) }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Categoría</label>
                <select name="categoria_id" class="form-control" required>
                    <option value="">Seleccione una categoría</option>
                    @foreach($categorias as $categoria)
                        <option value="{{ $categoria->id }}" {{ old('categoria_id', $producto->categoria_id) == $categoria->id ? 'selected' : '' }}>
                            {{ $categoria->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="row mb-3">
                <div class="col-md-3">
                    <label class="form-label">Precio de venta (Bs)</label>
                    <input type="number" name="precio_venta" step="0.01" class="form-control" value="{{ old('precio_venta', $producto->precio_venta) }}" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Stock</label>
                    <input type="number" name="stock" class="form-control" value="{{ old('stock', $producto->stock) }}" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Unidad de venta</label>
                    <input type="text" name="unidad_venta" class="form-control" value="{{ old('unidad_venta', $producto->unidad_venta) }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Unidad de compra</label>
                    <input type="text" name="unidad_compra" class="form-control" value="{{ old('unidad_compra', $producto->unidad_compra) }}" placeholder="Ej: caja, litro, kg">
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-3">
                    <label class="form-label">Factor de conversión</label>
                    <input type="number" name="factor_conversion" step="0.01" min="1" class="form-control" value="{{ old('factor_conversion', $producto->factor_conversion) }}" placeholder="Ej: 12 si 1 caja = 12 unidades" required>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Imagen del producto</label>
                <input type="file" name="imagen" class="form-control">
                @if ($producto->imagen)
                    <div class="mt-2">
                        <img src="{{ asset('storage/' . $producto->imagen) }}" alt="Imagen actual" width="120" class="img-thumbnail">
                    </div>
                @endif
            </div>

            <div class="d-flex justify-content-between mt-4">
                <a href="{{ route('productos.index') }}" class="btn btn-secundario">
                    <i class="fas fa-arrow-left"></i> Cancelar
                </a>
                <button class="btn btn-amarillo">
                    <i class="fas fa-save"></i> Guardar Cambios
                </button>
            </div>
        </form>
    </div>
@endsection
