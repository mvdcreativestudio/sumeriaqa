<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContabilidadUsuariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contabilidad_usuarios', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre');
            $table->string('empresa')->nulleable()->default('NULL');
            $table->string('rut')->nulleable()->default('NULL');
            $table->enum('tipo_usuario', ['Proveedor', 'Cliente'])->default('Cliente');
            $table->string('direccion')->nulleable()->default('NULL');
            $table->enum('pais', ['Uruguay', 'Argentina', 'Brasil', 'Chile', 'Paraguay'])->default('Uruguay');
            $table->string('departamento');
            $table->string('telefono')->nulleable()->default('NULL');
            $table->string('email');
            $table->enum('status', ['activo', 'inactivo'])->default('activo');
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
        Schema::dropIfExists('contabilidad_usuarios');
    }
}
