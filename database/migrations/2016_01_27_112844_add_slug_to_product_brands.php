<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSlugToProductBrands extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product_brands', function (Blueprint $table) {
            $table->string('slug', 255)->nullable()->after('id');
            $table->boolean('status')->default(1)->nullable()->after('slug');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product_brands', function (Blueprint $table) {
            $table->dropColumn('slug');
            $table->dropColumn('status');
        });
    }

}
