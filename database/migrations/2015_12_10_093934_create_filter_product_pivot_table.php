<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFilterProductPivotTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('filter_product', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product_id')->unsigned()->nullable();
            $table->integer('filter_id')->unsigned()->nullable();
            $table->foreign('product_id')
                ->references('id')
                ->on('products')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');
            $table->foreign('filter_id')
                ->references('id')
                ->on('filters')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Сам в шоке он получившихся ключей
        Schema::table('filter_product', function (Blueprint $table) {
            $table->dropForeign('filter_product_product_id_foreign');
            $table->dropForeign('filter_product_filter_id_foreign');
        });
        Schema::drop('filter_product');
    }

}
