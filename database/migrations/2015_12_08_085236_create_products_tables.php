<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTables extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product_brand_id')->unsigned()->nullable();
            $table->string('slug')->nullable();
            $table->string('article_number')->nullable();
            $table->integer('price')->unsigned()->default(0);
            $table->integer('price_new')->unsigned()->default(0);
            $table->smallInteger('quantity')->unsigned()->default(0);
            $table->tinyInteger('type')->unsigned()->default(0);
            $table->tinyInteger('rating')->unsigned()->default(0);
            $table->boolean('is_hot')->default(0);
            $table->boolean('status')->default(1);
            $table->timestamps();

            $table->index(['product_brand_id']);
            $table->index(['slug','status']);
            $table->index(['id','status']);

            $table->foreign('product_brand_id')
                    ->references('id')
                    ->on('product_brands')
                    ->onUpdate('CASCADE')
                    ->onDelete('SET NULL');
        });

        Schema::create('product_nodes', function (Blueprint $table) {
            $table->unsignedInteger('product_id');
            $table->char('language_id', 2);
            $table->string('title');
            $table->text('content')->nullable();
            $table->string('delivery')->nullable();
            $table->string('preparing')->nullable();
            $table->text('review')->nullable();
            $table->string('warranty_short')->nullable();
            $table->text('warranty')->nullable();
            $table->text('additional')->nullable();
            $table->string('seo_description', 255)->nullable();
            $table->string('seo_title', 255)->nullable();
            $table->string('seo_keywords', 255)->nullable();

            $table->primary(['product_id', 'language_id']);

            $table->foreign('product_id')
                    ->references('id')
                    ->on('products')
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
        Schema::table('product_nodes', function (Blueprint $table) {
            $table->dropForeign('product_nodes_product_id_foreign');
        });
        Schema::drop('product_nodes');

        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign('products_product_brand_id_foreign');
        });
        Schema::drop('products');
    }

}
