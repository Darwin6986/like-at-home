@extends('adminlte::page')

@section('title', 'Detalle del Menú')

@section('content_header')
    <h1>Detalle del Menú del Día</h1>
@endsection

@section('content')
    <div class="mb-3">
        <strong>Fecha:</strong> {{ $menu->fecha }}<br>
        <strong>Descripción:</strong> {{ $menu->descripcion }}<br>
        <strong>Estado:</strong> 
        @if($menu->activo)
            <span class="badge bg-success">Activo</span>
        @else
            <span class="badge bg-secondary">Inactivo</span>
        @endif
    </div>

    @if($menu->imagen)
        <div class="mb-3">
            <img src="{{ asset('storage/' . $menu->imagen) }}" alt="imagen" class="img-fluid rounded" style="max-width: 300px;">
        </div>
    @endif

    <h5>Platos Incluidos:</h5>
    <ul class="list-group">
        @foreach($menu->platos as $plato)
            <li class="list-group-item">
                {{ $plato->producto->nombre }}
                @if($plato->notas)
                    <span class="text-muted"> - {{ $plato->notas }}</span>
                @endif
            </li>
        @endforeach
    </ul>

    <a href="{{ route('menus.index') }}" class="btn btn-secondary mt-3">Volver</a>
@endsection
