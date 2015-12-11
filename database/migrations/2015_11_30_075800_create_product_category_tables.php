<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductCategoryTables extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('parent_id')->nullable();
            $table->integer('lft')->nullable()->index();
            $table->integer('rgt')->nullable()->index();
            $table->integer('depth')->nullable();
            $table->timestamps();

            $table->foreign('parent_id')
                ->references('id')
                ->on('product_categories')
                ->onUpdate('CASCADE')
                ->onDelete('SET NULL');
        });

        Schema::create('product_category_nodes', function (Blueprint $table) {
            $table->unsignedInteger('product_category_id');
            $table->char('language_id', 2);
            $table->string('title');
            $table->string('slug', 60);
            $table->longText('content')->nullable();
            $table->string('seo_description', 255)->nullable();
            $table->string('seo_title', 255)->nullable();
            $table->string('seo_keywords', 255)->nullable();
            $table->timestamps();

            $table->primary(['product_category_id', 'language_id']);

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
        Schema::table('product_category_nodes', function (Blueprint $table) {
            $table->dropForeign('product_category_nodes_product_category_id_foreign');
        });
        Schema::drop('product_category_nodes');

        Schema::table('product_categories', function (Blueprint $table) {
            $table->dropForeign('product_categories_parent_id_foreign');
        });
        Schema::drop('product_categories');

    }

}
