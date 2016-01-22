<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductProductSectorPivot extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_product_sector', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product_id')->unsigned()->nullable();
            $table->integer('product_sector_id')->unsigned()->nullable();
            $table->foreign('product_id')
                ->references('id')
                ->on('products')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');
            $table->foreign('product_sector_id')
                ->references('id')
                ->on('product_sectors')
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
        Schema::table('product_product_sector', function (Blueprint $table) {
            $table->dropForeign('product_product_sector_product_id_foreign');
            $table->dropForeign('product_product_sector_product_sector_id_foreign');
        });
        Schema::drop('product_product_sector');
    }
}
