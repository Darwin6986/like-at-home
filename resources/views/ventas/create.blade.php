@extends('adminlte::page')

@section('title', 'Nueva Venta')

@section('content_header')
    <h1 class="text-warning text-center"><i class="fas fa-shopping-cart"></i> Registrar Nueva Venta</h1>
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

    .error-stock {
        color: #ff4444;
        font-size: 0.9em;
        margin-top: 5px;
    }

    .remove-row {
        cursor: pointer;
        color: red;
        font-size: 1.2em;
        margin-top: 30px;
    }
</style>

<div class="form-container">
    <form method="POST" action="{{ route('ventas.store') }}">
        @csrf

        {{-- Cliente --}}
        <h5 class="text-warning">Datos del Cliente</h5>
        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label">Nombre del Cliente</label>
                <input type="text" name="cliente_nombre" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Teléfono (opcional)</label>
                <input type="text" name="cliente_telefono" class="form-control">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label">Dirección (opcional)</label>
                <input type="text" name="cliente_direccion" class="form-control">
            </div>
            <div class="col-md-6">
                <label class="form-label">Correo Electrónico (opcional)</label>
                <input type="email" name="cliente_correo" class="form-control">
            </div>
        </div>

        <hr class="text-warning">

        {{-- Venta --}}
        <h5 class="text-warning">Datos de la Venta</h5>
        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label">Fecha</label>
                <input type="date" name="fecha" class="form-control" value="{{ date('Y-m-d') }}" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Tipo de Pago</label>
                <select name="tipo_pago" class="form-control" required>
                    <option value="Efectivo">Efectivo</option>
                    <option value="Tarjeta">Tarjeta</option>
                    <option value="Transferencia">Transferencia</option>
                </select>
            </div>
        </div>

        <hr class="text-warning">

        {{-- Menú del Día --}}
        <h5 class="text-warning">Menú del Día (opcional)</h5>
        <div class="mb-3">
            <select id="menu-dia" class="form-control">
                <option value="">-- Seleccione un menú --</option>
                @foreach($menusDelDia as $menu)
                    <option 
                        value="{{ $menu->id }}"
                        data-nombre="{{ $menu->nombre_plato }}"
                        data-precio="{{ $menu->precio }}">
                        {{ $menu->nombre_plato }} - Bs {{ number_format($menu->precio, 2, ',', '.') }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Productos --}}
        <h5 class="text-warning">Detalles de Productos (opcional)</h5>
        <div id="productos-wrapper"></div>

        <div class="mt-3">
            <button type="button" id="add-producto" class="btn btn-sm btn-amarillo">
                <i class="fas fa-plus"></i> Agregar Producto
            </button>
        </div>

        <div class="d-flex justify-content-between mt-4">
            <a href="{{ route('ventas.index') }}" class="btn btn-secundario">
                <i class="fas fa-arrow-left"></i> Cancelar
            </a>
            <button type="submit" class="btn btn-amarillo">
                <i class="fas fa-save"></i> Guardar Venta
            </button>
        </div>
    </form>
</div>

<script>
    let index = 0;

    function addProductRow(nombre = '', precio = '', productoId = '', esMenu = false) {
        const wrapper = document.getElementById('productos-wrapper');
        const readonly = esMenu ? 'readonly' : '';
        const hiddenInput = esMenu ? `<input type="hidden" name="productos[${index}][producto_id]" value="menu-${productoId}">` : '';
        const productoSelect = esMenu 
            ? `<input type="text" class="form-control" value="${nombre} (Menú del Día)" readonly>` 
            : `<select name="productos[${index}][producto_id]" class="form-control producto-select">
                    <option value="">Seleccione un producto</option>
                    @foreach($productos as $producto)
                        <option value="{{ $producto->id }}" data-precio="{{ $producto->precio_venta }}" data-stock="{{ $producto->stock }}">
                            {{ $producto->nombre }}
                        </option>
                    @endforeach
               </select>`;

        const row = document.createElement('div');
        row.className = 'row mb-2';
        row.innerHTML = `
            <div class="col-md-4">
                ${hiddenInput}
                ${productoSelect}
            </div>
            <div class="col-md-2">
                <input type="number" name="productos[${index}][cantidad]" class="form-control cantidad-input" value="1" min="1" required>
                <div class="error-stock"></div>
            </div>
            <div class="col-md-2">
                <input type="number" name="productos[${index}][precio]" class="form-control precio-input" value="${precio}" step="0.01" required ${readonly}>
            </div>
            <div class="col-md-1 d-flex align-items-center">
                <span class="remove-row" onclick="this.closest('.row').remove()">🗑️</span>
            </div>
        `;
        wrapper.appendChild(row);
        index++;
    }

    document.getElementById('add-producto').addEventListener('click', () => addProductRow());

    document.addEventListener('change', function(e) {
        if (e.target.classList.contains('producto-select')) {
            const precio = e.target.selectedOptions[0].getAttribute('data-precio');
            const row = e.target.closest('.row');
            row.querySelector('.precio-input').value = precio;
        }
    });

    document.addEventListener('input', function(e) {
        if (e.target.classList.contains('cantidad-input')) {
            const cantidad = parseInt(e.target.value) || 0;
            const row = e.target.closest('.row');
            const select = row.querySelector('.producto-select');
            if (!select) return;
            const stock = parseInt(select.selectedOptions[0].getAttribute('data-stock')) || 0;
            const errorDiv = row.querySelector('.error-stock');
            errorDiv.textContent = cantidad > stock 
                ? "Cantidad supera el stock disponible (" + stock + ")" 
                : "";
        }
    });

    document.getElementById('menu-dia').addEventListener('change', function () {
        const selected = this.selectedOptions[0];
        const menuId = this.value;
        if (!menuId) return;

        const nombre = selected.getAttribute('data-nombre');
        const precio = selected.getAttribute('data-precio');
        addProductRow(nombre, precio, menuId, true);
    });
</script>
@endsection
    