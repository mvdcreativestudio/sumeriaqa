<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContabilidadTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contabilidad', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('usuario_id');
            $table->string('nombre_cliente');
            $table->enum('tipo', ['Cobro', 'Pago'])->default('Cobro');
            $table->string('concepto')->nullable();
            $table->integer('monto');
            $table->date('fecha_vencimiento');
            $table->enum('estado', ['Pago', 'Impago'])->default('Impago');
            $table->string('estado_vencimiento')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contabilidad');
    }
}
