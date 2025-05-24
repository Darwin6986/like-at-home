<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\MenuPlato;

class MenuDia extends Model
{
    use HasFactory;

    protected $table = 'menu_dias';

    protected $fillable = [
        'fecha',
        'nombre_plato',
        'precio',
        'cantidad',
        'descripcion',
        'imagen',
        'activo',
    ];

    public function platos()
    {
        return $this->hasMany(MenuPlato::class, 'menu_id');
    }
}
