<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuPlato extends Model
{
    use HasFactory;

    protected $fillable = ['menu_id', 'producto_id', 'notas'];

    public function menu()
    {
        return $this->belongsTo(MenuDia::class, 'menu_id');
    }

    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }
}
