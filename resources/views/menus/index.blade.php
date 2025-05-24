@extends('adminlte::page')

@section('title', 'Menú del Día')

@section('content_header')
    <h1 class="text-red-600 text-2xl font-bold">
        <i class="fas fa-calendar-day"></i> Menú del Día
    </h1>
@endsection

@section('content')
    <div class="mb-4">
        <a href="{{ route('menus.create') }}" class="btn btn-primary">
            <i class="fas fa-plus-circle"></i> Nuevo Menú
        </a>
    </div>

    <div class="row">
        @forelse($menus as $menu)
            <div class="col-md-4">
                <div class="card bg-dark text-white mb-4 shadow-lg border border-yellow-400">
                    {{-- Header con fecha y estado --}}
                    <div class="card-header bg-warning text-dark font-bold d-flex justify-content-between align-items-center">
                        <span>
                            <i class="fas fa-calendar-alt"></i>
                            {{ \Carbon\Carbon::parse($menu->fecha)->format('d/m/Y') }}
                        </span>
                        @if($menu->activo)
                            <span class="badge bg-success">
                                <i class="fas fa-check-circle"></i> Activo
                            </span>
                        @endif
                    </div>

                    {{-- Imagen del menú --}}
                    @if($menu->imagen)
                        <img src="{{ asset('storage/' . $menu->imagen) }}"
                             class="card-img-top"
                             style="height: 200px; object-fit: cover;"
                             alt="Imagen del menú">
                    @endif

                    {{-- Contenido --}}
                    <div class="card-body">
                        <h5 class="card-title text-yellow-400 mb-2">
                            <i class="fas fa-utensils"></i> {{ $menu->nombre_plato ?? 'Sin nombre de plato' }}
                        </h5><br>

                        <p class="text-white mb-2">
                            <i class="fas fa-align-left"></i> {{ $menu->descripcion ?? 'Sin descripción' }}
                        </p>

                        {{-- Cantidad --}}
                        <p class="text-white mb-2">
                            <i class="fas fa-sort-numeric-up-alt"></i> Cantidad disponible: <strong>{{ $menu->cantidad }}</strong>
                        </p>

                       
                        {{-- Precio --}}
                        <p class="text-lg font-bold text-green-400 mb-3">
                            <i class="fas fa-money-bill-wave"></i> Precio: Bs {{ number_format($menu->precio, 2, ',', '.') }}
                        </p>

                        {{-- Botones --}}
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('menus.edit', $menu->id) }}" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i> Editar
                            </a>

                            <form action="{{ route('menus.destroy', $menu->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar este menú?')" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm">
                                    <i class="fas fa-trash-alt"></i> Eliminar
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info text-center">
                    <i class="fas fa-info-circle"></i> No hay menús registrados aún.
                </div>
            </div>
        @endforelse
    </div>
@endsection
