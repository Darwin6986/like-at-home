@extends('adminlte::page')

@section('title', 'Nueva Compra')

@section('content_header')
    <h1 class="text-warning text-center"><i class="fas fa-cart-plus"></i> Registrar Nueva Compra</h1>
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

        input, select {
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
        <form method="POST" action="{{ route('compras.store') }}">
            @csrf

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Proveedor</label>
                    <select name="proveedor_id" class="form-control" required>
                        <option value="">Seleccione...</option>
                        @foreach($proveedores as $proveedor)
                            <option value="{{ $proveedor->id }}">{{ $proveedor->nombre }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Fecha</label>
                    <input type="date" name="fecha" class="form-control" value="{{ date('Y-m-d') }}" required>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Método de Pago</label>
                <select name="metodo_pago" class="form-control" required>
                    <option value="efectivo">Efectivo</option>
                    <option value="tarjeta">Tarjeta</option>
                    <option value="otros">Otros</option>
                </select>
            </div>

            <hr class="text-warning">
            <h5 class="text-warning">Productos</h5>

            <div id="productos-container">
                <div class="producto row g-2 align-items-end mb-2">
                    <div class="col-md-5">
                        <label class="form-label">Producto</label>
                        <select name="productos[0][id]" class="form-control" required>
                            <option value="">Seleccione producto...</option>
                            @foreach($productos as $producto)
                                <option value="{{ $producto->id }}">{{ $producto->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Cantidad</label>
                        <input type="number" step="0.01" name="productos[0][cantidad]" class="form-control" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Precio Compra</label>
                        <input type="number" step="0.01" name="productos[0][precio]" class="form-control" required>
                    </div>
                    <div class="col-md-2 d-flex justify-content-center">
                        <button type="button" class="btn btn-danger remove-producto mt-4"><i class="fas fa-trash"></i></button>
                    </div>
                </div>
            </div>

            <button type="button" id="add-producto" class="btn btn-secundario mt-3">
                <i class="fas fa-plus"></i> Agregar otro producto
            </button>

            <div class="d-flex justify-content-between mt-4">
                <a href="{{ route('compras.index') }}" class="btn btn-secundario">
                    <i class="fas fa-arrow-left"></i> Cancelar
                </a>
                <button class="btn btn-amarillo">
                    <i class="fas fa-save"></i> Registrar Compra
                </button>
            </div>
        </form>
    </div>
@endsection

@section('js')
<script>
    let index = 1;

    document.getElementById('add-producto').addEventListener('click', function () {
        const container = document.getElementById('productos-container');
        const productoRow = document.querySelector('.producto').cloneNode(true);

        productoRow.querySelectorAll('input, select').forEach(el => {
            el.name = el.name.replace(/\d+/, index);
            el.value = '';
        });

        container.appendChild(productoRow);
        index++;
    });

    document.addEventListener('click', function (e) {
        if (e.target.closest('.remove-producto')) {
            const rows = document.querySelectorAll('.producto');
            if (rows.length > 1) {
                e.target.closest('.producto').remove();
            }
        }
    });
</script>
@endsection
