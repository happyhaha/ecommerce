<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFiltersTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('filters', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('filter_group_id')->unsigned()->nullable();
            $table->tinyInteger('sort_order')->unsigned()->default(0);
            $table->timestamps();

            $table->foreign('filter_group_id')
                ->references('id')
                ->on('filter_group')
                ->onUpdate('CASCADE')
                ->onDelete('SET NULL');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('filters', function (Blueprint $table) {
            $table->dropForeign('filters_filter_group_id_foreign');
        });
        Schema::drop('filters');
    }
}
