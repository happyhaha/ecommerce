<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeColumnsInProductCategories extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product_category_nodes', function (Blueprint $table) {
            $table->dropColumn('slug');
        });

        Schema::table('product_categories', function (Blueprint $table) {
            $table->string('slug', 60)->after('depth')->nullable();
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
            $table->string('slug', 60)->after('title')->nullable();
        });

        Schema::table('product_categories', function (Blueprint $table) {
            $table->dropColumn('slug');
        });
    }
}
