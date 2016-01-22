<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSpecialOfferTables extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('special_offers', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('status')->default(1);
            $table->timestamps();
        });

        Schema::create('special_offer_nodes', function (Blueprint $table) {
            $table->unsignedInteger('special_offer_id')->nullable();
            $table->char('language_id', 2);
            $table->string('title');
            $table->longText('content')->nullable();
            $table->string('seo_description', 255)->nullable();
            $table->string('seo_title', 255)->nullable();
            $table->string('seo_keywords', 255)->nullable();
            $table->timestamps();

            $table->primary(['special_offer_id', 'language_id']);

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
        Schema::table('special_offer_nodes', function (Blueprint $table) {
            $table->dropForeign('special_offer_nodes_special_offer_id_foreign');
        });
        Schema::drop('special_offer_nodes');

        Schema::drop('special_offers');
    }
}
