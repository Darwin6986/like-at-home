<?php

namespace App\Http\Controllers;

use App\Models\MenuDia;
use App\Models\MenuPlato;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MenuDiaController extends Controller
{
    public function index()
    {
        $menus = MenuDia::with('platos.producto')->latest()->paginate(10);
        return view('menus.index', compact('menus'));
    }

    public function create()
    {
        $productos = Producto::all();
        return view('menus.create', compact('productos'));
    }

    public function store(Request $request)
    {
        // Validación básica (puedes expandirla si lo deseas)
        $request->validate([
            'fecha'         => 'required|date',
            'nombre_plato'  => 'required|string|max:255',
            'descripcion'   => 'nullable|string',
            'precio'        => 'required|numeric|min:0',
            'cantidad'      => 'required|integer|min:1',
            'imagen'        => 'nullable|image|max:2048',
        ]);

        // Solo un menú activo
        if ($request->activo) {
            MenuDia::where('activo', true)->update(['activo' => false]);
        }

        // Subir imagen
        $imagen = $request->hasFile('imagen')
            ? $request->file('imagen')->store('menus', 'public')
            : null;

        // Crear menú
        $menu = MenuDia::create([
            'fecha'        => $request->fecha,
            'nombre_plato' => $request->nombre_plato,
            'descripcion'  => $request->descripcion,
            'precio'       => $request->precio,
            'cantidad'     => $request->cantidad,
            'activo'       => $request->activo ? true : false,
            'imagen'       => $imagen,
        ]);

        // Asociar productos (opcional)
        if ($request->has('productos')) {
            foreach ($request->productos as $item) {
                if (!empty($item['id'])) {
                    $menu->platos()->create([
                        'producto_id' => $item['id'],
                        'notas'       => $item['notas'] ?? null,
                    ]);
                }
            }
        }

        return redirect()->route('menus.index')->with('success', 'Menú registrado correctamente');
    }

    public function show(MenuDia $menu)
    {
        $menu->load('platos.producto');
        return view('menus.show', compact('menu'));
    }

    public function edit(MenuDia $menu)
    {
        $productos = Producto::all();
        $menu->load('platos');
        return view('menus.edit', compact('menu', 'productos'));
    }

    public function update(Request $request, MenuDia $menu)
    {
        /*$request->validate([
            'fecha'         => 'required|date',
            'nombre_plato'  => 'required|string|max:255',
            'descripcion'   => 'nullable|string',
            'precio'        => 'required|numeric|min:0',
            'cantidad'      => 'required|integer|min:1',
            'imagen'        => 'nullable|image|max:2048',
        ]);*/

        // Desactivar otros si este será el activo
        if ($request->activo) {
            MenuDia::where('activo', true)
                ->where('id', '!=', $menu->id)
                ->update(['activo' => false]);
        }

        $data = $request->only([
            'fecha', 'nombre_plato', 'descripcion', 'precio', 'cantidad'
        ]);
        $data['activo'] = $request->activo ? true : false;

        // Imagen nueva
        if ($request->hasFile('imagen')) {
            if ($menu->imagen && Storage::disk('public')->exists($menu->imagen)) {
                Storage::disk('public')->delete($menu->imagen);
            }
            $data['imagen'] = $request->file('imagen')->store('menus', 'public');
        }

        $menu->update($data);

        // Actualizar platos
        $menu->platos()->delete();

        if ($request->has('productos')) {
            foreach ($request->productos as $item) {
                if (!empty($item['id'])) {
                    $menu->platos()->create([
                        'producto_id' => $item['id'],
                        'notas'       => $item['notas'] ?? null,
                    ]);
                }
            }
        }

        return redirect()->route('menus.index')->with('success', 'Menú actualizado correctamente');
    }

    public function destroy(MenuDia $menu)
    {
        if ($menu->imagen && Storage::disk('public')->exists($menu->imagen)) {
            Storage::disk('public')->delete($menu->imagen);
        }

        $menu->delete();

        return redirect()->route('menus.index')->with('success', 'Menú eliminado correctamente');
    }
}
