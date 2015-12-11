<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFilterGroupTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('filter_group', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product_category_id')->unsigned()->nullable();
            $table->tinyInteger('type')->unsigned()->default(1);
            $table->string('postfix', 50);
            $table->tinyInteger('sort_order')->unsigned()->default(0);
            $table->timestamps();

            $table->index(['product_category_id']);

            $table->foreign('product_category_id')
                ->references('id')
                ->on('product_categories')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('filter_group', function (Blueprint $table) {
            $table->dropForeign('filter_group_product_category_id_foreign');
        });
        Schema::drop('filter_group');
    }
}
