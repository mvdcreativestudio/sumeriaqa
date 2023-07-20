<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePosOrderProductsTable extends Migration
{
    public function up()
    {
        Schema::create('posorderproducts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pos_order_id');
            $table->unsignedBigInteger('product_id');
            $table->integer('cantidad');
            $table->timestamps();

            $table->foreign('pos_order_id')->references('id')->on('posorders')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('posorderproducts');
    }
}