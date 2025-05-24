@extends('adminlte::page')

@section('title', 'Productos')

@section('content_header')
    <h1 class="text-warning text-center"><i class="fas fa-utensils"></i> Lista de Productos</h1>
@endsection

@section('content')
    <style>
        body {
            background-color: #121212 !important;
        }

        .card-producto {
            background-color: #1c1c1c;
            color: #fff;
            border: 2px solid #ffcc00;
            border-radius: 15px;
            transition: all 0.3s ease;
        }

        .card-producto:hover {
            transform: scale(1.03);
            box-shadow: 0 0 20px rgba(255, 0, 0, 0.4);
        }

        .card-producto img {
            border-top-left-radius: 15px;
            border-top-right-radius: 15px;
            height: 200px;
            object-fit: cover;
        }

        .badge-custom {
            font-size: 13px;
            background-color: #ff4444;
            color: white;
        }

        .btn-amarillo {
            background-color: #ffcc00;
            color: #121212;
        }

        .btn-amarillo:hover {
            background-color: #ffdd33;
            color: #121212;
        }

        .btn-rojo {
            background-color: #ff4444;
            color: white;
        }

        .btn-rojo:hover {
            background-color: #cc0000;
        }
    </style>

    <div class="d-flex justify-content-end mb-3">
        <a href="{{ route('productos.create') }}" class="btn btn-lg btn-amarillo shadow">
            <i class="fas fa-plus-circle"></i> Nuevo Producto
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success shadow">{{ session('success') }}</div>
    @endif

    <div class="row">
        @forelse($productos as $producto)
            <div class="col-md-4 mb-4">
                <div class="card card-producto elevation-4">
                    @if($producto->imagen)
                        <img src="{{ asset('storage/' . $producto->imagen) }}" alt="Imagen de {{ $producto->nombre }}">
                    @else
                        <div class="bg-secondary text-center text-white py-5">Sin Imagen</div>
                    @endif

                    <div class="card-body">
                        <h5 class="card-title text-warning">{{ $producto->nombre }}</h5>

                        <p class="mb-2">
                            <span class="badge badge-custom">
                                {{ $producto->categoria->nombre ?? 'Sin categoría' }}
                            </span>
                        </p>

                        <p><strong>Precio:</strong>
                            <span class="text-danger">Bs {{ number_format($producto->precio_venta, 2) }}</span>
                        </p>

                        <p><strong>Stock:</strong>
                            <span class="text-success">{{ $producto->stock }}</span> {{ $producto->unidad_venta }}
                        </p>

                        <div class="d-flex justify-content-between mt-3">
                            <a href="{{ route('productos.edit', $producto) }}" class="btn btn-sm btn-amarillo">
                                <i class="fas fa-edit"></i> Editar
                            </a>
                            <form action="{{ route('productos.destroy', $producto) }}" method="POST"
                                  onsubmit="return confirm('¿Eliminar este producto?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-rojo">
                                    <i class="fas fa-trash-alt"></i> Eliminar
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center">
                <div class="alert alert-warning">No hay productos registrados aún.</div>
            </div>
        @endforelse
    </div>

    <div class="d-flex justify-content-end mt-4">
        {{ $productos->links() }}
    </div>
@endsection
