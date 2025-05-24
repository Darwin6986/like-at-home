<?php

namespace App\Http\Controllers;

use App\Models\Compra;
use App\Models\CompraDetalle;
use App\Models\Proveedore;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CompraController extends Controller
{
    public function index()
    {
        $compras = Compra::with('proveedor')->latest()->paginate(10);
        return view('compras.index', compact('compras'));
    }

    public function create()
    {
        $proveedores = Proveedore::all();
        $productos = Producto::all();
        return view('compras.create', compact('proveedores', 'productos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'proveedor_id' => 'required|exists:proveedores,id',
            'fecha' => 'required|date',
            'metodo_pago' => 'required|in:efectivo,tarjeta,otros',
            'productos' => 'required|array',
            'productos.*.id' => 'required|exists:productos,id',
            'productos.*.cantidad' => 'required|numeric|min:1',
            'productos.*.precio' => 'required|numeric|min:0',
        ]);

        DB::transaction(function () use ($request) {
            $total = 0;

            foreach ($request->productos as $item) {
                $total += $item['cantidad'] * $item['precio'];
            }

            $compra = Compra::create([
                'proveedor_id' => $request->proveedor_id,
                'fecha' => $request->fecha,
                'total' => $total,
                'metodo_pago' => $request->metodo_pago,
            ]);

            foreach ($request->productos as $item) {
                CompraDetalle::create([
                    'compra_id' => $compra->id,
                    'producto_id' => $item['id'],
                    'cantidad' => $item['cantidad'],
                    'precio_compra' => $item['precio'],
                    'subtotal' => $item['cantidad'] * $item['precio'],
                ]);

                // Actualizar stock del producto
                $producto = Producto::find($item['id']);
                $producto->increment('stock', $item['cantidad']);
            }
        });

        return redirect()->route('compras.index')->with('success', 'Compra registrada correctamente');
    }

    public function show(Compra $compra)
    {
        $compra->load('proveedor', 'detalles.producto');
        return view('compras.show', compact('compra'));
    }
}
