<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductProductCategoryPivotTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_product_category', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product_id')->unsigned()->nullable();
            $table->integer('product_category_id')->unsigned()->nullable();
            $table->foreign('product_id')
                    ->references('id')
                    ->on('products')
                    ->onUpdate('CASCADE')
                    ->onDelete('CASCADE');
            $table->foreign('product_category_id')
                ->references('id')
                ->on('product_categories')
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
        Schema::table('product_product_category', function (Blueprint $table) {
            $table->dropForeign('product_product_category_product_id_foreign');
            $table->dropForeign('product_product_category_product_category_id_foreign');
        });
        Schema::drop('product_product_category');
    }
}
