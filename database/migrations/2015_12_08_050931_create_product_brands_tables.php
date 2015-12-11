<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductBrandsTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_brands', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
        });

        Schema::create('product_brand_nodes', function (Blueprint $table) {
            $table->unsignedInteger('product_brand_id');
            $table->char('language_id', 2);
            $table->string('title');
            $table->longText('content')->nullable();
            $table->string('seo_description', 255)->nullable();
            $table->string('seo_title', 255)->nullable();
            $table->string('seo_keywords', 255)->nullable();
            $table->timestamps();

            $table->primary(['product_brand_id', 'language_id']);

            $table->foreign('product_brand_id')
                    ->references('id')
                    ->on('product_brands')
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
        Schema::table('product_brand_nodes', function (Blueprint $table) {
            $table->dropForeign('product_brand_nodes_product_brand_id_foreign');
        });
        Schema::drop('product_brand_nodes');

        Schema::drop('product_brands');
    }
}
