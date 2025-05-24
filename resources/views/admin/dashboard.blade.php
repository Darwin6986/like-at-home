@extends('adminlte::page')

@section('title', 'Bienvenido')

@section('content_header')
    <h1 class="text-center text-warning">🍽️ Bienvenido a LIKE AT HOME</h1>
@endsection

@section('content')
    {{-- Estilos y AOS --}}
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">

    <style>
        body {
            background-color: #121212 !important;
        }

        .bienvenida-container {
            background: linear-gradient(to right, #1c1c1c, #121212);
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 0 30px rgba(255, 204, 0, 0.2);
        }

        .bienvenida-text {
            color: #ffcc00;
            font-size: 24px;
        }

        .bienvenida-sub {
            color: #ffffff;
            font-size: 16px;
            margin-bottom: 20px;
        }

        .icono-menu {
            font-size: 80px;
            color: #ff4444;
        }

        .btn-ingresar {
            background-color: #ffcc00;
            color: #1c1c1c;
            border-radius: 10px;
        }

        .btn-ingresar:hover {
            background-color: #ffdd33;
        }

        .linea-div {
            border-top: 3px dashed #ffcc00;
            width: 80%;
            margin: 30px auto;
        }

        .card.bg-dark {
            background-color: #1e1e1e !important;
        }
    </style>

    <div class="container-fluid">
        <div class="bienvenida-container text-center" data-aos="fade-up">
            <i class="fas fa-utensils icono-menu mb-3" data-aos="zoom-in" data-aos-delay="100"></i>
            <h2 class="bienvenida-text">¡Bienvenido al sistema de gestión del restaurante!</h2>
            <p class="bienvenida-sub">Administra productos, inventario, ventas y menús con eficiencia y estilo.</p>

            <div class="linea-div"></div>

            <div class="row mt-4" data-aos="fade-up" data-aos-delay="200">
                <div class="col-md-4 mb-3">
                    <div class="card bg-dark text-white shadow-lg" data-aos="fade-right">
                        <div class="card-body">
                            <i class="fas fa-boxes fa-3x text-warning mb-2"></i>
                            <h5 class="card-title">Inventario</h5>
                            <p class="card-text">Controla las entradas y salidas de productos de forma clara.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="card bg-dark text-white shadow-lg" data-aos="fade-up">
                        <div class="card-body">
                            <i class="fas fa-cash-register fa-3x text-success mb-2"></i>
                            <h5 class="card-title">Ventas</h5>
                            <p class="card-text">Registra ventas fácilmente y mantén el control de tu negocio.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="card bg-dark text-white shadow-lg" data-aos="fade-left">
                        <div class="card-body">
                            <i class="fas fa-concierge-bell fa-3x text-danger mb-2"></i>
                            <h5 class="card-title">Menús del Día</h5>
                            <p class="card-text">Agrega menús diarios con imágenes y platos personalizados.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-5" data-aos="zoom-in">
                <a href="{{ route('productos.index') }}" class="btn btn-lg btn-ingresar">
                    <i class="fas fa-play"></i> Comenzar
                </a>
            </div>
        </div>
    </div>

    {{-- JS AOS --}}
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>
@endsection
