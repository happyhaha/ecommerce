<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductSpecialOfferPivot extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_special_offer', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product_id')->unsigned()->nullable();
            $table->integer('special_offer_id')->unsigned()->nullable();
            $table->foreign('product_id')
                ->references('id')
                ->on('products')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');
            $table->foreign('special_offer_id')
                ->references('id')
                ->on('special_offers')
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
        Schema::table('product_special_offer', function (Blueprint $table) {
            $table->dropForeign('product_special_offer_product_id_foreign');
            $table->dropForeign('product_special_offer_special_offer_id_foreign');
        });
        Schema::drop('product_special_offer');
    }

}
