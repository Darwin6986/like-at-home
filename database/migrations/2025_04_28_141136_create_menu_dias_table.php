<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('menu_dias', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_plato');
            $table->string('precio');
            $table->decimal('cantidad', 10, 2);
            $table->date('fecha');
            $table->text('descripcion');
            $table->string('imagen');
            $table->boolean('activo')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('menu_dias');
    }
};
