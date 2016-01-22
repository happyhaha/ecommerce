<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderTables extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned()->nullable();
            $table->tinyInteger('payment_type')->default(0);
            $table->tinyInteger('delivery_type')->default(0);
            $table->integer('delivery_price')->default(0);
            $table->string('city', 255);
            $table->string('address', 255);
            $table->text('comment');
            $table->integer('total_price')->unsigned();
            $table->tinyInteger('payment_status')->default(0);
            $table->timestamps();
            $table->tinyInteger('status')->default(0);

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onUpdate('CASCADE')
                ->onDelete('SET NULL');
        });

        Schema::create('order_items', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('order_id')->unsigned()->nullable();
            $table->integer('product_id')->unsigned()->nullable();
            $table->integer('price')->default(0);
            $table->tinyInteger('count')->default(0);
            $table->tinyInteger('status')->default(1);

            $table->foreign('order_id')
                ->references('id')
                ->on('orders')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');
            $table->foreign('product_id')
                ->references('id')
                ->on('products')
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
        Schema::table('order_items', function (Blueprint $table) {
            $table->dropForeign('order_items_order_id_foreign');
            $table->dropForeign('order_items_product_id_foreign');
        });
        Schema::drop('order_items');

        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign('orders_user_id_foreign');
        });
        Schema::drop('orders');
    }

}
