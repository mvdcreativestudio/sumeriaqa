<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNotifyQuantityToProductsTable3 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->unsignedInteger('notify_quantity')->nullable();
        });

        Schema::table('stock_limit', function (Blueprint $table) {
            $table->unsignedInteger('notify_quantity')->nullable();

            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade')->name('stock_limit_product_id_foreign_new');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('stock_limit', function (Blueprint $table) {
            $table->dropForeign(['product_id']);
            $table->dropColumn('notify_quantity');
        });

        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('notify_quantity');
        });
    }
}