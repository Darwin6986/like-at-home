<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use App\Models\VentaDetalle;
use App\Models\Producto;
use App\Models\Cliente;
use App\Models\MenuDia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class VentaController extends Controller
{
    public function index()
    {
        $ventas = Venta::with('usuario', 'cliente')->latest()->paginate(10);
        return view('ventas.index', compact('ventas'));
    }

    public function create()
    {
        $productos = Producto::all();
        $menusDelDia = MenuDia::where('activo', true)->get();
        return view('ventas.create', compact('productos', 'menusDelDia'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'cliente_nombre' => 'required|string|max:255',
            'fecha' => 'required|date',
            'tipo_pago' => 'required|in:Efectivo,Tarjeta,Transferencia',
            'productos' => 'required|array|min:1',
            'productos.*.producto_id' => 'required',
            'productos.*.cantidad' => 'required|numeric|min:1',
            'productos.*.precio' => 'required|numeric|min:0',
        ]);

        DB::transaction(function () use ($request) {
            // Crear cliente
            $cliente = Cliente::create([
                'nombre'    => $request->cliente_nombre,
                'telefono'  => $request->cliente_telefono,
                'direccion' => $request->cliente_direccion,
                'correo'    => $request->cliente_correo,
            ]);

            // Calcular total
            $total = 0;
            foreach ($request->productos as $item) {
                $total += $item['cantidad'] * $item['precio'];
            }

            // Crear venta
            $venta = Venta::create([
                'usuario_id'  => Auth::id(),
                'cliente_id'  => $cliente->id,
                'fecha'       => $request->fecha,
                'total'       => $total,
                'tipo_pago'   => $request->tipo_pago,
            ]);

            // Crear detalles
            foreach ($request->productos as $item) {
                $productoId = $item['producto_id'];
                $esMenu = str_starts_with($productoId, 'menu-');

                if ($esMenu) {
                    $menuId = (int) str_replace('menu-', '', $productoId);
                    $menu = MenuDia::find($menuId);

                    VentaDetalle::create([
                        'venta_id'     => $venta->id,
                        'producto_id'  => null,
                        'descripcion'  => 'Menú del Día: ' . ($menu->nombre_plato ?? 'Sin nombre'),
                        'cantidad'     => $item['cantidad'],
                        'precio_venta' => $item['precio'],
                        'subtotal'     => $item['cantidad'] * $item['precio'],
                    ]);
                } else {
                    VentaDetalle::create([
                        'venta_id'     => $venta->id,
                        'producto_id'  => $productoId,
                        'descripcion'  => null,
                        'cantidad'     => $item['cantidad'],
                        'precio_venta' => $item['precio'],
                        'subtotal'     => $item['cantidad'] * $item['precio'],
                    ]);

                    // Descontar stock
                    $producto = Producto::find($productoId);
                    if ($producto) {
                        $producto->decrement('stock', $item['cantidad']);
                    }
                }
            }
        });

        return redirect()->route('ventas.index')->with('success', 'Venta registrada correctamente');
    }

    public function show(Venta $venta)
    {
        $venta->load('usuario', 'cliente', 'detalles.producto');
        return view('ventas.show', compact('venta'));
    }
}
