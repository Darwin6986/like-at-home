<?php

/*use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
*/
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\CompraController;
use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\VentaController;
use App\Http\Controllers\MenuDiaController;
use App\Http\Controllers\ReporteController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/bienvenida', function () {
    return view('admin.dashboard');
});
Route::resource('productos', ProductoController::class);
Route::resource('categorias', CategoriaController::class);
Route::resource('compras', CompraController::class);
Route::resource('proveedores', ProveedorController::class);
Route::resource('ventas', VentaController::class);
Route::resource('menus', MenuDiaController::class);
Route::get('reportes/ventas', [\App\Http\Controllers\ReporteController::class, 'reporteVentas'])->name('reportes.ventas');
Route::get('reportes/ventas/pdf', [\App\Http\Controllers\ReporteController::class, 'ventasPDF'])->name('reportes.ventas.pdf');
Route::get('reportes/ventas/excel', [\App\Http\Controllers\ReporteController::class, 'ventasExcel'])->name('reportes.ventas.excel');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
