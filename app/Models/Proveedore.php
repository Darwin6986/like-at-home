<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proveedore extends Model
{
    use HasFactory;

    protected $fillable = ['nombre', 'contacto', 'telefono', 'email', 'direccion'];

    public function compras()
    {
        return $this->hasMany(Compra::class);
    }
}
