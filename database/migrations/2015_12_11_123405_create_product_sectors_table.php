<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductSectorsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_sectors', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
        });

        Schema::create('product_sector_nodes', function (Blueprint $table) {
            $table->unsignedInteger('product_sector_id')->nullable();
            $table->char('language_id', 2);
            $table->string('title');
            $table->longText('content')->nullable();
            $table->string('seo_description', 255)->nullable();
            $table->string('seo_title', 255)->nullable();
            $table->string('seo_keywords', 255)->nullable();
            $table->timestamps();

            $table->primary(['product_sector_id', 'language_id']);

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
        Schema::table('product_sector_nodes', function (Blueprint $table) {
            $table->dropForeign('product_sector_nodes_product_sector_id_foreign');
        });
        Schema::drop('product_sector_nodes');

        Schema::drop('product_sectors');
    }

}
