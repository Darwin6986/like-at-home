<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Compra extends Model
{
    use HasFactory;

    protected $fillable = ['proveedor_id', 'fecha', 'total', 'metodo_pago'];

    public function proveedor()
    {
        return $this->belongsTo(Proveedore::class);
    }

    public function detalles()
    {
        return $this->hasMany(CompraDetalle::class);
    }
}
