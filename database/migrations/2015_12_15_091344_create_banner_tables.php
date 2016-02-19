<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBannerTables extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('banners', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 255);
            $table->string('link', 255);
            $table->boolean('is_blank')->default(false);
            $table->smallInteger('width')->unsigned();
            $table->smallInteger('height')->unsigned();
            $table->text('code')->default(null);
            $table->smallInteger('max_views')->default(0);
            $table->smallInteger('current_views')->default(0);
            $table->timestamp('untill_at')->nullable();
            $table->timestamps();
            $table->boolean('status')->default(1);
        });

        Schema::create('banner_locations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('banner_id')->unsigned()->nullable();
            $table->tinyInteger('location')->unsigned()->default(1);

            $table->foreign('banner_id')
                ->references('id')
                ->on('banners')
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
        Schema::table('banner_locations', function (Blueprint $table) {
            $table->dropForeign('banner_locations_banner_id_foreign');
        });
        Schema::drop('banner_locations');
        Schema::drop('banners');
    }

}
