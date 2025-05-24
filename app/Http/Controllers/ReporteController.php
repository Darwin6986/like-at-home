<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use App\Models\Compra;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Spatie\SimpleExcel\SimpleExcelWriter;

class ReporteController extends Controller
{
    public function reporteVentas(Request $request)
    {
     $ventas = collect();
$compras = collect();

        if ($request->filled('desde') && $request->filled('hasta')) {
            $ventas = Venta::with('cliente', 'usuario', 'detalles.producto')
                ->whereBetween('fecha', [$request->desde, $request->hasta])
                ->get();

            $compras = Compra::with('proveedor', 'detalles.producto')
                ->whereBetween('fecha', [$request->desde, $request->hasta])
                ->get();
        }

        return view('reportes.ventas', compact('ventas', 'compras'));
    }

    public function ventasPDF(Request $request)
    {
        $ventas = Venta::with('cliente', 'detalles.producto')
            ->whereBetween('fecha', [$request->desde, $request->hasta])
            ->get();

        $compras = Compra::with('proveedor', 'detalles.producto')
            ->whereBetween('fecha', [$request->desde, $request->hasta])
            ->get();

        $totalIngresos = $ventas->sum('total');
        $totalEgresos = $compras->sum('total');
        $balance = $totalIngresos - $totalEgresos;

        $pdf = PDF::loadView('reportes.partials.ventas_pdf', compact('ventas', 'compras', 'totalIngresos', 'totalEgresos', 'balance'));
        return $pdf->download('reporte_ventas_' . now()->format('Ymd_His') . '.pdf');
    }

    public function ventasExcel(Request $request)
    {
        $ventas = Venta::with('cliente', 'usuario', 'detalles.producto')
            ->whereBetween('fecha', [$request->desde, $request->hasta])
            ->get();

        $compras = Compra::with('proveedor', 'detalles.producto')
            ->whereBetween('fecha', [$request->desde, $request->hasta])
            ->get();

        $filename = 'reporte_ventas_' . now()->format('Ymd_His') . '.csv';
        $path = storage_path("app/{$filename}");

        $writer = SimpleExcelWriter::create($path);
        $writer->addHeader(['Tipo', 'Fecha', 'Nombre', 'Detalle', 'Cantidad', 'Total']);

        // Ventas
        foreach ($ventas as $venta) {
            $detalle = $venta->detalles->map(fn($d) => ($d->producto->nombre ?? $d->descripcion ?? 'Sin nombre') . ' (x' . $d->cantidad . ')')->implode(', ');
            $cantidad = $venta->detalles->sum('cantidad');

            $writer->addRow([
                'Venta',
                $venta->fecha,
                $venta->cliente->nombre ?? 'Público',
                $detalle,
                $cantidad,
                $venta->total,
            ]);
        }

        // Compras
        foreach ($compras as $compra) {
            $detalle = $compra->detalles->map(fn($d) => ($d->producto->nombre ?? 'Sin nombre') . ' (x' . $d->cantidad . ')')->implode(', ');
            $cantidad = $compra->detalles->sum('cantidad');

            $writer->addRow([
                'Compra',
                $compra->fecha,
                $compra->proveedor->nombre ?? 'Desconocido',
                $detalle,
                $cantidad,
                $compra->total,
            ]);
        }

        $writer->close();
        return response()->download($path)->deleteFileAfterSend();
    }
}
