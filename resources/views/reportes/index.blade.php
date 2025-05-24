@extends('adminlte::page')

@section('title', 'Reportes')

@section('content_header')
    <h1>Reportes del Sistema</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Generar Reporte</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('reportes.index') }}" method="GET">
            
            <div class="row">
                <div class="col-md-4">
                    <label>Tipo de Reporte</label>
                    <select name="tipo_reporte" class="form-control">
                        <option value="">Seleccione...</option>
                        <option value="ventas">Ventas Diarias</option>
                        <option value="cierre_caja">Cierre de Caja</option>
                        <option value="compras">Compras Realizadas</option>
                        <option value="ganancias">Ganancia/Pérdida Mensual</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label>Desde</label>
                    <input type="date" name="fecha_inicio" class="form-control">
                </div>
                <div class="col-md-4">
                    <label>Hasta</label>
                    <input type="date" name="fecha_fin" class="form-control">
                </div>
            </div>
            <div class="mt-3">
                <button type="submit" class="btn btn-primary">Generar Reporte</button>
            </div>
        </form>
        @if(!empty($datos))
    <div class="card mt-4">
        <div class="card-header">
            <h3 class="card-title">Resultados del Reporte</h3>
        </div>
        <div class="card-body table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        @if($tipo_reporte == 'ventas')
                            <th>Fecha</th>
                            <th>Total Venta</th>
                        @elseif($tipo_reporte == 'cierre_caja')
                            <th>Fecha</th>
                            <th>Ingresos</th>
                            <th>Egresos</th>
                            <th>Saldo</th>
                        @elseif($tipo_reporte == 'compras')
                            <th>Fecha</th>
                            <th>Producto</th>
                            <th>Cantidad</th>
                            <th>Total</th>
                        @elseif($tipo_reporte == 'ganancias')
                            <th>Mes</th>
                            <th>Ingresos</th>
                            <th>Egresos</th>
                            <th>Ganancia</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach($datos as $item)
                        <tr>
                            @foreach($item as $valor)
                                <td>{{ $valor }}</td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endif

    </div>
</div>
@endsection
