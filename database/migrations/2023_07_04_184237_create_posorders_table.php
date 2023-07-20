<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePosOrdersTable extends Migration
{
    public function up()
    {
        Schema::create('posorders', function (Blueprint $table) {
            $table->id();
            $table->string('forma_entrega');
            $table->string('medio_pago');
            // Otros campos necesarios para la orden
            $table->decimal('total', 8, 2)->default(0); // Campo "total" con precision de 8 dígitos y 2 decimales, con valor predeterminado de 0
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('posorders');
    }
}
